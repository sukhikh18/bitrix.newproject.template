<?php

if ($arParams['USE_PRODUCT_QUANTITY'])
{
	?>
	<div class="product-item-detail-info-container" style="<?=(!$actualItem['CAN_BUY'] ? 'display: none;' : '')?>"
		data-entity="quantity-block">
		<div class="product-item-detail-info-container-title"><?= \Bitrix\Main\Localization\Loc::getMessage('CATALOG_QUANTITY') ?></div>
		<div class="product-item-amount">
			<div class="product-item-amount-field-container">
				<span class="product-item-amount-field-btn-minus no-select" id="<?=$itemIds['QUANTITY_DOWN_ID']?>"></span>
				<input class="product-item-amount-field" id="<?=$itemIds['QUANTITY_ID']?>" type="number"
				value="<?=$price['MIN_QUANTITY']?>">
				<span class="product-item-amount-field-btn-plus no-select" id="<?=$itemIds['QUANTITY_UP_ID']?>"></span>
				<span class="product-item-amount-description-container">
					<span id="<?=$itemIds['QUANTITY_MEASURE']?>">
						<?=$actualItem['ITEM_MEASURE']['TITLE']?>
					</span>
					<span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
				</span>
			</div>
		</div>
	</div>
	<?
}