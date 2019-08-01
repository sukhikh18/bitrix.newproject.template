<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$php_interface = $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface';

/**
 * @todo autoload
 */
require $php_interface . "/constants.php";
require $php_interface . "/functions.php";
require $php_interface . "/handlers.php";
