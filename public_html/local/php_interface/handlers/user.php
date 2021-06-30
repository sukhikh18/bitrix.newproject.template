<?php

use Bitrix\Main\EventManager;

$obEeventManager = EventManager::getInstance();

// Установить логин пользователя относительно его Email (не зависимо введен LOGIN или нет)
$obEeventManager->addEventHandler("main", "OnBeforeUserRegister", array("Local\Handlers\User", "fetchLoginByEmail"));
// Пробовать авторизироваться по емэйл
$obEeventManager->addEventHandler("main", "OnBeforeUserLogin", array("Local\Handlers\User", "checkEmailField"));
