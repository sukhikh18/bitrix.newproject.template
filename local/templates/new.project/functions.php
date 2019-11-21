<?php

use \Bitrix\Main;

if ( ! defined('TPL')) {
    define('TPL', SITE_TEMPLATE_PATH);
}
if ( ! defined('THEME')) {
    define('THEME', $_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH);
}

if ( ! function_exists('recursive_terms_list')) {
    /**
     * Рекурсивно получить ненумерованный(UL) список секций
     *
     * @param Array $arSections Масив обработанный по принципу @see get_terms_hierarchical
     * @param Array $params Список параметров
     * @param object $tpl Экземпляр шаблона компанента CBitrixComponentTemplate
     *                            В случае, если нужно установить сссылки на редактирование и удаление
     */
    function recursive_terms_list($arSections, Array $params, $tpl = false)
    {
        if (empty($arSections) || ! is_array($arSections)) {
            return false;
        }

        $params          = bx_parse_args($params, array(
            'level'          => 0,
            'list_class'     => 'unstyled',
            'item_class'     => 'item',
            'link_class'     => 'item__link',
            'count_elements' => false,
        ));
        $params['level'] = 1;

        printf('<ul class="list-%s%s">',
            $params['list_class'],
            (1 > $params['level']) ? ' sub-list level-' . $params['level'] : '');

        foreach ($arSections as $arSection) {
            if ($tpl) {
                $tpl->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'],
                    CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
                $tpl->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'],
                    CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"),
                    array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));

                printf('<li class="%s" id="%s">', $params['item_class'], $tpl->GetEditAreaId($arSection['ID']));
            } else {
                printf('<li class="%s">', $params['item_class']);
            }

            printf('<a class="%s" href="%s">%s</a>%s',
                $params['link_class'],
                $arSection['SECTION_PAGE_URL'],
                $arSection['NAME'],
                $params["count_elements"] ?
                    sprintf('<small>(%d)</small>', $arSection['ELEMENT_CNT']) : ''
            );

            if (isset($arSection['CHILD']) && is_array($arSection['CHILD'])) {
                recursiveTermsUList($arSection['CHILD'], $params);
            }

            echo "</li>";
        }
        printf('</ul><!-- .list-%s -->', $params['list_class']);
    }
}
