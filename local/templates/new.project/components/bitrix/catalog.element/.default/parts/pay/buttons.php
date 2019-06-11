<div data-entity="main-button-container">
    <div id="<?=$itemIds['BASKET_ACTIONS_ID']?>" style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;">
        <?
        if ($showAddBtn)
        {
            ?>
            <div class="product-item-detail-info-container">
                <a class="btn <?=$showButtonClassName?> product-item-detail-buy-button" id="<?=$itemIds['ADD_BASKET_LINK']?>"
                    href="javascript:void(0);">
                    <span><?=$arParams['MESS_BTN_ADD_TO_BASKET']?></span>
                </a>
            </div>
            <?
        }

        if ($showBuyBtn)
        {
            ?>
            <div class="product-item-detail-info-container">
                <a class="btn <?=$buyButtonClassName?> product-item-detail-buy-button" id="<?=$itemIds['BUY_LINK']?>"
                    href="javascript:void(0);">
                    <span><?=$arParams['MESS_BTN_BUY']?></span>
                </a>
            </div>
            <?
        }
        ?>
    </div>
    <?
    if ($showSubscribe)
    {
        ?>
        <div class="product-item-detail-info-container">
            <?
            $APPLICATION->IncludeComponent(
                'bitrix:catalog.product.subscribe',
                '',
                array(
                    'PRODUCT_ID' => $arResult['ID'],
                    'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
                    'BUTTON_CLASS' => 'btn btn-default product-item-detail-buy-button',
                    'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
                    'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
            );
            ?>
        </div>
        <?
    }
    ?>
    <div class="product-item-detail-info-container">
        <a class="btn btn-link product-item-detail-buy-button" id="<?=$itemIds['NOT_AVAILABLE_MESS']?>"
            href="javascript:void(0)"
            rel="nofollow" style="display: <?=(!$actualItem['CAN_BUY'] ? '' : 'none')?>;">
            <?=$arParams['MESS_NOT_AVAILABLE']?>
        </a>
    </div>
</div>