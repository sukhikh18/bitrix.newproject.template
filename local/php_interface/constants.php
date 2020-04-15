<?php

use \Bitrix\Main\Config\Option;

// Куда сохранять лог ошибок функцией AddMessage2Log (D7: Bitrix\Main\Diag\Debug::dumpToFile).
if( !defined('LOG_FILENAME') ) define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/debug.log");
// Подключать полные версии стилей и скриптов вместо сжатых.
if( !defined('SCRIPT_DEBUG') ) define('SCRIPT_DEBUG', "N" === Option::get("main", "use_minified_assets"));
// Ссылка на сайт производителя (разработчика сайта/темы).
if( !defined('DEVELOPER_LINK') ) define('DEVELOPER_LINK', '//seo18.ru');
// Название производителя (разработчика).
if( !defined('DEVELOPER_NAME') ) define('DEVELOPER_NAME', 'SEO18');
// Тестовый емэйл (Емэйл с копиями сообщений для проверки работоспособности).
if( !defined('DEVELOPER_TESTMAIL') ) define('DEVELOPER_TESTMAIL', 'trashmailsizh@yandex.ru');
// IP тестового сервера.
if( !defined('DEVELOPMENT_IP') ) define('DEVELOPMENT_IP', '88.212.237.4');

/**
 * IBlocks
 */
define("IBLOCK_ID__NEWS", 1);
define("IBLOCK_ID__CATALOG", 2);

/**
 * PATHS (Не использовать в SEF настройках компонентов, испортит .urlrewrite)
 */
define('PATH_TO_CATALOG', '/shop/');

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
