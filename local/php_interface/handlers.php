<?php

use \Bitrix\Main\Loader;

$eventManager = \Bitrix\Main\EventManager::getInstance();

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

// ADMIN\IBlockVisualEditorComponents
// $eventManager->addEventHandler("fileman", "OnBeforeHTMLEditorScriptRuns", array(
//     "IBlockVisualEditorComponents", "beforeHTMLEditorScriptRuns"));

// $eventManager->addEventHandler("main", "onEndBufferContent", array(
//     "IBlockVisualEditorComponents", "endBufferContent" ));
