<?
if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arTemplateParameters = Array(
    "SHOW_DESCRIPTION" => Array(
        "NAME"   => "Показать описание",
        "TYPE"   => "LIST",
        "VALUES" => Array(
            ""              => "None",
            "TOP"           => "On top",
            "BOTTOM"        => "On bottom",
            "BEFORE_SUBMIT" => "Before submit",
        ),
    ),
    "SHOW_CAPTION" => Array(
        "NAME"    => "Show field name",
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "AJAX_MODE" => Array(
        "NAME"    => "Use ajax",
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
);
