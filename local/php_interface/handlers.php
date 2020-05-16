<?php

use Bitrix\Main\EventManager;
use Bitrix\Main\Security\Random;
use Bitrix\Main\UserTable;

$obEeventManager = EventManager::getInstance();

/**
 * ADMIN
 *
 * Компоненты в элементах инфоблока
 */
$obEeventManager->addEventHandler("fileman", "OnBeforeHTMLEditorScriptRuns",
    array("handlers\admin\IBlockVisualEditorComponents", "beforeHTMLEditorScriptRuns"));
$obEeventManager->addEventHandler("main", "onEndBufferContent",
    array("handlers\admin\IBlockVisualEditorComponents", "endBufferContent"));
// Свойство чекбокс
$obEeventManager->AddEventHandler('iblock', 'OnIBlockPropertyBuildList',
	array('handlers\admin\IBlockPropertyCheckbox', 'GetUserTypeDescription'));
// Пользовательское свойство "Связь с элементом"
$obEeventManager->AddEventHandler('main', 'OnUserTypeBuildList',
	array('handlers\admin\CUserTypeIBlockElement', 'GetUserTypeDescription'), 5000);
// Валидация длины номера телефона
$obEeventManager->addEventHandler('form', 'onFormValidatorBuildList',
    array('handlers\admin\CFormPhoneValidator', 'getDescription'));

/**
 * MAIL
 *
 * Изменить на "правильный (доменный)" адрес или MAIL_FROM если задано
 */
$obEeventManager->addEventHandler("main", "OnBeforeEventSend", array("handlers\Mail", "changeFromAddress"));
// Отправлять сообщение по адресу MAIL_ADMIN, если отправляется на email_from или order_email и MAIL_ADMIN задано
$obEeventManager->addEventHandler("main", "OnBeforeEventSend", array("handlers\Mail", "adminNotifications"));
// Отправлять разработчику сообщения для дебага
$obEeventManager->addEventHandler("main", "OnBeforeEventSend", array("handlers\Mail", "debugMailMessages"));
// Оповестить администратора о новом заказе
$obEeventManager->addEventHandler('sale', 'OnSaleOrderSaved', array("handlers\Mail", "notifyNewOrder"));

/**
 * USER
 */
// Установить логин пользователя относительно его Email (не зависимо введен LOGIN или нет)
$obEeventManager->addEventHandler("main", "OnBeforeUserRegister", array("handlers\User", "fetchLoginByEmail"));
// Пробовать авторизироваться по емэйл
$obEeventManager->addEventHandler("main", "OnBeforeUserLogin", array("handlers\User", "checkEmailField"));
