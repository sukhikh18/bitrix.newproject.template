<?php

use \Bitrix\Main;

if ( ! defined('TPL')) {
    define('TPL', SITE_TEMPLATE_PATH);
}
if ( ! defined('THEME')) {
    define('THEME', $_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH);
}
