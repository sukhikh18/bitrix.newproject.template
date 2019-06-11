<?
    $rowItemsCount = count($rowItems);
?>
<div class="col-sm-6 product-item-small-card">
    <div class="row">
        <?
        for ($i = 0; $i < $rowItemsCount - 1; $i++)
        {
            ?>
            <div class="col-6">
                <?
                $APPLICATION->IncludeComponent(
                    'bitrix:catalog.item',
                    '',
                    array(
                        'RESULT' => array(
                            'ITEM' => $rowItems[$i],
                            'AREA_ID' => $areaIds[$rowItems[$i]['ID']],
                            'TYPE' => $rowData['TYPE'],
                            'BIG_LABEL' => 'N',
                            'BIG_DISCOUNT_PERCENT' => 'N',
                            'BIG_BUTTONS' => 'N',
                            'SCALABLE' => 'N'
                        ),
                        'PARAMS' => $generalParams
                            + array('SKU_PROPS' => $arResult['SKU_PROPS'][$rowItems[$i]['IBLOCK_ID']])
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
<div class="col-sm-6 product-item-big-card">
    <div class="row">
        <div class="col-md-12">
            <?
            $item = end($rowItems);
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
                        'BIG_BUTTONS' => 'Y',
                        'SCALABLE' => 'Y'
                    ),
                    'PARAMS' => $generalParams
                        + array('SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']])
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
            );
            unset($item);
            ?>
        </div>
    </div>
</div>
