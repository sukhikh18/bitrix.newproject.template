<?php if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if( ! function_exists('html_build_args_cb')) {
    function html_build_args_cb($k, $val) {
        return " $k=\"" . htmlspecialcharsEx($val) . '"';
    }
}

if( ! function_exists('html_build_args')) {
    function html_build_args($attributes) {
        if( ! is_array($attributes)) return '';

        return implode('', array_map('html_build_args_cb', array_keys($attributes), $attributes));
    }
}

if( ! function_exists('recursive_sections_list')) {
    /**
     * Рекурсивно вывести ненумерованный(UL) список секций
     *
     * @param Array  $arSections             Масив обработанный по принципу @see get_terms_hierarchical
     * @param Array  $params                 Список параметров
     * @param CBitrixComponentTemplate  $tpl Экземпляр шаблона компанента CBitrixComponentTemplate
     *                             В случае, если нужно установить сссылки на редактирование и удаление
     */
    function recursive_sections_list( $arSections, $params = array(), $tpl = false ) {
        global $APPLICATION, $USER;

        if( empty($arSections) || !is_array($arSections) ) return false;
        if( !is_array($params) ) $params = array();

        $curPage = $APPLICATION->GetCurPage();

        $params = array_merge( array(
            'LEVEL' => 0,
            'LIST_CLASS' => 'list-unstyled',
            'ITEM_CLASS' => 'item',
            'LINK_CLASS' => 'item__link',
            'COUNT_ELEMENTS' => false,
        ), $params );

        $params['LEVEL']++;

        $listClass = $params['LIST_CLASS'];
        if( $params['LEVEL'] > 1 ) {
            $listClass .= " sub-list level-{$params['LEVEL']}";
        }

        printf('<ul class="%s">', $listClass);

        foreach ($arSections as $arSection) {
            $isActive = $curPage === $arSection['SECTION_PAGE_URL'];
            $attributes = array();

            if( $tpl && $USER->IsAdmin() ) {
                $tpl->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'],
                    CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
                $tpl->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'],
                    CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"),
                    array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));

                $attributes['id'] = $tpl->GetEditAreaId($arSection['ID']);
            }

            $attributes['class'] = $params['ITEM_CLASS'];
            if( isset($arSection['CHILD']) && is_array($arSection['CHILD']) ) $attributes['class'] .= ' has-child';
            if( $isActive ) $attributes['class'] .= ' active';

            printf('<li%s>', html_build_args($attributes));


            printf('<a class="%s" href="%s">%s</a>%s',
                $params['LINK_CLASS'],
                $arSection['SECTION_PAGE_URL'],
                $arSection['NAME'],
                $params["COUNT_ELEMENTS"] ? sprintf('<small>(%d)</small>', $arSection['ELEMENT_CNT']) : ''
            );

            if( isset($arSection['CHILD']) && is_array($arSection['CHILD']) )
                recursive_sections_list($arSection['CHILD'], $params);

            echo "</li>";
        }
        printf('</ul><!-- .list-%s -->', $params['LIST_CLASS']);
    }
}

if (empty($arParams["NAME_TAG"])) $arParams["NAME_TAG"] = 'h3';
if (empty($arParams['COLUMNS'])) $arParams['COLUMNS'] = 3;

$arParams['ROW_CLASS']    = ! empty($arParams['ROW_CLASS']) ? $arParams['ROW_CLASS'] : 'unstyled';
$arParams['COLUMN_CLASS'] = function_exists('get_column_class') ?
    get_column_class($arParams['COLUMNS']) : 'column-size-' . $arParams['COLUMNS'];

$arNewResult         = array();
$sectionLinc         = array();
$arNewResult['ROOT'] = array();
$sectionLinc[0]      = &$arNewResult['ROOT'];

foreach ($arResult['SECTIONS'] as $arSection) {
    $sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']] = $arSection;
    $sectionLinc[$arSection['ID']]                                                   = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
}
unset($sectionLinc);
$arResult['SECTIONS'] = (array)$arNewResult['ROOT']['CHILD'];

$res = CIBlock::GetByID($arParams['IBLOCK_ID']);
if ($ar_res = $res->GetNext()) {
    $arParams['IBLOCK_CODE'] = $ar_res['CODE'];
}
