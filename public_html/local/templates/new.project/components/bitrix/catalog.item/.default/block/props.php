<?php

use \Bitrix\Main\Localization\Loc;

if (!$haveOffers)
{
    if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !empty($item['PRODUCT_PROPERTIES']))
    {
        ?>
        <div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
            <?
            if (!empty($item['PRODUCT_PROPERTIES_FILL']))
            {
                foreach ($item['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
                {
                    ?>
                    <input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propID?>]"
                        value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
                    <?
                    unset($item['PRODUCT_PROPERTIES'][$propID]);
                }
            }

            if (!empty($item['PRODUCT_PROPERTIES']))
            {
                ?>
                <table>
                    <?
                    foreach ($item['PRODUCT_PROPERTIES'] as $propID => $propInfo)
                    {
                        ?>
                        <tr>
                            <td><?=$item['PROPERTIES'][$propID]['NAME']?></td>
                            <td>
                                <?
                                if (
                                    $item['PROPERTIES'][$propID]['PROPERTY_TYPE'] === 'L'
                                    && $item['PROPERTIES'][$propID]['LIST_TYPE'] === 'C'
                                )
                                {
                                    foreach ($propInfo['VALUES'] as $valueID => $value)
                                    {
                                        ?>
                                        <label>
                                            <? $checked = $valueID === $propInfo['SELECTED'] ? 'checked' : ''; ?>
                                            <input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propID?>]"
                                                value="<?=$valueID?>" <?=$checked?>>
                                            <?=$value?>
                                        </label>
                                        <br />
                                        <?
                                    }
                                }
                                else
                                {
                                    ?>
                                    <select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propID?>]">
                                        <?
                                        foreach ($propInfo['VALUES'] as $valueID => $value)
                                        {
                                            $selected = $valueID === $propInfo['SELECTED'] ? 'selected' : '';
                                            ?>
                                            <option value="<?=$valueID?>" <?=$selected?>>
                                                <?=$value?>
                                            </option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                    <?
                                }
                                ?>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
                <?
            }
            ?>
        </div>
        <?
    }
}
else
{
    $showProductProps = !empty($item['DISPLAY_PROPERTIES']);
    $showOfferProps = $arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $item['OFFERS_PROPS_DISPLAY'];

    if ($showProductProps || $showOfferProps)
    {
        ?>
        <dl class="product-item-properties product-item-hidden">
            <?
            if ($showProductProps)
            {
                displayProductItemProperties($item['DISPLAY_PROPERTIES'], $item['PROPERTY_CODE_MOBILE']);
            }

            if ($showOfferProps)
            {
                ?>
                <span id="<?=$itemIds['DISPLAY_PROP_DIV']?>" style="display: none;"></span>
                <?
            }
            ?>
        </dl>
        <?
    }
}
