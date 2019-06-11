<?php

if ($arParams['SHOW_MAX_QUANTITY'] !== 'N')
{
    if ($haveOffers)
    {
        ?>
        <div class="product-item-detail-info-container" id="<?=$itemIds['QUANTITY_LIMIT']?>" style="display: none;">
            <div class="product-item-detail-info-container-title">
                <?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:
                <span class="product-item-quantity" data-entity="quantity-limit-value"></span>
            </div>
        </div>
        <?
    }
    else
    {
        if (
            $measureRatio
            && (float)$actualItem['CATALOG_QUANTITY'] > 0
            && $actualItem['CATALOG_QUANTITY_TRACE'] === 'Y'
            && $actualItem['CATALOG_CAN_BUY_ZERO'] === 'N'
        )
        {
            ?>
            <div class="product-item-detail-info-container" id="<?=$itemIds['QUANTITY_LIMIT']?>">
                <div class="product-item-detail-info-container-title">
                    <?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:
                    <span class="product-item-quantity" data-entity="quantity-limit-value">
                        <?
                        if ($arParams['SHOW_MAX_QUANTITY'] === 'M')
                        {
                            if ((float)$actualItem['CATALOG_QUANTITY'] / $measureRatio >= $arParams['RELATIVE_QUANTITY_FACTOR'])
                            {
                                echo $arParams['MESS_RELATIVE_QUANTITY_MANY'];
                            }
                            else
                            {
                                echo $arParams['MESS_RELATIVE_QUANTITY_FEW'];
                            }
                        }
                        else
                        {
                            echo $actualItem['CATALOG_QUANTITY'].' '.$actualItem['ITEM_MEASURE']['TITLE'];
                        }
                        ?>
                    </span>
                </div>
            </div>
            <?
        }
    }
}