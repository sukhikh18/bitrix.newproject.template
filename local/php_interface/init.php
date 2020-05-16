<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use \Bitrix\Main\Application;

$documentRoot = Application::getDocumentRoot();
$composer =  $documentRoot . "/local/vendor/autoload.php";
if(is_file($composer)) require_once $composer;

$php_interface = '/local/php_interface';

CModule::AddAutoloadClasses(
    '',
    array(
        'handlers\admin\IBlockPropertyCheckbox' => $php_interface . '/handlers/admin/IBlockPropertyCheckbox.php',
        'handlers\admin\CUserTypeIBlockElement' => $php_interface . '/handlers/admin/IBlockUserFieldElement.php',
        'handlers\admin\IBlockVisualEditorComponents' => $php_interface . '/handlers/admin/IBlockVisualEditorComponents.php',
        'CFormPhoneValidator' => $php_interface . '/handlers/admin/CFormPhoneValidator.php',

        'handlers\Mail' => $php_interface . '/handlers/mail.php',
        'handlers\User' => $php_interface . '/handlers/user.php',
    )
);

require_once $documentRoot . $php_interface . "/constants.php";
require_once $documentRoot . $php_interface . "/assets.php";
require_once $documentRoot . $php_interface . "/functions.php";
require_once $documentRoot . $php_interface . "/handlers.php";
