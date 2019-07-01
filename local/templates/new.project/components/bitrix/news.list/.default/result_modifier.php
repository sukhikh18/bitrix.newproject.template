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

if( empty($arParams['SORT_ELEMENTS']) ) {
    $arParams['SORT_ELEMENTS'] = 'PICT,NAME,DESC,MORE';
}

$sanitizeSort = function($value) {
    $value = trim( $value );
    $value = function_exists('mb_strtoupper') ? mb_strtoupper($value) : strtoupper($value);

    return $value;
};

$arParams['SORT_ELEMENTS'] = array_map($sanitizeSort, explode(',', $arParams['SORT_ELEMENTS']));
$arParams['SORT_ELEMENTS'] = array_flip($arParams['SORT_ELEMENTS']);

if( 'HORIZONTAL' == $arParams['ITEM_DIRECTION'] ) {
    unset($arParams['SORT_ELEMENTS']['PICT']);
//     if (($key = array_search('PICT', $arParams['SORT_ELEMENTS'])) !== false) {
//         unset($arParams['SORT_ELEMENTS'][$key]);
//     }
}

/**
 * Set defaults html attrs
 */
if( empty($arParams['ROW_CLASS']) )  $arParams['ROW_CLASS'] = 'row';
if( empty($arParams['ITEM_CLASS']) ) $arParams['ITEM_CLASS'] = 'item';
if( empty($arParams["NAME_TAG"]) )   $arParams["NAME_TAG"] = 'h3';

// Transfer to epilogue
if( $cp = $this->__component ) {
    $cp->arResult['SECTION_CLASS'] = $arResult['SECTION_CLASS'];
    $cp->arParams['ROW_CLASS'] = $arParams['ROW_CLASS'];

    $cp->SetResultCacheKeys(array('SECTION_CLASS'));
}

foreach ($arResult["ITEMS"] as &$arItem)
{
    // disable access if is link empty (not exists)
    if( !$arItem["DETAIL_PAGE_URL"] || 2 >= strlen($arItem["DETAIL_PAGE_URL"]) ) {
        $arResult["USER_HAVE_ACCESS"] = false;
    }

    $arItem['DETAIL_PAGE_URL'] = "N" === $arParams["HIDE_LINK_WHEN_NO_DETAIL"] ||
        ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"]) ? $arItem["DETAIL_PAGE_URL"] : '';

    /** @var string */
    $arItem['COLUMN_CLASS'] = $arParams['ITEM_CLASS'].'--column '.$arParams['COLUMN_CLASS'];

    $arItem["HTML"] = array(
        'PICT' => '',
        'NAME' => '',
        'DATE' => '',
        'DESC' => '',
        'MORE' => '',
    );

    /**
     * Fill HTML entities
     * Add picture link
     */
    if( !empty($arItem["PREVIEW_PICTURE"]["SRC"]) &&
        'HORIZONTAL' == $arParams['ITEM_DIRECTION'] || isset($arParams['SORT_ELEMENTS']['PICT']) ) {
        $arItem['COLUMN_CLASS'] .= ' has-picture';

        $arItem["HTML"]["PICT"] = sprintf('<img src="%s" alt="%s">',
            htmlspecialcharsEx($arItem["PREVIEW_PICTURE"]["SRC"]),
            htmlspecialcharsEx($arItem["NAME"])
        );

        if( "Y" === $arParams['PICTURE_DETAIL_URL'] ) {
            $arItem["HTML"]["PICT"] = sprintf('<a href="%s">%s</a>',
                htmlspecialcharsEx($arItem["DETAIL_PICTURE"]["SRC"]),
                $arItem["HTML"]["PICT"]
            );
        }

        $arItem["HTML"]["PICT"] = sprintf('<div class="%s__pict">%s</div>',
            $arParams['ITEM_CLASS'],
            $arItem["HTML"]["PICT"]
        );
    }

    /**
     * Item name
     */
    if( isset($arParams['SORT_ELEMENTS']['NAME']) && $arItem["NAME"] ) {
        $arItem["HTML"]["NAME"] = $arItem["NAME"];

        if( $arItem['DETAIL_PAGE_URL'] ) {
            $arItem["HTML"]["NAME"] = sprintf('<a href="%s">%s</a>',
                $arItem['DETAIL_PAGE_URL'],
                $arItem["HTML"]["NAME"]
            );
        }

        $arItem["HTML"]["NAME"] = sprintf('<%1$s class="%3$s">%2$s</%1$s>',
            $arParams["NAME_TAG"],
            $arItem["HTML"]["NAME"],
            $arParams['ITEM_CLASS'] . '__name'
        );
    }

    if( isset($arParams['SORT_ELEMENTS']['DATE']) && $arItem["DISPLAY_ACTIVE_FROM"] ) {
        $arItem["HTML"]["DATE"] = sprintf('<div class="%s__date">%s</div>',
            $arParams['ITEM_CLASS'],
            $arItem["DISPLAY_ACTIVE_FROM"]
        );
    }

    if( isset($arParams['SORT_ELEMENTS']['DESC']) && $arItem["PREVIEW_TEXT"] ) {
        $arItem["HTML"]["DESC"] = sprintf('<div class="%s__desc">%s</div>',
            $arParams['ITEM_CLASS'],
            $arItem["PREVIEW_TEXT"]
        );
    }

    /**
     * @todo
     */
    $arItem['MORE_LINK_TEXT'] = $arParams["MORE_LINK_TEXT"];
    // if( !empty($arItem['PROPERTIES'][ $arParams['EXTERNAL_LINK_PROPERTY'] ]['VALUE']) ) {
    //     $arItem['DETAIL_PAGE_URL'] = $arItem['PROPERTIES'][ $arParams['EXTERNAL_LINK_PROPERTY'] ]['VALUE'];
    //     $arItem['MORE_LINK_TEXT'] = 'читать в источнике';
    // }

    if( !empty($arItem["MORE_LINK_TEXT"]) ) { // $arItem['DETAIL_PAGE_URL'] &&
        $arItem["HTML"]["MORE"] = sprintf('<a class="%s__more" href="%s">%s</a>',
            $arParams['ITEM_CLASS'],
            $arItem['DETAIL_PAGE_URL'] ? $arItem['DETAIL_PAGE_URL'] : '#',
            $arItem["MORE_LINK_TEXT"]
        );
    }
}

$arParams['SORT_ELEMENTS'] = array_flip($arParams['SORT_ELEMENTS']);

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
