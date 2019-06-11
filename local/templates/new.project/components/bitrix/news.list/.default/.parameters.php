<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"ROW_CLASS" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_ROW_CLASS"),
		"TYPE" => "TEXT",
		"DEFAULT" => "row",
	),
	"ITEM_CLASS" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_ITEM_CLASS"),
		"TYPE" => "TEXT",
		"DEFAULT" => "item",
	),

	"COLUMNS" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_COLUMNS"),
		"TYPE" => "TEXT",
		"DEFAULT" => "1",
	),

	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DISPLAY_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DISPLAY_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"PICTURE_DETAIL_URL" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE_DETAIL_URL"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"DISPLAY_NAME" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DISPLAY_NAME"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"NAME_TAG" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME_TAG"),
		"TYPE" => "TEXT",
		"DEFAULT" => "h3",
	),
	"DISPLAY_PREVIEW_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DISPLAY_PREVIEW_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),

	"HIDE_GLOBAL_LINK" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_HIDE_GLOBAL_LINK"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"WIDE_GLOBAL_LINK" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_WIDE_GLOBAL_LINK"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),

	"DISPLAY_MORE_LINK" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_MORE_LINK"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"MORE_LINK_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_MORE_LINK_TEXT"),
		"TYPE" => "TEXT",
		"DEFAULT" => GetMessage("T_IBLOCK_VALUE_NEWS_MORE_LINK_TEXT"),
	),

	/**
	 * @todo
	 * /
	"EXTERNAL_LINK_PROPERTY" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_EXTERNAL_LINK_PROPERTY"),
		"TYPE" => "LIST",
		"DEFAULT" => "",
	),
	"EXTERNAL_LINK_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_EXTERNAL_LINK_TEXT"),
		"TYPE" => "LIST",
		"DEFAULT" => GetMessage("T_IBLOCK_VALUE_NEWS_EXTERNAL_LINK_TEXT"),
	), // */
);
