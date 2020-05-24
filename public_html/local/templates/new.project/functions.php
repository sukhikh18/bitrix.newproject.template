<?php

use \Bitrix\Main;

if ( ! defined('TPL')) {
    define('TPL', SITE_TEMPLATE_PATH);
}

if ( ! defined('THEME')) {
    define('THEME', $_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH);
}

// if (function_exists('find_section')) {
//     if ($sidebar = find_section('sidebar')) {
//         $APPLICATION->SetPageProperty('content-class', 'col-10');
//     }
// }