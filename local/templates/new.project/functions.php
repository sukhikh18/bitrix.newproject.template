<?php

use \Bitrix\Main;

if( !defined('TPL') ) define('TPL', SITE_TEMPLATE_PATH);
if( !defined('THEME') ) define('THEME', $_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH);

if( !function_exists('enqueue_template_assets') ) {
    function enqueue_template_assets() {
        /** @var $APPLICATION CMain */
        global $APPLICATION;

        /** @var $Asset Main\Page\Asset */
        $Asset = \Bitrix\Main\Page\Asset::getInstance();

        // Place favicon.ico in the root directory
        $Asset->addString('<link rel="shortcut icon" href="/favicon.ico" />');
        // $Asset->addString('<link rel="apple-touch-icon" href="/favicon.png" />');
        // $Asset->addString('<link rel="manifest" href="site.webmanifest">');

        /**
         * @see Настройки > Настройки продукта > Настройки модулей > Настройки главного модуля => Оптимизация CSS
         */
        $min = ("Y" !== Main\Config\Option::get("main", "use_minified_assets")) ? '' : '.min';

        // \CJSCore::Init( array('jquery') );
        $Asset->addJs('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js');
        $Asset->addJs('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js');

        $Asset->addString('<script>window.jQuery || document.write(\'<script src="'.
            str_replace('/', '\/', TPL) .'\/assets\/vendor\/jquery\/jquery.min.js"><\/script>\')</script>');

        /**
         * Bootstrap framework
         */
        $Asset->addCss(TPL . '/assets/vendor/bootstrap'.$min.'.css');
        $Asset->addJs( TPL . '/assets/vendor/bootstrap'.$min.'.js');

        /**
         * Responsive mobile menu with animation
         */
        $Asset->addCss(TPL . '/assets/vendor/hamburgers'.$min.'.css');

        /**
         * Slick slider
         */
        $Asset->addCss(TPL . '/assets/vendor/slick/slick.css');
        $Asset->addJs( TPL . '/assets/vendor/slick/slick'.$min.'.js');

        /**
         * Fancybox modal
         */
        $Asset->addCss(TPL . '/assets/vendor/fancybox/jquery.fancybox'.$min.'.css');
        $Asset->addJs( TPL . '/assets/vendor/fancybox/jquery.fancybox'.$min.'.js');

        // Masked input
        // $Asset->addJs('https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.3/cleave.min.js');

        // VK Api
        // $Asset->addJs('https://vk.com/js/api/openapi.js?152');

        // Font Awesome (Icons)
        // $Asset->addCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css');

        // Animate
        // $Asset->addCss(TPL . '/assets/vendor/animate'.$min.'.css');

        $Asset->addJs(TPL . '/assets/main'.$min.'.js');
        $Asset->addCss(TPL . '/assets/template'.$min.'.css');

        // Add custom page style
        $curDir = is_front_page() ? '/index' : $APPLICATION->GetCurDir();

        $scriptPath = rtrim('/pages' . $curDir, '/') . '/script'. $min .'.js';
        if( file_exists(THEME . $scriptPath) ) {
            $Asset->addJs(TPL . $scriptPath);
        }

        $stylePath = rtrim('/pages' . $curDir, '/') . '/style'. $min .'.css';
        if( file_exists(THEME . $stylePath) ) {
            $Asset->addCss(TPL . $stylePath);
        }
    }
}

if( !function_exists('recursive_terms_list') ) {
    /**
     * Рекурсивно получить ненумерованный(UL) список секций
     * @param Array  $arSections  Масив обработанный по принципу @see get_terms_hierarchical
     * @param Array   $params     Список параметров
     * @param object  $tpl        Экземпляр шаблона компанента CBitrixComponentTemplate
     *                            В случае, если нужно установить сссылки на редактирование и удаление
     */
    function recursive_terms_list( $arSections, Array $params, $tpl = false ) {
        if( empty($arSections) || !is_array($arSections) )
            return false;

        $params = bx_parse_args( $params, array(
            'level' => 0,
            'list_class' => 'unstyled',
            'item_class' => 'item',
            'link_class' => 'item__link',
            'count_elements' => false,
        ) );
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
                $params["count_elements"] ?
                    sprintf('<small>(%d)</small>', $arSection['ELEMENT_CNT']) : ''
            );

            if( isset($arSection['CHILD']) && is_array($arSection['CHILD']) )
                recursiveTermsUList($arSection['CHILD'], $params);

            echo "</li>";
        }
        printf('</ul><!-- .list-%s -->', $params['list_class']);
    }
}
