<?php
use Bitrix\Main\Context;

if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if( ! function_exists('formHasPhoneValidator')) {
    function formHasPhoneValidator($form_id) {
        $rsValidatorList = CFormValidator::GetListForm(
            $form_id,
            $arFilter = array("ACTIVE" => "Y"),
            $by = "C_SORT",
            $order = "ASC"
        );

        while( $arValidator = $rsValidatorList->Fetch() ) {
            if('phone_ru' === $arValidator['NAME']) {
                return true;
            }
        }

        return false;
    }
}

if( ! function_exists('getFieldsWithPhoneRuValidator')) {
    function getFieldsWithPhoneRuValidator($arQuestions) {
        $arFields = array();

        foreach ($arQuestions as $sid => $arQuestion) {
            if('text' !== $arQuestion['FIELD_TYPE']) continue;
            $arType = array("TYPE" => 'text');

            $rsValidatorList = CFormValidator::GetList($arQuestion['ID'], $arType, $by = "C_SORT", $order = "ASC");

            while ($arValidator = $rsValidatorList->Fetch()) {
                if('phone_ru' === $arValidator['NAME']) {
                    $arFields[$arQuestion['SID']] = $arQuestion;
                }
            }
        }

        return $arFields;
    }
}

if(formHasPhoneValidator($arParams['WEB_FORM_ID'])) {
    $APPLICATION->AddHeadScript($this->GetFolder() . '/../.default/assets/cleave-with-phone.ru.js');
    $APPLICATION->AddHeadString('<script>
        document.addEventListener("DOMContentLoaded", function() {
            new Cleave(\'[type="tel"]\', {
                phone: true,
                phoneRegionCode: "RU"
            });
        });
    </script>');

    $fields = getFieldsWithPhoneRuValidator($arResult['arQuestions']);
    foreach ($fields as $sid => $field) {
        if(isset($arResult["QUESTIONS"][$sid])) {
            $arResult["QUESTIONS"][$sid]["HTML_CODE"] = str_replace('type="text"', 'type="tel"',
                $arResult["QUESTIONS"][$sid]["HTML_CODE"]);
        }
    }
}

$arResult["FORM_HEADER"] = str_replace('<form', '<form class="form-result-new"', $arResult["FORM_HEADER"]);

foreach ($arResult["QUESTIONS"] as $FIELD_SID => &$arQuestion) {
    // Keep hidden as hidden.
    if( 'hidden' === $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] ) {
        continue;
    }

    // Check a built in label.
    $q = array('');
    if (false != strpos($arQuestion["HTML_CODE"], '<br />')) {
        $q = explode('<br />', $arQuestion["HTML_CODE"]);
        $arQuestion["HTML_CODE"] = $q[1];
    }

    // Clear value and insert own placeholder attribute value.
    $arQuestion["HTML_CODE"] = preg_replace(
        "/value=\"(\w+)?\"/ui",
        "placeholder=\"" . trim($arQuestion["CAPTION"]) . "\" value=\"\"",
        $arQuestion["HTML_CODE"]
    );

    // Add form-control class.
    if( false === strpos($arQuestion["HTML_CODE"], 'class') ) {
        $arQuestion["HTML_CODE"] = str_replace('name', 'class="form-control" name', $arQuestion["HTML_CODE"]);
    }
    else {
        $arQuestion["HTML_CODE"] = str_replace('class="', 'class="form-control ', $arQuestion["HTML_CODE"]);
    }

    // Prepare form group label.
    $arQuestion['LABEL'] = ("Y" == $arParams['SHOW_CAPTION']) ? trim($arQuestion["CAPTION"]) : '';

    if ($arQuestion['LABEL'] && "Y" == $arQuestion["REQUIRED"]) {
        $arQuestion['LABEL'] .= $arResult["REQUIRED_SIGN"];
    }

    if ($arQuestion['LABEL'] && "Y" == $arQuestion["IS_INPUT_CAPTION_IMAGE"]) {
        $arQuestion['LABEL'] .= $arQuestion["IMAGE"]["HTML_CODE"];
    }

    if( $arQuestion['LABEL'] ) {
        $arQuestion['LABEL'] = sprintf('<label for="field_%s">%s</label>', $arQuestion['STRUCTURE'][0]['ID'], $arQuestion['LABEL']);
    }
}

$context = Context::getCurrent();
$isXmlhttprequest = 'xmlhttprequest' === strtolower( $context->getServer()->get( 'HTTP_X_REQUESTED_WITH' ) );
$isAjaxRequestParam = 'Y' === $context->getRequest()->get('is_ajax');
$isAjaxParam = isset($arParams['IS_AJAX']) && 'Y' == $arParams['IS_AJAX'];


$message = '';

if ("Y" == $arResult["isFormErrors"]) {
    $message = '<p class="fail-msg text-danger">' . $arResult["FORM_ERRORS_TEXT"] . '</p>';
}
elseif( !empty($_REQUEST['formresult']) && 'addok' === $_REQUEST['formresult'] ) {
    $message = '<p class="success-msg text-success">' . $arParams['SUCCESS_MESSAGE'] . '</p>';
}
elseif ("Y" == $arResult["isFormNote"]) {
    $message = '<p class="note-msg">' . $arResult["FORM_NOTE"] . '</p>';
}

if( $message && ($isXmlhttprequest || $isAjaxRequestParam || $isAjaxParam) ) {
    $APPLICATION->RestartBuffer();
    echo $message;
    $APPLICATION->FinalActions();
    die();
}
else {
    $arResult["FORM_HEADER"] .= '<div class="messages">' . $message . '</div>';
}
