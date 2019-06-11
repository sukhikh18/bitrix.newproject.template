<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$res = CIBlock::GetByID( $arParams['IBLOCK_ID'] );
if($ar_res = $res->GetNext())
    $arParams['IBLOCK_CODE'] = $ar_res['CODE'];

foreach ($arResult["ITEMS"] as &$arItem) {
    $more = $arParams["MORE_LINK_TEXT"];

    // disable access if is link empty (not exists)
    if( !$arItem["DETAIL_PAGE_URL"] || "#" == $arItem["DETAIL_PAGE_URL"] )
        $arResult["USER_HAVE_ACCESS"] = false;

    $arItem['DETAIL_PAGE_URL'] = ("N" != $arParams["HIDE_LINK_WHEN_NO_DETAIL"]) ||
        ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"]) ? $arItem["DETAIL_PAGE_URL"] : false;

    /**
     * @todo
     * /
    if( !empty($arItem['PROPERTIES'][ $arParams['EXTERNAL_LINK_PROPERTY'] ]['VALUE']) ) {
        $arItem['DETAIL_PAGE_URL'] = $arItem['PROPERTIES'][ $arParams['EXTERNAL_LINK_PROPERTY'] ]['VALUE'];
        $more = 'читать в источнике';
    } // */

    if( !empty($arItem['DETAIL_PAGE_URL']) && "Y" == $arParams["DISPLAY_MORE_LINK"] )
        $arItem['DETAIL_PAGE_URL_HTML'] = '<a class="item__more" href="' .$arItem['DETAIL_PAGE_URL']. '">' .$more. '</a>';
}

$sectClass = array(
    'news-list',
    $arParams['ITEM_CLASS'] . "-list",
    "news-list_type_" . $arParams['IBLOCK_CODE'],
    "news-list_id_" . $arParams['IBLOCK_ID'],
);
$arResult['SECTION_CLASS'] = implode(' ', $sectClass);

if( empty($arParams['ROW_CLASS']) )
    $arParams['ROW_CLASS'] = 'row';

if( empty($arParams['COLUMNS']) )
    $arParams['COLUMNS'] = 1;

$arParams['COLUMN_CLASS'] = function_exists('get_column_class') ?
    get_column_class($arParams['COLUMNS']) : 'columns-' . $arParams['COLUMNS'];

if( empty($arParams['ITEM_CLASS']) )
    $arParams['ITEM_CLASS'] = 'item';

if( empty($arParams["NAME_TAG"]) )
    $arParams["NAME_TAG"] = 'h3';