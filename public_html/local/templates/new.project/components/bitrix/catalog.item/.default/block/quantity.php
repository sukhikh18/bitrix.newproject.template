<?php

use \Bitrix\Main\Localization\Loc;

if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
{
    ?>
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
    <?
}
