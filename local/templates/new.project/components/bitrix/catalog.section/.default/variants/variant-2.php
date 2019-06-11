<?php
// default
$columns = 6;
$columnClass = get_column_class( $columns );


foreach ($rowItems as $item)
{
    echo '<div class="'. $columnClass .'">';
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
                'SCALABLE' => 'N'
            ),
            'PARAMS' => $generalParams
            + array('SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']])
        ),
        $component,
        array('HIDE_ICONS' => 'Y')
    );
    echo "</div>";
}
