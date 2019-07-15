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
        // $Asset->addJs(TPL . '/assets/jquery.maskedinput.min.js');
        $Asset->addString('<script>window.jQuery || document.write(\'<script src="'.
            str_replace('/', '\/', TPL) .'\/assets\/jquery\/jquery.min.js"><\/script>\')</script>');

        $Asset->addJs('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js');

        /**
         * Bootstrap
         */
        $Asset->addCss(TPL . '/assets/bootstrap'.$min.'.css');
        $Asset->addJs( TPL . '/assets/bootstrap'.$min.'.js');

        /**
         * Slick
         */
        $Asset->addCss(TPL . '/assets/slick/slick.css');
        $Asset->addJs( TPL . '/assets/slick/slick'.$min.'.js');

        /**
         * Fancybox
         */
        $Asset->addCss(TPL . '/assets/fancybox/jquery.fancybox'.$min.'.css');
        $Asset->addJs( TPL . '/assets/fancybox/jquery.fancybox'.$min.'.js');

        /**
         * Hamburgers (mobile menu style)
         */
        $Asset->addCss(TPL . '/assets/hamburgers'.$min.'.css');

        // Sticky
        // $Asset->addJs( TPL . '/assets/sticky/jquery.sticky'.$min.'.js');

        // Masonry
        // $Asset->addJs(TPL . '/assets/masonry/masonry.pkgd'.$min.'.js');

        // VK Api
        // $Asset->addJs('https://vk.com/js/api/openapi.js?152');

        // Font Awesome
        // $Asset->addCss('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/assets/font-awesome.min.css');

        // Animate
        // $Asset->addCss(TPL . '/assets/animate'.$min.'.css');

        // Form's custom style
        // $Asset->addCss(TPL . '/assets/jquery.formstyler.css');

        $Asset->addCss(TPL . '/template'.$min.'.css');
        $Asset->addJs(TPL . '/assets/main'.$min.'.js');

        // Add custom page style
        $curDir = is_front_page() ? '/index' : $APPLICATION->GetCurDir();
        $path = rtrim('/pages' . $curDir, '/') . '/style'. $min .'.css';
        if( file_exists(THEME . $path) ) {
            $Asset->addCss(TPL . $path);
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
