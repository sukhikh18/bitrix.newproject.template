<div class="product-item-detail-info-container">
    <?
    if ($arParams['SHOW_OLD_PRICE'] === 'Y')
    {
        ?>
        <div class="product-item-detail-price-old" id="<?=$itemIds['OLD_PRICE_ID']?>"
            style="display: <?=($showDiscount ? '' : 'none')?>;">
            <?=($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '')?>
        </div>
        <?
    }
    ?>
    <div class="product-item-detail-price-current" id="<?=$itemIds['PRICE_ID']?>">
        <?=$price['PRINT_RATIO_PRICE']?>
    </div>
    <?
    if ($arParams['SHOW_OLD_PRICE'] === 'Y')
    {
        ?>
        <div class="item_economy_price" id="<?=$itemIds['DISCOUNT_PRICE_ID']?>"
            style="display: <?=($showDiscount ? '' : 'none')?>;">
            <?
            if ($showDiscount)
            {
                echo Loc::getMessage('CT_BCE_CATALOG_ECONOMY_INFO2', array('#ECONOMY#' => $price['PRINT_RATIO_DISCOUNT']));
            }
            ?>
        </div>
        <?
    }
    ?>
</div>