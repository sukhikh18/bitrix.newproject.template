<?
if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$php_interface = $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface';

require $php_interface . "/constants.php";
// require $php_interface . "/vendor/autoload.php";
require $php_interface . "/include/admin/IBlockPropertyCheckbox.php";
require $php_interface . "/include/admin/IBlockUserFieldElement.php";
require $php_interface . "/include/functions.php";
require $php_interface . "/include/handlers.php";

// require $_SERVER["DOCUMENT_ROOT"] . "/local/templates/new.project/functions.php";
