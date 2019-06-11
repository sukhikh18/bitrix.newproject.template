<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"ROW_CLASS" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_ROW_CLASS"),
		"TYPE" => "TEXT",
		"DEFAULT" => "row",
	),
	"COLUMNS" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_COLUMNS"),
		"TYPE" => "TEXT",
		"DEFAULT" => "4",
	),
	"ONECOLUMN_MOBILE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_ONECOLUMN_MOBILE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"PICTURE_DETAIL_URL" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE_DETAIL_URL"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"DISPLAY_NAME" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"NAME_TAG" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME_TAG"),
		"TYPE" => "TEXT",
		"DEFAULT" => "H3",
	),
	"DISPLAY_PREVIEW_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),

	"SLICK_slidesToShow" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SLICK_slidesToShow"),
		"TYPE" => "TEXT",
		"DEFAULT" => '1',
	),
	"SLICK_slidesToScroll" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SLICK_slidesToScroll"),
		"TYPE" => "TEXT",
		"DEFAULT" => '1',
	),
	"SLICK_infinite" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SLICK_infinite"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => 'N',
	),
	"SLICK_autoplay" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SLICK_autoplay"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => 'Y',
	),
	"SLICK_autoplaySpeed" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SLICK_autoplaySpeed"),
		"TYPE" => "TEXT",
		"DEFAULT" => '3000',
	),
	"SLICK_arrows" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SLICK_arrows"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => 'Y',
	),
	"SLICK_dots" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SLICK_dots"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => 'Y',
	),
	"SLICK_pauseOnHover" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SLICK_pauseOnHover"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => 'Y',
	),
);
