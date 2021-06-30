<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use \Bitrix\Main\Config\Option;

// Куда сохранять лог ошибок функцией AddMessage2Log (D7: Bitrix\Main\Diag\Debug::dumpToFile).
if ( !defined('LOG_FILENAME') ) define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/debug.log");
// Подключать полные версии стилей и скриптов вместо сжатых.
if ( !defined('SCRIPT_DEBUG') ) define('SCRIPT_DEBUG', "N" === Option::get("main", "use_minified_assets"));
// Тестовый емэйл (Емэйл с копиями сообщений для проверки работоспособности).
if ( !defined('DEVELOPER_TESTMAIL') ) define('DEVELOPER_TESTMAIL', 'trashmailsizh@yandex.ru');
// Переопределить адрес отправителя.
if ( !defined('EMAIL_FROM') ) define('EMAIL_FROM', '');
// Email адрес администратора.
if ( !defined('EMAIL_ADMIN') ) define('EMAIL_ADMIN', '');

/**
 * Static paths (Не использовать в SEF настройках компонентов, испортит .urlrewrite)
 */
define('PATH_TO_CATALOG', '/catalog/');

define('PATH_TO_AUTH',            '/user/');
define('PATH_TO_REGISTER',        PATH_TO_AUTH . '?register=yes');
define('PATH_TO_FORGOT_PASSWORD', PATH_TO_AUTH . '?forgot_password=yes');

define('PATH_TO_USER',       '/user/');
define('PATH_TO_BASKET',     PATH_TO_USER . 'cart/');
define('PATH_TO_REGISTER',   PATH_TO_USER . 'register/');
define('PATH_TO_ORDER',      PATH_TO_USER . 'order/' );
define('PATH_TO_PAYMENT',    PATH_TO_USER . 'order/payment/');
define('PATH_TO_ORDER_LIST', PATH_TO_USER );
define('PATH_TO_PROFILE',    PATH_TO_USER );

/**
 * IBlocks
 */
define("IBLOCK_ID__NEWS", 1);
define("IBLOCK_ID__CATALOG", 2);