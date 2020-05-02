<?php

use \Bitrix\Main\Localization\Loc;

if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $haveOffers && !empty($item['OFFERS_PROP']))
{
    ?>
    <div class="product-item-info-container product-item-hidden" id="<?=$itemIds['PROP_DIV']?>">
        <?
        foreach ($arParams['SKU_PROPS'] as $skuProperty)
        {
            $propertyId = $skuProperty['ID'];
            $skuProperty['NAME'] = htmlspecialcharsbx($skuProperty['NAME']);
            if (!isset($item['SKU_TREE_VALUES'][$propertyId]))
                continue;
            ?>
            <div data-entity="sku-block">
                <div class="product-item-scu-container" data-entity="sku-line-block">
                    <div class="product-item-scu-block-title text-muted"><?=$skuProperty['NAME']?></div>
                    <div class="product-item-scu-block">
                        <div class="product-item-scu-list">
                            <ul class="product-item-scu-item-list">
                                <?
                                foreach ($skuProperty['VALUES'] as $value)
                                {
                                    if (!isset($item['SKU_TREE_VALUES'][$propertyId][$value['ID']]))
                                        continue;

                                    $value['NAME'] = htmlspecialcharsbx($value['NAME']);

                                    if ($skuProperty['SHOW_MODE'] === 'PICT')
                                    {
                                        ?>
                                        <li class="product-item-scu-item-color-container" title="<?=$value['NAME']?>" data-treevalue="<?=$propertyId?>_<?=$value['ID']?>" data-onevalue="<?=$value['ID']?>">
                                            <div class="product-item-scu-item-color-block">
                                                <div class="product-item-scu-item-color" title="<?=$value['NAME']?>" style="background-image: url('<?=$value['PICT']['SRC']?>');"></div>
                                            </div>
                                        </li>
                                        <?
                                    }
                                    else
                                    {
                                        ?>
                                        <li class="product-item-scu-item-text-container" title="<?=$value['NAME']?>"
                                            data-treevalue="<?=$propertyId?>_<?=$value['ID']?>" data-onevalue="<?=$value['ID']?>">
                                            <div class="product-item-scu-item-text-block">
                                                <div class="product-item-scu-item-text"><?=$value['NAME']?></div>
                                            </div>
                                        </li>
                                        <?
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?
        }
        ?>
    </div>
    <?
    foreach ($arParams['SKU_PROPS'] as $skuProperty)
    {
        if (!isset($item['OFFERS_PROP'][$skuProperty['CODE']]))
            continue;

        $skuProps[] = array(
            'ID' => $skuProperty['ID'],
            'SHOW_MODE' => $skuProperty['SHOW_MODE'],
            'VALUES' => $skuProperty['VALUES'],
            'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
        );
    }

    unset($skuProperty, $value);

    if ($item['OFFERS_PROPS_DISPLAY'])
    {
        foreach ($item['JS_OFFERS'] as $keyOffer => $jsOffer)
        {
            $strProps = '';

            if (!empty($jsOffer['DISPLAY_PROPERTIES']))
            {
                foreach ($jsOffer['DISPLAY_PROPERTIES'] as $displayProperty)
                {
                    $strProps .= '<dt>'.$displayProperty['NAME'].'</dt><dd>'
                        .(is_array($displayProperty['VALUE'])
                            ? implode(' / ', $displayProperty['VALUE'])
                            : $displayProperty['VALUE'])
                        .'</dd>';
                }
            }

            $item['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
        }
        unset($jsOffer, $strProps);
    }
}
