<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Application;
use Bitrix\Main\Loader;

$documentRoot = Application::getDocumentRoot();
$composer =  realpath($documentRoot . '/../vendor/autoload.php');
if (is_file($composer)) require_once $composer;

Loader::registerAutoLoadClasses(null, [
    '\Handlers\Mail' => '/local/php_interface/handlers/lib/mail.php',
    '\Handlers\User' => '/local/php_interface/handlers/lib/user.php',
]);

require_once $documentRoot . '/local/php_interface' . '/constants.php';
require_once $documentRoot . '/local/php_interface' . '/handlers/mail.php';
require_once $documentRoot . '/local/php_interface' . '/handlers/user.php';
require_once $documentRoot . '/local/php_interface' . '/helpers/classes.php';
require_once $documentRoot . '/local/php_interface' . '/helpers/request.php';
