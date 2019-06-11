<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

// required is_front_page function
$is_front = function_exists('is_front_page') && is_front_page();

if( "Y" === $arParams['NOT_INCLUDE_FRONT'] && $is_front )
    $allow = false;

if( "Y" === $arParams['EXCLUDE_FRONT_FILE'] && !$is_front ) {
    $documentRoot = \Bitrix\Main\Application::getDocumentRoot();
    if( 1 >= substr_count(str_replace($documentRoot, '', $arResult["FILE"]), '/') )
        $allow = false;
}

if($arResult["FILE"] <> '' && $allow)
	include($arResult["FILE"]);
