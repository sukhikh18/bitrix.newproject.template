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

$APPLICATION->IncludeComponent(
    "bitrix:system.auth.form",
    ".default",
    array(
        "FORGOT_PASSWORD_URL" => FORGOT_PASSWORD_URL,
        "PROFILE_URL" => "/user/",
        "REGISTER_URL" => REGISTER_URL,
        "SHOW_ERRORS" => "Y",
        "COMPONENT_TEMPLATE" => ".default",
    ),
    $component
);