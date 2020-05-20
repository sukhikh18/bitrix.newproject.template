<?php

use \Bitrix\Main\Localization\Loc;

if (!$haveOffers)
{
    if (!$actualItem['CAN_BUY'])
    {
        ?>
        <div class="product-item-button-container">
            <?
            if ($showSubscribe)
            {
                $APPLICATION->IncludeComponent(
                    'bitrix:catalog.product.subscribe',
                    '',
                    array(
                        'PRODUCT_ID' => $actualItem['ID'],
                        'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
                        'BUTTON_CLASS' => 'btn btn-primary '.$buttonSizeClass,
                        'DEFAULT_DISPLAY' => true,
                        'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
            }
            ?>
            <button class="btn btn-link <?=$buttonSizeClass?>"
                id="<?=$itemIds['NOT_AVAILABLE_MESS']?>" href="javascript:void(0)" rel="nofollow">
                <?=$arParams['MESS_NOT_AVAILABLE']?>
            </button>
        </div>
        <?
    }
}
else
{
    if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
    {
        ?>
        <div class="product-item-button--container">
            <?
            if ($showSubscribe)
            {
                $APPLICATION->IncludeComponent(
                    'bitrix:catalog.product.subscribe',
                    '',
                    array(
                        'PRODUCT_ID' => $item['ID'],
                        'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
                        'BUTTON_CLASS' => 'btn btn-primary '.$buttonSizeClass,
                        'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
                        'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
            }
            ?>
            <button class="btn btn-link <?=$buttonSizeClass?>"
                id="<?=$itemIds['NOT_AVAILABLE_MESS']?>" href="javascript:void(0)" rel="nofollow"
                <?=($actualItem['CAN_BUY'] ? 'style="display: none;"' : '')?>>
                <?=$arParams['MESS_NOT_AVAILABLE']?>
            </button>
            <div id="<?=$itemIds['BASKET_ACTIONS']?>" <?=($actualItem['CAN_BUY'] ? '' : 'style="display: none;"')?>>
                <button class="btn btn-primary <?=$buttonSizeClass?>" id="<?=$itemIds['BUY_LINK']?>"
                    href="javascript:void(0)" rel="nofollow">
                    <?=($arParams['ADD_TO_BASKET_ACTION'] === 'BUY' ? $arParams['MESS_BTN_BUY'] : $arParams['MESS_BTN_ADD_TO_BASKET'])?>
                </button>
            </div>
        </div>
        <?
    }
    else
    {
        ?>
        <div class="product-item-button--container">
            <button class="btn btn-primary <?=$buttonSizeClass?>" href="<?=$item['DETAIL_PAGE_URL']?>">
                <?=$arParams['MESS_BTN_DETAIL']?>
            </button>
        </div>
        <?
    }
}
?>
