<div class="col-12 product-item-small-card">
    <div class="row">
        <?
        foreach ($rowItems as $item)
        {
            ?>
            <div class="col-6 col-sm-4 col-md-2">
                <?
                $APPLICATION->IncludeComponent(
                    'bitrix:catalog.item',
                    '',
                    array(
                        'RESULT' => array(
                            'ITEM' => $item,
                            'AREA_ID' => $areaIds[$item['ID']],
                            'TYPE' => $rowData['TYPE'],
                            'BIG_LABEL' => 'N',
                            'BIG_DISCOUNT_PERCENT' => 'N',
                            'BIG_BUTTONS' => 'N',
                            'SCALABLE' => 'N'
                        ),
                        'PARAMS' => $generalParams
                            + array('SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']])
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
                ?>
            </div>
            <?
        }
        ?>
    </div>
</div>
