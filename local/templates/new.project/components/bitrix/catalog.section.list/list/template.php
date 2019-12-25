<?
if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

// Parent section title.
if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID']) {
    $this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
    $this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete,
        $arSectionDeleteParams);

    printf('<h1 id="%s" class="%s"><a href="%s">%s</a></h1>',
        $this->GetEditAreaId($arResult['SECTION']['ID']),
        $arCurView['TITLE'],
        $arResult['SECTION']['SECTION_PAGE_URL'],
        ! empty($arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"])
            ? $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
            : $arResult['SECTION']['NAME']
    );
}

if( ! function_exists('recursive_terms_ulist') ) {
    /**
     * Рекурсивно вывести ненумерованный(UL) список секций
     *
     * @param Array  $arSections             Масив обработанный по принципу @see get_terms_hierarchical
     * @param Array  $params                 Список параметров
     * @param CBitrixComponentTemplate  $tpl Экземпляр шаблона компанента CBitrixComponentTemplate
     *                             В случае, если нужно установить сссылки на редактирование и удаление
     */
    function recursive_terms_ulist( $arSections, Array $params, $tpl = false ) {
        if( empty($arSections) || !is_array($arSections) ) return false;
        if( !is_array() ) $params = array();

        $params = bx_parse_args( $params, array(
            'level' => 0,
            'list_class' => 'unstyled',
            'item_class' => 'item',
            'link_class' => 'item__link',
            'count_elements' => false,
        ) );
        // @todo
        $params['level'] = 1;

        printf('<ul class="list-%s%s">',
            $params['list_class'],
            (1 > $params['level']) ? ' sub-list level-' . $params['level'] : '');

        foreach ($arSections as $arSection) {
            if( $tpl ) {
                $tpl->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'],
                    CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
                $tpl->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'],
                    CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"),
                    array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));

                printf('<li class="%s" id="%s">', $params['item_class'], $tpl->GetEditAreaId($arSection['ID']) );
            }
            else {
                printf('<li class="%s">', $params['item_class']);
            }

            printf('<a class="%s" href="%s">%s</a>%s',
                $params['link_class'],
                $arSection['SECTION_PAGE_URL'],
                $arSection['NAME'],
                $params["count_elements"] ? sprintf('<small>(%d)</small>', $arSection['ELEMENT_CNT']) : ''
            );

            if( isset($arSection['CHILD']) && is_array($arSection['CHILD']) )
                recursive_terms_ulist($arSection['CHILD'], $params);

            echo "</li>";
        }
        printf('</ul><!-- .list-%s -->', $params['list_class']);
    }
}

recursive_terms_ulist($arResult['SECTIONS'], array(
    'list_class' => $arParams['ROW_CLASS'],
), $this);
