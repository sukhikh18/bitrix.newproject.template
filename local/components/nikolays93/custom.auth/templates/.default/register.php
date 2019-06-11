<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var customOrderComponent $component */

$APPLICATION->IncludeComponent("bitrix:main.register", ".default", Array(
    "COMPONENT_TEMPLATE" => ".default",
    "SHOW_FIELDS" => array( // Поля, которые показывать в форме
        0 => "EMAIL",
        1 => "NAME",
        2 => "PERSONAL_PHONE",
    ),
    "REQUIRED_FIELDS" => "", // Поля, обязательные для заполнения
    "AUTH" => "N",  // Автоматически авторизовать пользователей
    "USE_BACKURL" => "Y", // Отправлять пользователя по обратной ссылке, если она есть
    "SUCCESS_PAGE" => "", // Страница окончания регистрации
    "SET_TITLE" => "N", // Устанавливать заголовок страницы
    "USER_PROPERTY" => "", // Показывать доп. свойства
    "USER_PROPERTY_NAME" => "", // Название блока пользовательских свойств
    ),
    $component
);