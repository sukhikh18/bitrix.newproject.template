<?
if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}


$arTemplateParameters = array(
    "USE_REVIEW"     => array(
        "HIDDEN" => 'Y',
    ),
    "USE_CATEGORIES" => array(
        "HIDDEN" => 'Y',
    ),
    "USE_RSS"        => array(
        "HIDDEN" => 'Y',
    ),
    "USE_RATING"     => array(
        "HIDDEN" => 'Y',
    ),

    "DISPLAY_NAME" => Array(
        "HIDDEN" => 'Y',
    ),
    "THUMBNAIL_POSITION" => Array(
        "PARENT"  => "VISUAL",
        "NAME"    => "Расположение изображения",
        "TYPE"    => "LIST",
        "DEFAULT" => "",
        "VALUES"  => array(
            ""        => "По умолчанию",
            "LEFT"    => "Слева",
            "RIGHT"   => "Справа",
            "FLOAT_L" => "Обтекание слева",
            "FLOAT_R" => "Обтекание справа",
        )
    ),
    "SORT_ELEMENTS" => Array(
        "PARENT"  => "VISUAL",
        "NAME"    => 'Расположение элементов',
        "TYPE"    => "CUSTOM",
        "DEFAULT" => "PICT,NAME,DESC,MORE",
        "JS_FILE" => "/local/assets/dragdrop_order/script.js",
        'JS_EVENT' => 'initDraggableOrderControl',
        'JS_DATA'  => Json::encode(array(
            'PICT' => 'Изображение',
            'NAME' => 'Название',
            'DESC' => 'Описание',
            'MORE' => 'Подробнее',
            'DATE' => 'Дата',
        )),
    ),
    "USE_GLOBAL_LINK"             => Array(
        "PARENT"  => "LIST_SETTINGS",
        "NAME"    => "Добавить ссылку в конце элемента",
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "N",
    ),
    "BACKLINK_TEXT"               => Array(
        "NAME"    => 'Текст кнопки вернуться к списку',
        "TYPE"    => "TEXT",
        "DEFAULT" => "Все статьи",
    ),
    // "LIST_DISPLAY_NAME" => Array(
    // 	"PARENT" => "LIST_SETTINGS",
    // 	"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME"),
    // 	"TYPE" => "CHECKBOX",
    // 	"DEFAULT" => "Y",
    // ),
    // "LIST_DISPLAY_DATE" => Array(
    // 	"PARENT" => "LIST_SETTINGS",
    // 	"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
    // 	"TYPE" => "CHECKBOX",
    // 	"DEFAULT" => "Y",
    // ),
    // "LIST_DISPLAY_PICTURE" => Array(
    // 	"PARENT" => "LIST_SETTINGS",
    // 	"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
    // 	"TYPE" => "CHECKBOX",
    // 	"DEFAULT" => "Y",
    // ),
    "LIST_COLUMNS"                => Array(
        "PARENT"  => "LIST_SETTINGS",
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_LIST_COLUMNS"),
        "TYPE"    => "STRING",
        "DEFAULT" => "4",
    ),
    "DISPLAY_MORE_LINK"           => Array(
        "PARENT"  => "LIST_SETTINGS",
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_DISPLAY_MORE_LINK"),
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "MORE_LINK_TEXT"              => Array(
        "PARENT"  => "LIST_SETTINGS",
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_MORE_LINK_TEXT"),
        "TYPE"    => "STRING",
        "DEFAULT" => "Читать далее",
    ),
    "ITEM_CLASS"                  => Array(
        "PARENT"  => "LIST_SETTINGS",
        "NAME"    => 'Класс элемента из списка',
        "TYPE"    => "STRING",
        "DEFAULT" => "item",
    ),
    "ROW_CLASS"                   => Array(
        "PARENT"  => "LIST_SETTINGS",
        "NAME"    => 'Класс строки элементов',
        "TYPE"    => "STRING",
        "DEFAULT" => "row",
    ),
    "LIST_NAME_TAG"               => Array(
        "PARENT"  => "LIST_SETTINGS",
        "NAME"    => 'Тэг заголовка',
        "TYPE"    => "STRING",
        "DEFAULT" => "h3",
    ),
    "LAZY_LOAD"                   => Array(
        "PARENT"  => "LIST_SETTINGS",
        "NAME"    => "Ленивая загрузка",
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "N",
    ),
    "INFINITY_SCROLL"             => Array(
        "PARENT"  => "LIST_SETTINGS",
        "NAME"    => "Бесконечная ленивая загрузка",
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "N",
    ),
    "DETAIL_TEMPLATE"             => Array(
        "PARENT"  => "DETAIL_SETTINGS",
        "NAME"    => 'Свой дизайн детальной страницы',
        "TYPE"    => "STRING",
        "DEFAULT" => "",
    ),
    "DETAIL_DISPLAY_NAME"         => Array(
        "PARENT"  => "DETAIL_SETTINGS",
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_NAME"),
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "DETAIL_DISPLAY_DATE"         => Array(
        "PARENT"  => "DETAIL_SETTINGS",
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "DETAIL_DISPLAY_PICTURE"      => Array(
        "PARENT"  => "DETAIL_SETTINGS",
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "DETAIL_DISPLAY_PREVIEW_TEXT" => Array(
        "PARENT"  => "DETAIL_SETTINGS",
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "USE_SHARE"                   => Array(
        "HIDDEN" => 'Y',
        // "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_USE_SHARE"),
        // "TYPE" => "CHECKBOX",
        // "MULTIPLE" => "N",
        // "VALUE" => "Y",
        // "DEFAULT" =>"N",
        // "REFRESH"=> "Y",
    ),
    "FILTER_NAME"                 => Array(
        "PARENT"  => "LIST_SETTINGS",
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_FILTER_NAME"),
        "TYPE"    => "STRING",
        "DEFAULT" => "arNewsFilter",
    ),

    "SEARCH_DISPLAY_TOP_PAGER"    => Array(
        "PARENT"  => "SEARCH_SETTINGS",
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_SEARCH_DISPLAY_TOP_PAGER"),
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "N",
    ),
    "SEARCH_DISPLAY_BOTTOM_PAGER" => Array(
        "PARENT"  => "SEARCH_SETTINGS",
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_SEARCH_DISPLAY_BOTTOM_PAGER"),
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
);

if ($arCurrentValues["USE_SHARE"] == "Y") {
    $arTemplateParameters["SHARE_HIDE"] = array(
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_HIDE"),
        "TYPE"    => "CHECKBOX",
        "VALUE"   => "Y",
        "DEFAULT" => "N",
    );

    $arTemplateParameters["SHARE_TEMPLATE"] = array(
        "NAME"     => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_TEMPLATE"),
        "DEFAULT"  => "",
        "TYPE"     => "STRING",
        "MULTIPLE" => "N",
        "COLS"     => 25,
        "REFRESH"  => "Y",
    );

    if (strlen(trim($arCurrentValues["SHARE_TEMPLATE"])) <= 0) {
        $shareComponentTemlate = false;
    } else {
        $shareComponentTemlate = trim($arCurrentValues["SHARE_TEMPLATE"]);
    }

    include_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/components/bitrix/main.share/util.php");

    $arHandlers = __bx_share_get_handlers($shareComponentTemlate);

    $arTemplateParameters["SHARE_HANDLERS"] = array(
        "NAME"     => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM"),
        "TYPE"     => "LIST",
        "MULTIPLE" => "Y",
        "VALUES"   => $arHandlers["HANDLERS"],
        "DEFAULT"  => $arHandlers["HANDLERS_DEFAULT"],
    );

    $arTemplateParameters["SHARE_SHORTEN_URL_LOGIN"] = array(
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_LOGIN"),
        "TYPE"    => "STRING",
        "DEFAULT" => "",
    );

    $arTemplateParameters["SHARE_SHORTEN_URL_KEY"] = array(
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_KEY"),
        "TYPE"    => "STRING",
        "DEFAULT" => "",
    );
}

?>