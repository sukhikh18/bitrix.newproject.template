<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$res = CIBlock::GetByID( $arParams['IBLOCK_ID'] );
if($ar_res = $res->GetNext()) {
    $arParams['IBLOCK_CODE'] = $ar_res['CODE'];
}

if( empty($arParams['COLUMNS']) ) $arParams['COLUMNS'] = 1;

$SECTION_CLASS = array('news-list');
if( !empty($arParams['ITEM_CLASS']) )  $SECTION_CLASS[] = $arParams['ITEM_CLASS'] . "-list";
if( !empty($arParams['IBLOCK_CODE']) ) $SECTION_CLASS[] = "news-list_type_" . $arParams['IBLOCK_CODE'];
if( !empty($arParams['IBLOCK_ID']) )   $SECTION_CLASS[] = "news-list_id_" . $arParams['IBLOCK_ID'];
$arResult['SECTION_CLASS'] = implode(' ', $SECTION_CLASS);

$arParams['COLUMN_CLASS'] = function_exists('get_column_class') ?
    get_column_class($arParams['COLUMNS']) : 'columns-' . $arParams['COLUMNS'];

/**
 * Set defaults html attrs
 */
if( empty($arParams['ROW_CLASS']) ) $arParams['ROW_CLASS'] = 'row';
if( empty($arParams['ITEM_CLASS']) ) $arParams['ITEM_CLASS'] = 'item';
if( empty($arParams["NAME_TAG"]) ) $arParams["NAME_TAG"] = 'h3';

foreach ($arResult["ITEMS"] as &$arItem)
{
    // disable access if is link empty (not exists)
    if( !$arItem["DETAIL_PAGE_URL"] || "#" == $arItem["DETAIL_PAGE_URL"] ) {
        $arResult["USER_HAVE_ACCESS"] = false;
    }

    $arItem['DETAIL_PAGE_URL'] = ("N" != $arParams["HIDE_LINK_WHEN_NO_DETAIL"]) ||
        ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"]) ? $arItem["DETAIL_PAGE_URL"] : false;

    /** @var string */
    $arItem['COLUMN_CLASS'] = $arParams['ITEM_CLASS'].'--column '.$arParams['COLUMN_CLASS'];
    if( "Y" == $arParams["DISPLAY_PICTURE"] && !empty($arItem["PREVIEW_PICTURE"]["SRC"]) ) {
        $arItem['COLUMN_CLASS'] .= ' has-picture';
    }

    if( !empty($arItem['DETAIL_PAGE_URL']) && "Y" !== $arParams['WIDE_GLOBAL_LINK'] ) {
        $arItem["NAME"] = sprintf('<a href="%s">%s</a>', $arItem['DETAIL_PAGE_URL'], $arItem["NAME"]);
    }

    /**
     * @todo
     * /
    if( !empty($arItem['PROPERTIES'][ $arParams['EXTERNAL_LINK_PROPERTY'] ]['VALUE']) ) {
        $arItem['DETAIL_PAGE_URL'] = $arItem['PROPERTIES'][ $arParams['EXTERNAL_LINK_PROPERTY'] ]['VALUE'];
        $more = 'читать в источнике';
    } // */
}

/**
 * @fix it if is change SEO_URL
 */
$paramName = 'PAGEN_'.$arResult['NAV_RESULT']->NavNum;
$paramValue = $arResult['NAV_RESULT']->NavPageNomer;
$pageCount = $arResult['NAV_RESULT']->NavPageCount;

$arResult['MORE_ITEMS_LINK'] = '';
if( $arResult['NAV_RESULT']->NavPageCount <= 1 ) {
    $arParams['LAZY_LOAD'] = "N";
}
elseif ( $paramValue < $pageCount ) {
    $arResult['MORE_ITEMS_LINK'] = htmlspecialcharsbx(
        $APPLICATION->GetCurPageParam(
            sprintf('%s=%s', $paramName, ++$paramValue),
            array($paramName, 'LAZY_LOAD')
        )
    );
}
