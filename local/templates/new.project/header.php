<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
* @global CMain $APPLICATION
* @global CUser $USER
*/

include realpath(__DIR__ . '../functions.php');

if( function_exists('find_section') ) {
    if( $sidebar = find_section('sidebar') ) {
        $APPLICATION->SetPageProperty('content-class', 'col-10');
    }
}

?><!DOCTYPE html>
<html class="no-js" lang="ru-RU">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><? $APPLICATION->ShowTitle() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
    enqueue_template_assets();

    // BITRIX ->ShowHead()
    CJSCore::Init(array("fx"));

    $APPLICATION->ShowMeta("robots", false);
    $APPLICATION->ShowMeta("keywords", false);
    $APPLICATION->ShowMeta("description", false);
    $APPLICATION->ShowLink("canonical", null);
    $APPLICATION->ShowCSS(true);
    $APPLICATION->ShowHeadStrings();
    $APPLICATION->ShowHeadScripts();
    ?>

    <!-- IE compatibility -->
    <!--[if lt IE 9]>
    <script data-skip-moving="true" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <script data-skip-moving="true">var isIE = true;</script>
    <![endif]-->
    <script data-skip-moving="true">
        var isIE = false /*@cc_on || true @*/;
        if( isIE ) {
            document.createElement( "picture" );
            document.write('<script src="https:\/\/cdnjs.cloudflare.com\/ajax\/libs\/picturefill\/3.0.3\/picturefill.min.js" async><\/script>');
        }

        // if( isIE || /Edge/.test(navigator.userAgent) ) {
        //     document.write(\'<script src="\/assets\/polyfill-svg-uri\/polyfill-svg-uri.min.js" async><\/script>\');
        // }
    </script>
</head>
<body <?php body_class(); ?>>
    <?$APPLICATION->ShowPanel();?>
    <!--[if lte IE 9]>
        <p class="browserupgrade">Вы используете <strong>устаревший</strong> браузер. Пожалуйста <a href="https://browsehappy.com/">обновите ваш браузер</a> для лучшего отображения и безопасности.</p>
    <![endif]-->
    <div id="page" class="site">

        <header class="site-header">
            <!-- <div itemscope itemtype="http://schema.org/LocalBusiness"> -->
                <div class="container">
                    <div class="row align-items-center head-info">
                        <div class="col-4 logotype">
                            <?$APPLICATION->IncludeFile(
                                SITE_DIR . "include/head.logotype.php",
                                array(),
                                Array("MODE" => "html")
                            );?>
                        </div>
                        <div class="col-4 contacts">
                            <!-- Contacts -->
                            <?$APPLICATION->IncludeFile(
                                SITE_DIR . "include/head.contacts.php",
                                array(),
                                Array("MODE" => "html")
                            );?>
                        </div>
                        <div class="col-4 callback">
                            <!-- <a href="#" id="get-callback"></a> -->
                            <?$APPLICATION->IncludeFile(
                                SITE_DIR . "include/head.numbers.php",
                                array(),
                                Array("MODE" => "html")
                            );?>
                        </div>
                    </div><!--.row head-info-->
                </div>

                <!-- <div class="hidden-xs-up">
                    <span itemprop="priceRange">RUB</span>
                </div> -->
            <!-- </div> -->
        </header><!-- .site-header -->

        <section class="site-navigation navbar-default">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <div class="navbar-brand hidden-lg-up text-center text-primary"><a href="/">Brand name</a></div>

                    <button class="navbar-toggler hamburger hamburger--elastic" type="button" data-toggle="collapse" data-target="#site-nav" aria-controls="site-nav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>

                    <div class="collapse navbar-collapse" id="site-nav">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "bootstrap_multilevel",
                            array(
                                "COMPONENT_TEMPLATE" => "bootstrap_multilevel",
                                "ROOT_MENU_TYPE" => "top",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => "top",
                                "USE_EXT" => "N",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                            ),
                            false
                        );?>

                        <form class="form-inline my-2 my-lg-0" action="/search/">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </nav>
        </section>

        <?if( !is_front_page() ):?>
        <section class="breadcrumb">
            <div class="container">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb", 
                    ".default", 
                    array(
                        "PATH" => "",
                        "SITE_ID" => "s1",
                        "START_FROM" => "0",
                        "COMPONENT_TEMPLATE" => ".default"
                    ),
                    false
                );?>
            </div>
        </section>
        <?endif?>

        <div id="content" class="site-content <?
            $APPLICATION->ShowProperty("container-class", "container");
            if(is_front_page()) echo '-fluid';
        ?>">
            <div class="row">
                <main id="primary" class="main content <?$APPLICATION->ShowProperty( "content-class", 'col-12' );?>" role="main">