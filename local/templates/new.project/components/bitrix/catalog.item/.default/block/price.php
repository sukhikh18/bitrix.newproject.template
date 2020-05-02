<?php

use \Bitrix\Main\Localization\Loc;

?>
<div class="product-item-price" data-entity="price-block">
    <?php
    if ($arParams['SHOW_OLD_PRICE'] === 'Y' && $price['RATIO_PRICE'] < $price['RATIO_BASE_PRICE'])
    {
        ?>
        <span class="product-item-price-old" id="<?=$itemIds['PRICE_OLD']?>">
            <?= $price['PRINT_RATIO_BASE_PRICE'] ?>
        </span>&nbsp;
        <?
    }
    ?>
    <span class="product-item-price-current" id="<?=$itemIds['PRICE']?>">
        <?php

        if ($arParams['PRODUCT_DISPLAY_MODE'] === 'N')
        {
            echo Loc::getMessage(
                'CT_BCI_TPL_MESS_PRICE_SIMPLE_MODE',
                array(
                    '#PRICE#' => $price['PRINT_RATIO_PRICE'],
                    '#VALUE#' => $measureRatio,
                    '#UNIT#' => $minOffer['ITEM_MEASURE']['TITLE']
                )
            );
        }
        else {
            echo $price['PRINT_RATIO_PRICE'];
        }

        ?>
    </span>
</div>

