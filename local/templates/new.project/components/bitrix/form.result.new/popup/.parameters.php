<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "SHOW_DESCRIPTION" => Array(
        "NAME" => 'Показать описание',
        "TYPE" => "LIST",
        "VALUES" => Array(
            "" => "None",
            "TOP" => "On top",
            "BOTTOM" => "On bottom",
            "BEFORE_SUBMIT" => "Before submit",
        ),
        // "DEFAULT" => "",
    ),
    "SHOW_CAPTION" => Array(
        "NAME" => 'Показать название поля',
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
);
