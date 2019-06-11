<?php

if ($arParams['USE_PRICE_COUNT'])
{
    $showRanges = !$haveOffers && count($actualItem['ITEM_QUANTITY_RANGES']) > 1;
    $useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';
    ?>
    <div class="product-item-detail-info-container"
        <?=$showRanges ? '' : 'style="display: none;"'?>
        data-entity="price-ranges-block">
        <div class="product-item-detail-info-container-title">
            <?=$arParams['MESS_PRICE_RANGES_TITLE']?>
            <span data-entity="price-ranges-ratio-header">
                (<?=(Loc::getMessage(
                    'CT_BCE_CATALOG_RATIO_PRICE',
                    array('#RATIO#' => ($useRatio ? $measureRatio : '1').' '.$actualItem['ITEM_MEASURE']['TITLE'])
                ))?>)
            </span>
        </div>
        <dl class="product-item-detail-properties" data-entity="price-ranges-body">
            <?
            if ($showRanges)
            {
                foreach ($actualItem['ITEM_QUANTITY_RANGES'] as $range)
                {
                    if ($range['HASH'] !== 'ZERO-INF')
                    {
                        $itemPrice = false;

                        foreach ($arResult['ITEM_PRICES'] as $itemPrice)
                        {
                            if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
                            {
                                break;
                            }
                        }

                        if ($itemPrice)
                        {
                            ?>
                            <dt>
                                <?
                                echo Loc::getMessage(
                                        'CT_BCE_CATALOG_RANGE_FROM',
                                        array('#FROM#' => $range['SORT_FROM'].' '.$actualItem['ITEM_MEASURE']['TITLE'])
                                    ).' ';

                                if (is_infinite($range['SORT_TO']))
                                {
                                    echo Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
                                }
                                else
                                {
                                    echo Loc::getMessage(
                                        'CT_BCE_CATALOG_RANGE_TO',
                                        array('#TO#' => $range['SORT_TO'].' '.$actualItem['ITEM_MEASURE']['TITLE'])
                                    );
                                }
                                ?>
                            </dt>
                            <dd><?=($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE'])?></dd>
                            <?
                        }
                    }
                }
            }
            ?>
        </dl>
    </div>
    <?
    unset($showRanges, $useRatio, $itemPrice, $range);
}
