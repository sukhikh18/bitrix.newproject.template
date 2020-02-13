<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$php_interface = '/local/php_interface';

CModule::AddAutoloadClasses(
    '',
    array(
        'local\handlers\admin\IBlockPropertyCheckbox' => $php_interface . '/handlers/admin/IBlockPropertyCheckbox.php',
        'local\handlers\admin\CUserTypeIBlockElement' => $php_interface . '/handlers/admin/IBlockUserFieldElement.php',
        'local\handlers\admin\IBlockVisualEditorComponents' => $php_interface . '/handlers/admin/IBlockVisualEditorComponents.php',
        'CFormPhoneValidator' => $php_interface . '/handlers/admin/CFormPhoneValidator.php',

        'local\handlers\Page' => $php_interface . '/handlers/page.php',
        'local\handlers\User' => $php_interface . '/handlers/user.php',
        'local\handlers\Order' => $php_interface . '/handlers/order.php',
        'local\handlers\Basket' => $php_interface . '/handlers/basket.php',
    )
);

require_once $_SERVER["DOCUMENT_ROOT"] . $php_interface . "/constants.php";
require_once $_SERVER["DOCUMENT_ROOT"] . $php_interface . "/assets.php";
require_once $_SERVER["DOCUMENT_ROOT"] . $php_interface . "/functions.php";
require_once $_SERVER["DOCUMENT_ROOT"] . $php_interface . "/handlers.php";
