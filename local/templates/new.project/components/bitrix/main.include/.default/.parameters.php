<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"NOT_INCLUDE_FRONT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NOT_INCLUDE_FRONT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"PARENT" => "PARAMS",
	),
	"EXCLUDE_FRONT_FILE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_EXCLUDE_FRONT_FILE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"PARENT" => "PARAMS",
	),
);
