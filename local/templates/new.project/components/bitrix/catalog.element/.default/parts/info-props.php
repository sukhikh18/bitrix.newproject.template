<?php

if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
{
    ?>
    <div class="product-item-detail-info-container">
        <?
        if (!empty($arResult['DISPLAY_PROPERTIES']))
        {
            ?>
            <dl class="product-item-detail-properties">
                <?
                foreach ($arResult['DISPLAY_PROPERTIES'] as $property)
                {
                    if (isset($arParams['MAIN_BLOCK_PROPERTY_CODE'][$property['CODE']]))
                    {
                        ?>
                        <dt><?=$property['NAME']?></dt>
                        <dd><?=(is_array($property['DISPLAY_VALUE'])
                                ? implode(' / ', $property['DISPLAY_VALUE'])
                                : $property['DISPLAY_VALUE'])?>
                        </dd>
                        <?
                    }
                }
                unset($property);
                ?>
            </dl>
            <?
        }

        if ($arResult['SHOW_OFFERS_PROPS'])
        {
            ?>
            <dl class="product-item-detail-properties" id="<?=$itemIds['DISPLAY_MAIN_PROP_DIV']?>"></dl>
            <?
        }
        ?>
    </div>
    <?
}