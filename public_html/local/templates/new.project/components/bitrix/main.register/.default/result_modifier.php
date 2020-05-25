<? if ( ! defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

global $APPLICATION, $USER;

// Sort fields by params.
$arResult["SHOW_FIELDS"] = array_merge($arParams['SHOW_FIELDS'], array_diff($arResult["SHOW_FIELDS"], $arParams['SHOW_FIELDS']));

// $component = $this->getComponent();
// $arParams = $component->applyTemplateModifications();