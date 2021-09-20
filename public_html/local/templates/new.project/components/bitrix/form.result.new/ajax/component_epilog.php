<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @global $APPLICATION */

$isProcessed = ($_POST['WEB_FORM_ID'] == $arParams['WEB_FORM_ID'] || $_POST['WEB_FORM_ID'] == $arResult['arForm']['SID'])
    && ($_REQUEST["web_form_submit"] <> '' || $_REQUEST["web_form_apply"] <> '');
$isSubmitted = intval($_GET['RESULT_ID']) > 0;

if ($isProcessed || $isSubmitted) {
    @header('Content-Type: application/json');
    $APPLICATION->RestartBuffer();

    $arResponse = [
        'SUCCESS' => 'Y',
        'WEB_FORM_ID' => $arParams["WEB_FORM_ID"],
    ];

    if (!empty($arResult['FORM_ERRORS'])) {
        $arResponse['SUCCESS'] = 'N';
        $arResponse['ERROR'] = $arResult['FORM_ERRORS'];
    }

    echo \Bitrix\Main\Web\Json::encode($arResponse);
    die();
}
