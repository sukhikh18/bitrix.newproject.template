<?php

if ($arParams['USE_PRODUCT_QUANTITY'])
{
    ?>
    <div class="product-item-detail-info-container" style="<?=(!$actualItem['CAN_BUY'] ? 'display: none;' : '')?>"
        data-entity="quantity-block">
        <div class="product-item-detail-info-container-title"><?=Loc::getMessage('CATALOG_QUANTITY')?></div>
        <div class="product-item-amount">
            <div class="product-item-amount-field-container">
                <a class="product-item-amount-field-btn-minus" id="<?=$itemIds['QUANTITY_DOWN_ID']?>"
                    href="javascript:void(0)" rel="nofollow">
                </a>
                <input class="product-item-amount-field" id="<?=$itemIds['QUANTITY_ID']?>" type="tel"
                    value="<?=$price['MIN_QUANTITY']?>">
                <a class="product-item-amount-field-btn-plus" id="<?=$itemIds['QUANTITY_UP_ID']?>"
                    href="javascript:void(0)" rel="nofollow">
                </a>
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