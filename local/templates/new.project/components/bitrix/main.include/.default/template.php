<?
if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
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
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$allow = true;

global $APPLICATION;

$curDir    = $APPLICATION->GetCurDir();
$onRequest = empty($_SERVER['REQUEST_URI']) || in_array($_SERVER['REQUEST_URI'], array($curDir, '/index.php'));

$is_front = $onRequest && '/' === $curDir;

if ("Y" === $arParams['NOT_INCLUDE_FRONT'] && $is_front) {
    $allow = false;
}

if ("Y" === $arParams['EXCLUDE_FRONT_FILE'] && ! $is_front) {
    $documentRoot = \Bitrix\Main\Application::getDocumentRoot();
    if (1 >= substr_count(str_replace($documentRoot, '', $arResult["FILE"]), '/')) {
        $allow = false;
    }
}

if ($arResult["FILE"] <> '' && $allow) {
    include($arResult["FILE"]);
}
