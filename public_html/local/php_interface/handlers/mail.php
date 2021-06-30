<?php

use Bitrix\Main\EventManager;

$obEeventManager = EventManager::getInstance();

// Изменить на "правильный (доменный)" адрес или MAIL_FROM если задано
$obEeventManager->addEventHandler("main", "OnBeforeEventSend", ["Local\Handlers\Mail", "changeFromAddress"]);
// Отправлять сообщение по адресу MAIL_ADMIN, если отправляется на email_from или order_email и MAIL_ADMIN задано
$obEeventManager->addEventHandler("main", "OnBeforeEventSend", ["Local\Handlers\Mail", "adminNotifications"]);
// Отправлять разработчику сообщения для дебага
$obEeventManager->addEventHandler("main", "OnBeforeEventSend", ["Local\Handlers\Mail", "debugMailMessages"]);
// Оповестить администратора о новом заказе
$obEeventManager->addEventHandler('sale', 'OnSaleOrderSaved', ["Local\Handlers\Mail", "notifyNewOrder"]);
