<?php

if (!$haveOffers)
{
    $jsParams = array(
        'PRODUCT_TYPE' => $item['CATALOG_TYPE'],
        'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
        'SHOW_ADD_BASKET_BTN' => false,
        'SHOW_BUY_BTN' => true,
        'SHOW_ABSENT' => true,
        'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
        'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
        'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
        'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
        'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
        'BIG_DATA' => $item['BIG_DATA'],
        'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
        'VIEW_MODE' => $arResult['TYPE'],
        'USE_SUBSCRIBE' => $showSubscribe,
        'PRODUCT' => array(
            'ID' => $item['ID'],
            'NAME' => $productTitle,
            'DETAIL_PAGE_URL' => $item['DETAIL_PAGE_URL'],
            'PICT' => $item['SECOND_PICT'] ? $item['PREVIEW_PICTURE_SECOND'] : $item['PREVIEW_PICTURE'],
            'CAN_BUY' => $item['CAN_BUY'],
            'CHECK_QUANTITY' => $item['CHECK_QUANTITY'],
            'MAX_QUANTITY' => $item['CATALOG_QUANTITY'],
            'STEP_QUANTITY' => $item['ITEM_MEASURE_RATIOS'][$item['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
            'QUANTITY_FLOAT' => is_float($item['ITEM_MEASURE_RATIOS'][$item['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
            'ITEM_PRICE_MODE' => $item['ITEM_PRICE_MODE'],
            'ITEM_PRICES' => $item['ITEM_PRICES'],
            'ITEM_PRICE_SELECTED' => $item['ITEM_PRICE_SELECTED'],
            'ITEM_QUANTITY_RANGES' => $item['ITEM_QUANTITY_RANGES'],
            'ITEM_QUANTITY_RANGE_SELECTED' => $item['ITEM_QUANTITY_RANGE_SELECTED'],
            'ITEM_MEASURE_RATIOS' => $item['ITEM_MEASURE_RATIOS'],
            'ITEM_MEASURE_RATIO_SELECTED' => $item['ITEM_MEASURE_RATIO_SELECTED'],
            'MORE_PHOTO' => $item['MORE_PHOTO'],
            'MORE_PHOTO_COUNT' => $item['MORE_PHOTO_COUNT']
        ),
        'BASKET' => array(
            'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
            'EMPTY_PROPS' => empty($item['PRODUCT_PROPERTIES']),
            'BASKET_URL' => $arParams['~BASKET_URL'],
            'ADD_URL_TEMPLATE' => $arParams['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arParams['~BUY_URL_TEMPLATE']
        ),
        'VISUAL' => array(
            'ID' => $itemIds['ID'],
            'PICT_ID' => $item['SECOND_PICT'] ? $itemIds['SECOND_PICT'] : $itemIds['PICT'],
            'PICT_SLIDER_ID' => $itemIds['PICT_SLIDER'],
            'QUANTITY_ID' => $itemIds['QUANTITY'],
            'QUANTITY_UP_ID' => $itemIds['QUANTITY_UP'],
            'QUANTITY_DOWN_ID' => $itemIds['QUANTITY_DOWN'],
            'PRICE_ID' => $itemIds['PRICE'],
            'PRICE_OLD_ID' => $itemIds['PRICE_OLD'],
            'PRICE_TOTAL_ID' => $itemIds['PRICE_TOTAL'],
            'BUY_ID' => $itemIds['BUY_LINK'],
            'BASKET_PROP_DIV' => $itemIds['BASKET_PROP_DIV'],
            'BASKET_ACTIONS_ID' => $itemIds['BASKET_ACTIONS'],
            'NOT_AVAILABLE_MESS' => $itemIds['NOT_AVAILABLE_MESS'],
            'COMPARE_LINK_ID' => $itemIds['COMPARE_LINK'],
            'SUBSCRIBE_ID' => $itemIds['SUBSCRIBE_LINK']
        )
    );
}
else
{
    $jsParams = array(
        'PRODUCT_TYPE' => $item['CATALOG_TYPE'],
        'SHOW_QUANTITY' => false,
        'SHOW_ADD_BASKET_BTN' => false,
        'SHOW_BUY_BTN' => true,
        'SHOW_ABSENT' => true,
        'SHOW_SKU_PROPS' => false,
        'SECOND_PICT' => $item['SECOND_PICT'],
        'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
        'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
        'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
        'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
        'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
        'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
        'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
        'BIG_DATA' => $item['BIG_DATA'],
        'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
        'VIEW_MODE' => $arResult['TYPE'],
        'USE_SUBSCRIBE' => $showSubscribe,
        'DEFAULT_PICTURE' => array(
            'PICTURE' => $item['PRODUCT_PREVIEW'],
            'PICTURE_SECOND' => $item['PRODUCT_PREVIEW_SECOND']
        ),
        'VISUAL' => array(
            'ID' => $itemIds['ID'],
            'PICT_ID' => $itemIds['PICT'],
            'SECOND_PICT_ID' => $itemIds['SECOND_PICT'],
            'PICT_SLIDER_ID' => $itemIds['PICT_SLIDER'],
            'QUANTITY_ID' => $itemIds['QUANTITY'],
            'QUANTITY_UP_ID' => $itemIds['QUANTITY_UP'],
            'QUANTITY_DOWN_ID' => $itemIds['QUANTITY_DOWN'],
            'QUANTITY_MEASURE' => $itemIds['QUANTITY_MEASURE'],
            'QUANTITY_LIMIT' => $itemIds['QUANTITY_LIMIT'],
            'PRICE_ID' => $itemIds['PRICE'],
            'PRICE_OLD_ID' => $itemIds['PRICE_OLD'],
            'PRICE_TOTAL_ID' => $itemIds['PRICE_TOTAL'],
            'TREE_ID' => $itemIds['PROP_DIV'],
            'TREE_ITEM_ID' => $itemIds['PROP'],
            'BUY_ID' => $itemIds['BUY_LINK'],
            'DSC_PERC' => $itemIds['DSC_PERC'],
            'SECOND_DSC_PERC' => $itemIds['SECOND_DSC_PERC'],
            'DISPLAY_PROP_DIV' => $itemIds['DISPLAY_PROP_DIV'],
            'BASKET_ACTIONS_ID' => $itemIds['BASKET_ACTIONS'],
            'NOT_AVAILABLE_MESS' => $itemIds['NOT_AVAILABLE_MESS'],
            'COMPARE_LINK_ID' => $itemIds['COMPARE_LINK'],
            'SUBSCRIBE_ID' => $itemIds['SUBSCRIBE_LINK']
        ),
        'BASKET' => array(
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
            'SKU_PROPS' => $item['OFFERS_PROP_CODES'],
            'BASKET_URL' => $arParams['~BASKET_URL'],
            'ADD_URL_TEMPLATE' => $arParams['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arParams['~BUY_URL_TEMPLATE']
        ),
        'PRODUCT' => array(
            'ID' => $item['ID'],
            'NAME' => $productTitle,
            'DETAIL_PAGE_URL' => $item['DETAIL_PAGE_URL'],
            'MORE_PHOTO' => $item['MORE_PHOTO'],
            'MORE_PHOTO_COUNT' => $item['MORE_PHOTO_COUNT']
        ),
        'OFFERS' => array(),
        'OFFER_SELECTED' => 0,
        'TREE_PROPS' => array()
    );

    if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && !empty($item['OFFERS_PROP']))
    {
        $jsParams['SHOW_QUANTITY'] = $arParams['USE_PRODUCT_QUANTITY'];
        $jsParams['SHOW_SKU_PROPS'] = $item['OFFERS_PROPS_DISPLAY'];
        $jsParams['OFFERS'] = $item['JS_OFFERS'];
        $jsParams['OFFER_SELECTED'] = $item['OFFERS_SELECTED'];
        $jsParams['TREE_PROPS'] = $skuProps;
    }
}

if ($arParams['DISPLAY_COMPARE'])
{
    $jsParams['COMPARE'] = array(
        'COMPARE_URL_TEMPLATE' => $arParams['~COMPARE_URL_TEMPLATE'],
        'COMPARE_DELETE_URL_TEMPLATE' => $arParams['~COMPARE_DELETE_URL_TEMPLATE'],
        'COMPARE_PATH' => $arParams['COMPARE_PATH']
    );
}

if ($item['BIG_DATA'])
{
    $jsParams['PRODUCT']['RCM_ID'] = $item['RCM_ID'];
}

$jsParams['PRODUCT_DISPLAY_MODE'] = $arParams['PRODUCT_DISPLAY_MODE'];
$jsParams['USE_ENHANCED_ECOMMERCE'] = $arParams['USE_ENHANCED_ECOMMERCE'];
$jsParams['DATA_LAYER_NAME'] = $arParams['DATA_LAYER_NAME'];
$jsParams['BRAND_PROPERTY'] = !empty($item['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
    ? $item['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
    : null;

$templateData = array(
    'JS_OBJ' => $obName,
    'ITEM' => array(
        'ID' => $item['ID'],
        'IBLOCK_ID' => $item['IBLOCK_ID'],
        'OFFERS_SELECTED' => $item['OFFERS_SELECTED'],
        'JS_OFFERS' => $item['JS_OFFERS']
    )
);
?>
<script>
  var <?=$obName?> = new JCCatalogItem(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>