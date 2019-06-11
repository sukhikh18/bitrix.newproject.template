<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use \Bitrix\Main;

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

if( !defined('TPL') ) define('TPL', SITE_TEMPLATE_PATH);

$assets = Main\Page\Asset::getInstance();
/**
 * @see Настройки > Настройки продукта > Настройки модулей > Настройки главного модуля => Оптимизация CSS
 */
$min = ("N" == Main\Config\Option::get("main", "use_minified_assets")) ? '' : '.min';

/**
 * BITRIX ->ShowHead()
 */
CJSCore::Init(array("fx"));

// Place favicon.ico in the root directory
$assets->addString('<link rel="shortcut icon" href="/favicon.ico" />');
// $assets->addString('<link rel="apple-touch-icon" href="/favicon.png" />');
// $assets->addString('<link rel="manifest" href="site.webmanifest">');

$APPLICATION->ShowMeta("robots", false);
$APPLICATION->ShowMeta("keywords", false);
$APPLICATION->ShowMeta("description", false);
$APPLICATION->ShowLink("canonical", null);
$APPLICATION->ShowCSS(true);
$APPLICATION->ShowHeadStrings();
$APPLICATION->ShowHeadScripts();

// $assets->addJs( TPL . '/js/vendor/modernizr-3.6.0.min.js');

/**
 * Bootstrap
 */
$assets->addCss(TPL . '/assets/bootstrap'.$min.'.css');
$assets->addJs( TPL . '/assets/bootstrap'.$min.'.js');

/**
 * Sticky
 */
$assets->addJs( TPL . '/assets/sticky/jquery.sticky'.$min.'.js');

/**
 * Slick
 */
$assets->addCss(TPL . '/assets/slick/slick.css');
$assets->addJs( TPL . '/assets/slick/slick'.$min.'.js');

/**
 * Fancybox
 */
$assets->addCss(TPL . '/assets/fancybox/jquery.fancybox'.$min.'.css');
$assets->addJs( TPL . '/assets/fancybox/jquery.fancybox'.$min.'.js');

/** Masonry */
// $assets->addJs(TPL . '/assets/masonry/masonry.pkgd'.$min.'.js');

/** VK Api */
// $assets->addJs('https://vk.com/js/api/openapi.js?152');

$assets->addJs(TPL . '/assets/main.min.js');

// $assets->addCss('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/assets/font-awesome.min.css');
// $assets->addCss(TPL . '/assets/animate.min.css');
// $assets->addCss(TPL . '/assets/jquery.formstyler.css');

// \CJSCore::Init( array('jquery') );
$assets->addJs('http://code.jquery.com/jquery-3.2.1.min.js');
// $assets->addJs(TPL . '/assets/jquery.maskedinput.min.js');
