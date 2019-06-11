<?php

if ($haveOffers && !empty($arResult['OFFERS_PROP']))
{
    ?>
    <div id="<?=$itemIds['TREE_ID']?>">
        <?
        foreach ($arResult['SKU_PROPS'] as $skuProperty)
        {
            if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
                continue;

            $propertyId = $skuProperty['ID'];
            $skuProps[] = array(
                'ID' => $propertyId,
                'SHOW_MODE' => $skuProperty['SHOW_MODE'],
                'VALUES' => $skuProperty['VALUES'],
                'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
            );
            ?>
            <div class="product-item-detail-info-container" data-entity="sku-line-block">
                <div class="product-item-detail-info-container-title"><?=htmlspecialcharsEx($skuProperty['NAME'])?></div>
                <div class="product-item-scu-container">
                    <div class="product-item-scu-block">
                        <div class="product-item-scu-list">
                            <ul class="product-item-scu-item-list">
                                <?
                                foreach ($skuProperty['VALUES'] as &$value)
                                {
                                    $value['NAME'] = htmlspecialcharsbx($value['NAME']);

                                    if ($skuProperty['SHOW_MODE'] === 'PICT')
                                    {
                                        ?>
                                        <li class="product-item-scu-item-color-container" title="<?=$value['NAME']?>"
                                            data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
                                            data-onevalue="<?=$value['ID']?>">
                                            <div class="product-item-scu-item-color-block">
                                                <div class="product-item-scu-item-color" title="<?=$value['NAME']?>"
                                                    style="background-image: url('<?=$value['PICT']['SRC']?>');">
                                                </div>
                                            </div>
                                        </li>
                                        <?
                                    }
                                    else
                                    {
                                        ?>
                                        <li class="product-item-scu-item-text-container" title="<?=$value['NAME']?>"
                                            data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
                                            data-onevalue="<?=$value['ID']?>">
                                            <div class="product-item-scu-item-text-block">
                                                <div class="product-item-scu-item-text"><?=$value['NAME']?></div>
                                            </div>
                                        </li>
                                        <?
                                    }
                                }
                                ?>
                            </ul>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?
        }
        ?>
    </div>
    <?
}