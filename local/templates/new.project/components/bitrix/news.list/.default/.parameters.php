<?
if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Web\Json;

$arTemplateParameters = array(
    "ROW_CLASS"          => Array(
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_ROW_CLASS"),
        "TYPE"    => "TEXT",
        "DEFAULT" => "row",
    ),
    "ITEM_CLASS"         => Array(
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_ITEM_CLASS"),
        "TYPE"    => "TEXT",
        "DEFAULT" => "item",
    ),
    "COLUMNS"            => Array(
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_COLUMNS"),
        "TYPE"    => "TEXT",
        "DEFAULT" => "1",
    ),
    "USE_GLOBAL_LINK"    => Array(
        "NAME"    => "Добавить ссылку в конце элемента",
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "N",
    ),
    "DISPLAY_PICTURE"    => Array(
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_DISPLAY_PICTURE"),
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "PICTURE_DETAIL_URL" => Array(
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE_DETAIL_URL"),
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "N",
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
    "NAME_TAG"           => Array(
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_NAME_TAG"),
        "TYPE"    => "TEXT",
        "DEFAULT" => "h3",
    ),
    "MORE_LINK_TEXT"     => Array(
        "NAME"    => GetMessage("T_IBLOCK_DESC_NEWS_MORE_LINK_TEXT"),
        "TYPE"    => "TEXT",
        "DEFAULT" => GetMessage("T_IBLOCK_VALUE_NEWS_MORE_LINK_TEXT"),
    ),
    "LAZY_LOAD"          => Array(
        "NAME"    => 'Ленивая подгрузка',
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "N",
    ),
    "INFINITY_SCROLL"    => Array(
        "NAME"    => 'Бесконечная прокрутка',
        "TYPE"    => "CHECKBOX",
        "DEFAULT" => "N",
    ),

    /**
     * @todo
     * /
     * "EXTERNAL_LINK_PROPERTY" => Array(
     * "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_EXTERNAL_LINK_PROPERTY"),
     * "TYPE" => "LIST",
     * "DEFAULT" => "",
     * ),
     * "EXTERNAL_LINK_TEXT" => Array(
     * "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_EXTERNAL_LINK_TEXT"),
     * "TYPE" => "LIST",
     * "DEFAULT" => GetMessage("T_IBLOCK_VALUE_NEWS_EXTERNAL_LINK_TEXT"),
     * ), // */
);
