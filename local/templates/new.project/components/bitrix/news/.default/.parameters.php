<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$arTemplateParameters = array(
	"USE_REVIEW" => array(
		"HIDDEN" => 'Y',
	),
	"USE_CATEGORIES" => array(
		"HIDDEN" => 'Y',
	),
	"USE_RSS" => array(
		"HIDDEN" => 'Y',
	),
	"USE_RATING" => array(
		"HIDDEN" => 'Y',
	),

	"DISPLAY_NAME" => Array(
		"HIDDEN" => 'Y',
	),
	"LIST_DISPLAY_NAME" => Array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"LIST_DISPLAY_DATE" => Array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"LIST_DISPLAY_PICTURE" => Array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"LIST_DISPLAY_PREVIEW_TEXT" => Array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"LIST_COLUMNS" => Array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_LIST_COLUMNS"),
		"TYPE" => "STRING",
		"DEFAULT" => "2",
	),
	"DISPLAY_MORE_LINK" => Array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DISPLAY_MORE_LINK"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"HIDE_GLOBAL_LINK" => Array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_HIDE_GLOBAL_LINK"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"MORE_LINK_TEXT" => Array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_MORE_LINK_TEXT"),
		"TYPE" => "STRING",
		"DEFAULT" => "читать далее",
	),

	"DETAIL_DISPLAY_NAME" => Array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DETAIL_DISPLAY_DATE" => Array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DETAIL_DISPLAY_PICTURE" => Array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DETAIL_DISPLAY_PREVIEW_TEXT" => Array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"USE_SHARE" => Array(
		"HIDDEN" => 'Y',
		// "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_USE_SHARE"),
		// "TYPE" => "CHECKBOX",
		// "MULTIPLE" => "N",
		// "VALUE" => "Y",
		// "DEFAULT" =>"N",
		// "REFRESH"=> "Y",
	),
	"FILTER_NAME" => Array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_FILTER_NAME"),
		"TYPE" => "STRING",
		"DEFAULT" => "arNewsFilter",
	),

	"SEARCH_DISPLAY_TOP_PAGER" => Array(
		"PARENT" => "SEARCH_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SEARCH_DISPLAY_TOP_PAGER"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"SEARCH_DISPLAY_BOTTOM_PAGER" => Array(
		"PARENT" => "SEARCH_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SEARCH_DISPLAY_BOTTOM_PAGER"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
);

if ($arCurrentValues["USE_SHARE"] == "Y")
{
	$arTemplateParameters["SHARE_HIDE"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_HIDE"),
		"TYPE" => "CHECKBOX",
		"VALUE" => "Y",
		"DEFAULT" => "N",
	);

	$arTemplateParameters["SHARE_TEMPLATE"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_TEMPLATE"),
		"DEFAULT" => "",
		"TYPE" => "STRING",
		"MULTIPLE" => "N",
		"COLS" => 25,
		"REFRESH"=> "Y",
	);
	
	if (strlen(trim($arCurrentValues["SHARE_TEMPLATE"])) <= 0)
		$shareComponentTemlate = false;
	else
		$shareComponentTemlate = trim($arCurrentValues["SHARE_TEMPLATE"]);

	include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/components/bitrix/main.share/util.php");

	$arHandlers = __bx_share_get_handlers($shareComponentTemlate);

	$arTemplateParameters["SHARE_HANDLERS"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arHandlers["HANDLERS"],
		"DEFAULT" => $arHandlers["HANDLERS_DEFAULT"],
	);

	$arTemplateParameters["SHARE_SHORTEN_URL_LOGIN"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_LOGIN"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
	
	$arTemplateParameters["SHARE_SHORTEN_URL_KEY"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_KEY"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
}

?>