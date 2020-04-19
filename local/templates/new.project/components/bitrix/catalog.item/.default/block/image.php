<? if ($itemHasDetailUrl): ?>
<a class="product-item-image-wrapper" href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$imgTitle?>"
        data-entity="image-wrapper">
<? else: ?>
<span class="product-item-image-wrapper" data-entity="image-wrapper">
<? endif; ?>
    <span class="product-item-image-original" id="<?=$itemIds['PICT']?>" style="background-image: url('<?=$item['PREVIEW_PICTURE']['SRC']?>'); <?=($showSlider ? 'display: none;' : '')?>"></span>
    <?
    if ($item['SECOND_PICT'])
    {
        $bgImage = !empty($item['PREVIEW_PICTURE_SECOND']) ? $item['PREVIEW_PICTURE_SECOND']['SRC'] : $item['PREVIEW_PICTURE']['SRC'];
        ?>
        <span class="product-item-image-alternative" id="<?=$itemIds['SECOND_PICT']?>" style="background-image: url('<?=$bgImage?>'); <?=($showSlider ? 'display: none;' : '')?>"></span>
        <?
    }

    if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
    {
        ?>
        <div class="product-item-label-ring <?=$discountPositionClass?>" id="<?=$itemIds['DSC_PERC']?>"
            <?=($price['PERCENT'] > 0 ? '' : 'style="display: none;"')?>>
            <span><?=-$price['PERCENT']?>%</span>
        </div>
        <?
    }

    if ($item['LABEL'])
    {
        ?>
        <div class="product-item-label-text <?=$labelPositionClass?>" id="<?=$itemIds['STICKER_ID']?>">
            <?
            if (!empty($item['LABEL_ARRAY_VALUE']))
            {
                foreach ($item['LABEL_ARRAY_VALUE'] as $code => $value)
                {
                    ?>
                    <div<?=(!isset($item['LABEL_PROP_MOBILE'][$code]) ? ' class="hidden-xs"' : '')?>>
                        <span title="<?=$value?>"><?=$value?></span>
                    </div>
                    <?
                }
            }
            ?>
        </div>
        <?
    }
    ?>
<? if ($itemHasDetailUrl): ?>
</a>
<? else: ?>
</span>
<? endif; ?>