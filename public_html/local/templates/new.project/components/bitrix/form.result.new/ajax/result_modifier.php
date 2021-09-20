<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($cp = $this->__component) {
    $cp->arResult['FORM_ERRORS'] = $arResult['FORM_ERRORS'];
    $cp->SetResultCacheKeys(['FORM_ERRORS']);
}

$arResult['WEB_FORM_AREA_ID'] = $arParams['WEB_FORM_ID'] . '-' . \Bitrix\Main\Security\Random::getString(6);
