<?php

use \Bitrix\Main\Loader;

$eventManager = \Bitrix\Main\EventManager::getInstance();

// ADMIN
// Свойство чекбокс
$eventManager->AddEventHandler('iblock', 'OnIBlockPropertyBuildList',
	array('local\handlers\admin\IBlockPropertyCheckbox', 'GetUserTypeDescription'));
// Пользовательское свойство "Связь с элементом"
$eventManager->AddEventHandler('main', 'OnUserTypeBuildList',
	array('local\handlers\admin\CUserTypeIBlockElement', 'GetUserTypeDescription'), 5000);
// Компоненты в элементах инфоблока
$eventManager->addEventHandler("fileman", "OnBeforeHTMLEditorScriptRuns", array(
	"IBlockVisualEditorComponents", "beforeHTMLEditorScriptRuns"));
$eventManager->addEventHandler("main", "onEndBufferContent", array(
	"local\handlers\admin\IBlockVisualEditorComponents", "endBufferContent" ));

// PAGE
$eventManager->addEventHandler("main", "OnBeforeProlog", array("Local\Handlers\Page", "includeFunctions"));
// $eventManager->addEventHandler("main", "OnPageStart", array("Local\Handlers\Page", "includeModules"), 1);

// BASKET
// $eventManager->addEventHandler("sale", "OnBeforeBasketUpdate", array("Local\Handlers\Basket", "beforeUpdate"));
// $eventManager->addEventHandler("sale", "OnBasketUpdate", array("Local\Handlers\Basket", "afterUpdate"));

// ORDER
// $eventManager->addEventHandler("sale", "OnOrderAdd", array("Local\Handlers\Order", "afterAdd"));
// $eventManager->addEventHandler("sale", "OnOrderUpdate", array("Local\Handlers\Order", "afterUpdate"));

// USER
// $eventManager->addEventHandler("main", "OnBeforeUserRegister", array("\Local\Handlers\User", "beforeRegister"));
// $eventManager->addEventHandler("main", "OnAfterUserRegister", array("\Local\Handlers\User", "afterRegister"));
// $eventManager->addEventHandler("main", "OnSendUserInfo", array("\Local\Handlers\User", "sendUserInfo"));
// $eventManager->addEventHandler("main", "OnAfterUserAdd", array("\Local\Handlers\User", "afterAdd"));

