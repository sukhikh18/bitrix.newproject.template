<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!defined('PHONE_VALIDATOR_CODE')) {
    define('PHONE_VALIDATOR_CODE', 'phone_ru');
}

if (!function_exists('getFieldsWithPhoneRuValidator')) {
    /**
     * @param  array  $arQuestions
     * @return array  $arFields
     */
    function getFieldsWithPhoneRuValidator(array $arQuestions): array {
        $arFields = array();

        foreach ($arQuestions as $sid => $arQuestion) {
            /** @var array Check type text only */
            $arType = array('TYPE' => 'text');
            if($arType['TYPE'] !== $arQuestion['FIELD_TYPE']) {
                continue;
            }

            /** @var CDBResult All fields validators */
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

/**
 * Change text type to tel for phone validation
 */
foreach (getFieldsWithPhoneRuValidator($arResult['arQuestions']) as $sid => $noused) {
    if (!isset($arResult["QUESTIONS"][$sid])) {
        continue;
    }

    $fieldCode = & $arResult["QUESTIONS"][$sid]["HTML_CODE"];
    $fieldCode = str_replace('type="text"', 'type="tel"', $fieldCode);
}

// Add form class name.
$arResult["FORM_HEADER"] = str_replace('<form', '<form class="form-result-new"', $arResult["FORM_HEADER"]);

foreach ($arResult["QUESTIONS"] as $FIELD_SID => &$arQuestion) {
    // Keep hidden as hidden.
    if( 'hidden' === $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] ) {
        continue;
    }

    // Get placeholder text.
    $placeholder = '';
    if (false != strpos($arQuestion["HTML_CODE"], '<br />')) {
        list($placeholder, $arQuestion["HTML_CODE"]) = explode('<br />', $arQuestion["HTML_CODE"], 2);
    }

    // Replace or add placeholder.
    $arQuestion["HTML_CODE"] =
        false !== strpos($arQuestion["HTML_CODE"], 'value=""') ?
        str_replace('value=""', 'placeholder="' . $placeholder . '"', $arQuestion["HTML_CODE"]) :
        preg_replace("/value=\"(\w+)\"/ui", "placeholder=\"{$placeholder}\"", $arQuestion["HTML_CODE"]);

    // Add bootstrap control class.
    $arQuestion["HTML_CODE"] =
        false !== strpos($arQuestion["HTML_CODE"], 'class') ?
        str_replace('class="', 'class="form-control ', $arQuestion["HTML_CODE"]) :
        str_replace('name', 'class="form-control" name', $arQuestion["HTML_CODE"]);
}
