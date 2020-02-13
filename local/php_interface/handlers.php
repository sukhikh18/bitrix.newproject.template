<?php

use \Bitrix\Main\EventManager;
use \Bitrix\Main\Loader;

$eventManager = EventManager::getInstance();

// ADMIN
// Свойство чекбокс
$eventManager->AddEventHandler('iblock', 'OnIBlockPropertyBuildList',
	array('local\handlers\admin\IBlockPropertyCheckbox', 'GetUserTypeDescription'));
// Пользовательское свойство "Связь с элементом"
$eventManager->AddEventHandler('main', 'OnUserTypeBuildList',
	array('local\handlers\admin\CUserTypeIBlockElement', 'GetUserTypeDescription'), 5000);
// Компоненты в элементах инфоблока
$eventManager->addEventHandler("fileman", "OnBeforeHTMLEditorScriptRuns", array(
	"local\handlers\admin\IBlockVisualEditorComponents", "beforeHTMLEditorScriptRuns"));
$eventManager->addEventHandler("main", "onEndBufferContent", array(
	"local\handlers\admin\IBlockVisualEditorComponents", "endBufferContent" ));
// Too long phone number.
$eventManager->addEventHandler('form', 'onFormValidatorBuildList', array('CFormPhoneValidator', 'getDescription'));

// PAGE
$eventManager->addEventHandler("main", "OnBeforeProlog", array("local\handlers\Page", "includeFunctions"));
// $eventManager->addEventHandler("main", "OnPageStart", array("local\handlers\Page", "includeModules"), 1);

// BASKET
// $eventManager->addEventHandler("sale", "OnBeforeBasketUpdate", array("local\handlers\Basket", "beforeUpdate"));
// $eventManager->addEventHandler("sale", "OnBasketUpdate", array("local\handlers\Basket", "afterUpdate"));

// ORDER
// $eventManager->addEventHandler("sale", "OnOrderAdd", array("local\handlers\Order", "afterAdd"));
// $eventManager->addEventHandler("sale", "OnOrderUpdate", array("local\handlers\Order", "afterUpdate"));

// USER
// $eventManager->addEventHandler("main", "OnBeforeUserRegister", array("\local\handlers\User", "beforeRegister"));
// $eventManager->addEventHandler("main", "OnAfterUserRegister", array("\local\handlers\User", "afterRegister"));
// $eventManager->addEventHandler("main", "OnSendUserInfo", array("\local\handlers\User", "sendUserInfo"));
// $eventManager->addEventHandler("main", "OnAfterUserAdd", array("\local\handlers\User", "afterAdd"));

