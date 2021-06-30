<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CMain $APPLICATION */
global $APPLICATION;
/** @var \Bitrix\Main\Page\Asset $Asset */
$Asset = \Bitrix\Main\Page\Asset::getInstance();

?><!DOCTYPE html>
<html class="no-js" lang="ru-RU">
<head>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php $APPLICATION->ShowTitle() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
    // Place favicon.ico in the root directory
    $Asset->addString('<link rel="shortcut icon" href="/favicon.ico" />');
    // $Asset->addString('<link rel="apple-touch-icon" href="/favicon.png" />');
    // $Asset->addString('<link rel="manifest" href="site.webmanifest">');

    // \CJSCore::Init( array('jquery') );
    $Asset->addJs('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js');
    $Asset->addString(sprintf(
        '<script>window.jQuery || document.write(\'<script src="%s"><\/script>\')</script>',
        str_replace('/', '\/', SITE_TEMPLATE_PATH . '/assets/vendor/jquery/jquery.min.js')
    ));

    // Bitrix has own small modernizr.
    // $Asset->addJs('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js');

    // Bootstrap framework
    $Asset->addCss(SITE_TEMPLATE_PATH . '/assets/vendor/bootstrap.min.css');
    $Asset->addJs(SITE_TEMPLATE_PATH . '/assets/vendor/bootstrap/bootstrap.min.js');

    // Responsive mobile menu with animation
    $Asset->addCss(SITE_TEMPLATE_PATH . '/assets/vendor/hamburgers.min.css');

    // Slick slider
    $Asset->addCss(SITE_TEMPLATE_PATH . '/assets/vendor/slick/slick.css');
    $Asset->addJs(SITE_TEMPLATE_PATH . '/assets/vendor/slick/slick.min.js');

    // Fancybox
    $Asset->addCss(SITE_TEMPLATE_PATH . '/assets/vendor/fancybox/jquery.fancybox.min.css');
    $Asset->addJs(SITE_TEMPLATE_PATH . '/assets/vendor/fancybox/jquery.fancybox.min.js');

    // Cleave
    $Asset->addJs(SITE_TEMPLATE_PATH . '/assets/vendor/cleave/cleave.min.js');
    $Asset->addJs(SITE_TEMPLATE_PATH . '/assets/vendor/cleave/addons/cleave-phone.ru.js');

    // Masked input
    // $Asset->addJs('https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.3/cleave.min.js');

    // VK Api
    // $Asset->addJs('https://vk.com/js/api/openapi.js?152');

    // Font Awesome (Icons)
    // $Asset->addCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css');

    // Animate
    // $Asset->addCss(SITE_TEMPLATE_PATH . '/assets/vendor/animate'.$min.'.css');

    $Asset->addJs(SITE_TEMPLATE_PATH . '/assets/script.js');
    $Asset->addCss(SITE_TEMPLATE_PATH . '/assets/template.min.css');

    $APPLICATION->ShowHead();
    ?>
</head>
<body class="page page_<?= LANGUAGE_ID ?> page_type_<?php $APPLICATION->ShowProperty('page_type', 'secondary')?>">
    <?php $APPLICATION->ShowPanel(); ?>
    <!--[if lte IE 9]>
    <p class="browserupgrade">Вы используете <strong>устаревший</strong> браузер. Пожалуйста <a
            href="https://browsehappy.com/">обновите ваш браузер</a> для лучшего отображения и безопасности.</p>
    <![endif]-->

    <header class="page__header"><!-- itemscope itemtype="http://schema.org/LocalBusiness" -->
        <div class="container">
            <div class="masthead row align-items-center">
                <div class="masthead__logotype col-4">
                    <? $APPLICATION->IncludeFile(
                        SITE_DIR . "local/include/logotype.php",
                        array(),
                        Array("MODE" => "html")
                    ); ?>
                </div>
                <div class="masthead__contacts col-4">
                    <? $APPLICATION->IncludeFile(
                        SITE_DIR . "local/include/head.contacts.php",
                        array(),
                        Array("MODE" => "html")
                    ); ?>
                </div>
                <div class="masthead__callback col-4">
                    <? $APPLICATION->IncludeFile(
                        SITE_DIR . "local/include/head.numbers.php",
                        array(),
                        Array("MODE" => "html")
                    ); ?>
                </div>
            </div>
            <!-- .masthead -->
        </div>
        <!-- <div class="hidden-xs-up"><span itemprop="priceRange">RUB</span></div> -->
    </header>
    <!-- .page__header -->

    <section class="page__navigation navbar-default">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <div class="navbar-brand hidden-lg-up text-center text-primary"><a href="/">Brand name</a></div>

                <button class="navbar-toggler hamburger hamburger--elastic" type="button" data-toggle="collapse"
                        data-target="#site-nav" aria-controls="site-nav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                </button>

                <div class="collapse navbar-collapse" id="site-nav">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bootstrap_multilevel",
                        array(
                            "COMPONENT_TEMPLATE" => "bootstrap_multilevel",
                            "ROOT_MENU_TYPE" => "top",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => array(),
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "top",
                            "USE_EXT" => "N",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                        ),
                        false
                    ); ?>

                    <form class="form-inline my-2 my-lg-0" action="/search/">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </section>
    <!-- .page__navigation -->

    <section class="page__breadcrumb breadcrumb">
        <div class="container">
            <? $APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                ".default",
                array(
                    "PATH" => "",
                    "SITE_ID" => SITE_ID,
                    "START_FROM" => "0",
                ),
                false
            ); ?>
        </div>
    </section>
    <!-- .page__breadcrumb -->

    <div id="page_content" class="<?php $APPLICATION->ShowProperty("page__conetnt_class", "page__content container"); ?>">
