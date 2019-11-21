<?php

use \Bitrix\Main\Config\Option;

if( !defined('LOG_FILENAME') ) define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/debug.log");
if( !defined('TPL_RESPONSIVE') ) define("TPL_RESPONSIVE", true);
if( !defined('DEFAULT_CACHE_TIME') ) define('DEFAULT_CACHE_TIME', '36000000');
if( !defined('SCRIPT_DEBUG') ) define('SCRIPT_DEBUG', "Y" === Option::get("main", "use_minified_assets"));


/**
 * IBLOCK IDs
 */
define("IBLOCK_ID__NEWS", 1);
define("IBLOCK_ID__ARTICLES", 2);
define("IBLOCK_TYPE__CATALOG", 'catalog');

/**
 * PATHS
 */
define('PATH_TO_CATALOG', '/catalog/');

define('PATH_TO_AUTH',            '/auth/');
define('PATH_TO_REGISTER',        PATH_TO_AUTH . '?register=yes');
define('PATH_TO_FORGOT_PASSWORD', PATH_TO_AUTH . '?forgot_password=yes');

define('PATH_TO_USER',       '/user/');
define('PATH_TO_BASKET',     PATH_TO_USER . 'cart/');
define('PATH_TO_REGISTER',   PATH_TO_USER . 'register/');
define('PATH_TO_ORDER',      PATH_TO_USER . 'order/' );
define('PATH_TO_PAYMENT',    PATH_TO_USER . 'order/payment/');
define('PATH_TO_ORDER_LIST', PATH_TO_USER );
define('PATH_TO_PROFILE',    PATH_TO_USER );
