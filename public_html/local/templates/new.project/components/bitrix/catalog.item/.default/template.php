<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogProductsViewedComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

if(!isset($arResult['ITEM'])) return;

$item = $arResult['ITEM'];
$areaId = $arResult['AREA_ID'];
$itemIds = array(
	'ID' => $areaId,
	'PICT' => $areaId.'_pict',
	'SECOND_PICT' => $areaId.'_secondpict',
	'STICKER_ID' => $areaId.'_sticker',
	'SECOND_STICKER_ID' => $areaId.'_secondsticker',
	'QUANTITY' => $areaId.'_quantity',
	'QUANTITY_DOWN' => $areaId.'_quant_down',
	'QUANTITY_UP' => $areaId.'_quant_up',
	'QUANTITY_MEASURE' => $areaId.'_quant_measure',
	'QUANTITY_LIMIT' => $areaId.'_quant_limit',
	'BUY_LINK' => $areaId.'_buy_link',
	'BASKET_ACTIONS' => $areaId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $areaId.'_not_avail',
	'SUBSCRIBE_LINK' => $areaId.'_subscribe',
	'PRICE' => $areaId.'_price',
	'PRICE_OLD' => $areaId.'_price_old',
	'PRICE_TOTAL' => $areaId.'_price_total',
	'DSC_PERC' => $areaId.'_dsc_perc',
	'SECOND_DSC_PERC' => $areaId.'_second_dsc_perc',
	'PROP_DIV' => $areaId.'_sku_tree',
	'PROP' => $areaId.'_prop_',
	'DISPLAY_PROP_DIV' => $areaId.'_sku_prop',
	'BASKET_PROP_DIV' => $areaId.'_basket_prop',
);
$obName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $areaId);
$isBig = isset($arResult['BIG']) && $arResult['BIG'] === 'Y';

$productTitle = isset($item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
	? $item['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $item['NAME'];

$imgTitle = isset($item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
	? $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
	: $item['NAME'];

$skuProps = array();

$haveOffers = !empty($item['OFFERS']);
if ($haveOffers)
{
	$actualItem = isset($item['OFFERS'][$item['OFFERS_SELECTED']])
		? $item['OFFERS'][$item['OFFERS_SELECTED']]
		: reset($item['OFFERS']);
}
else
{
	$actualItem = $item;
}

if ($arParams['PRODUCT_DISPLAY_MODE'] === 'N' && $haveOffers)
{
	$price = $item['ITEM_START_PRICE'];
	$minOffer = $item['OFFERS'][$item['ITEM_START_PRICE_SELECTED']];
	$measureRatio = $minOffer['ITEM_MEASURE_RATIOS'][$minOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
	$morePhoto = $item['MORE_PHOTO'];
}
else
{
	$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
	$measureRatio = $price['MIN_QUANTITY'];
	$morePhoto = $actualItem['MORE_PHOTO'];
}

$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($item['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

$discountPositionClass = isset($arResult['BIG_DISCOUNT_PERCENT']) && $arResult['BIG_DISCOUNT_PERCENT'] === 'Y'
	? 'product-item-label-big'
	: 'product-item-label-small';
$discountPositionClass .= $arParams['DISCOUNT_POSITION_CLASS'];

$labelPositionClass = isset($arResult['BIG_LABEL']) && $arResult['BIG_LABEL'] === 'Y'
	? 'product-item-label-big'
	: 'product-item-label-small';
$labelPositionClass .= $arParams['LABEL_POSITION_CLASS'];

$itemHasDetailUrl = isset($item['DETAIL_PAGE_URL']) && $item['DETAIL_PAGE_URL'] != '';

if(!function_exists('displayProductItemProperties')) {
	function displayProductItemProperties($arProperties, $arMobile) {
		foreach ($arProperties as $code => $displayProperty)
        {
            $dtClass = 'text-muted';
            $ddClass = 'text-dark';
            $displayPropertyValue = (is_array($displayProperty['DISPLAY_VALUE'])
                ? implode(' / ', $displayProperty['DISPLAY_VALUE'])
                : $displayProperty['DISPLAY_VALUE']);

            if(isset($arMobile['PROPERTY_CODE_MOBILE'][$code])) {
                $dtClass.= ' d-none d-sm-block';
                $ddClass.= ' d-none d-sm-block';
            }
            ?>
            <dt class="<?= $dtClass ?>"><?= $displayProperty['NAME'] ?></dt>
            <dd class="<?= $ddClass ?>"><?= $displayPropertyValue ?></dd>
            <?php
        }
	}
}

if(!empty($price)) $isDiffPrice = $price['RATIO_PRICE'] < $price['RATIO_BASE_PRICE'];
$productItemContainer = 'product-item--container';
if(($arResult['SCALABLE'] ?? 'N') === 'Y') {
	$productItemContainer.= ' product-item-scalable-card';
}

?>
<div class="<?= $productItemContainer ?>" id="<?= $areaId ?>" data-entity="item">
	<div class="product-item">
	<?php

	include 'block/image.php';

	printf('<h3 class="product-item-name">%s</h3>',
		! $itemHasDetailUrl ? $productTitle :
		sprintf('<a href="%s">%s</a>', $item['DETAIL_PAGE_URL'], $productTitle)
	);

	$offerFileExist = ["price", "props", "sku", "quantityLimit", "quantity", "buttons"];

	foreach ($arParams['PRODUCT_BLOCKS_ORDER'] ?? array() as $blockName)
	{
		if('price' === $blockName && empty($price)) continue;
		if('quantity' === $blockName && !$arParams['USE_PRODUCT_QUANTITY']) continue;

		if($haveOffers && in_array($blockName, $offerFileExist, 1)) {
			include 'block/' . $blockName . '.php';
		} else {
			switch ($blockName) {
				case 'price': ?>
				    <div class="product-item-price" data-entity="price-block">
				        <?php if ($arParams['SHOW_OLD_PRICE'] === 'Y' && $isDiffPrice) : ?>
				            <span class="product-item-price-old" id="<?=$itemIds['PRICE_OLD']?>"><?= $price['PRINT_RATIO_BASE_PRICE'] ?></span>&nbsp;
				        <?php endif ?>

				        <span class="product-item-price-current" id="<?=$itemIds['PRICE']?>"><?= $price['PRINT_RATIO_PRICE']; ?></span>
				    </div>
				    <?php
					break;

				case 'props':
					if (!empty($item['DISPLAY_PROPERTIES'])) { ?>
				        <dl class="product-item-properties product-item-hidden">
				            <?php displayProductItemProperties($item['DISPLAY_PROPERTIES'], $item['PROPERTY_CODE_MOBILE']); ?>
				        </dl>
				        <?php
				    }

				    include 'block/props.php';
					break;

				case 'quantity':
					if (!$actualItem['CAN_BUY']) continue; ?>
			        <div class="product-item-amount product-item-hidden">
	                    <span class="product-item-amount-minus no-select" id="<?=$itemIds['QUANTITY_DOWN']?>"></span>
	                    <input class="product-item-amount-field" id="<?=$itemIds['QUANTITY']?>" type="number"
	                        name="<?=$arParams['PRODUCT_QUANTITY_VARIABLE']?>"
	                        value="<?=$measureRatio?>">
	                    <span class="product-item-amount-plus no-select" id="<?=$itemIds['QUANTITY_UP']?>"></span>

	                    <span class="product-item-amount-description">
	                    	<span id="<?=$itemIds['QUANTITY_MEASURE']?>"><?=$actualItem['ITEM_MEASURE']['TITLE']?></span>
	                    	<span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
	                    </span>
	                </div>
				    <?php
					break;

				case 'buttons':
					if ($actualItem['CAN_BUY']) { ?>
				        <div class="product-item-button--container" id="<?=$itemIds['BASKET_ACTIONS']?>">
				            <button class="btn btn-primary" id="<?=$itemIds['BUY_LINK']?>" rel="nofollow">
				                <?=($arParams['ADD_TO_BASKET_ACTION'] === 'BUY' ? $arParams['MESS_BTN_BUY'] : $arParams['MESS_BTN_ADD_TO_BASKET'])?>
				            </button>
				        </div>
				        <?
				    }
				    else {
				    	include 'block/buttons.php';
				    }
				    break;

				case 'quantityLimit':
					include 'block/quantityLimit.php';
					break;
			}
		}
	}
	?>
	</div>
	<?php

	if (!$haveOffers)
	{
		$jsParams = array(
			'PRODUCT_TYPE' => $item['PRODUCT']['TYPE'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_ADD_BASKET_BTN' => false,
			'SHOW_BUY_BTN' => true,
			'SHOW_ABSENT' => true,
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
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
				'SUBSCRIBE_ID' => $itemIds['SUBSCRIBE_LINK']
			)
		);
	}
	else
	{
		$jsParams = array(
			'PRODUCT_TYPE' => $item['PRODUCT']['TYPE'],
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

	// $templateData = array(
	// 	'JS_OBJ' => $obName,
	// 	'ITEM' => array(
	// 		'ID' => $item['ID'],
	// 		'IBLOCK_ID' => $item['IBLOCK_ID'],
	// 		'OFFERS_SELECTED' => $item['OFFERS_SELECTED'],
	// 		'JS_OFFERS' => $item['JS_OFFERS']
	// 	)
	// );
	?>
	<script>
	  var <?=$obName?> = new JCCatalogItem(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
	</script>
</div>
<?
unset($item, $actualItem, $minOffer, $itemIds, $jsParams);
