<?php

use \Bitrix\Main\Localization\Loc;

const SORT_BY_PARAM = 'sort_by';

$arResult['CURRENT_SECTION'] = array(
	'ID' => 0,
	'NAME' => 'Каталог'
);

if( !empty( $arResult['VARIABLES']['SECTION_ID'] ) ) {
	$arResult['CURRENT_SECTION'] = \Bitrix\Iblock\SectionTable::getList(array(
		'select' => array('ID', 'NAME'),
		"filter" => array(
			"IBLOCK_ID" => $arParams['IBLOCK_ID'],
			"ID" => intval( $arResult['VARIABLES']['SECTION_ID'] ),
		),
	))->fetch();
}

/**
 * Sort by selector
 */
$arParams['SORT_BY_LIST'] = array(
	'default' => Loc::getMessage('SORT_BY_LIST_DEFAULT'),
	'price_asc' => Loc::getMessage('SORT_BY_LIST_PRICE_ASC'),
	'price_desc' => Loc::getMessage('SORT_BY_LIST_PRICE_DESC'),
	'stock_desc' => Loc::getMessage('SORT_BY_LIST_STOCK_DESC'),
);

$arResult['SORT_BY'] = ( ! empty( $_REQUEST[SORT_BY_PARAM]) && is_string($_REQUEST[SORT_BY_PARAM]))
	? $_REQUEST[SORT_BY_PARAM] : false;

if( 'price_asc' === $arResult['SORT_BY'] || 'price_desc' === $arResult['SORT_BY'] ) {
	$arParams["ELEMENT_SORT_FIELD"] = 'catalog_PRICE_1';
	$arParams["ELEMENT_SORT_ORDER"] = ( 'price_asc' === $arResult['SORT_BY'] ) ? 'asc' : 'desc';
}
elseif( 'stock_desc' === $arResult['SORT_BY'] ) {
	$arParams["ELEMENT_SORT_FIELD"] = 'CATALOG_QUANTITY';
	$arParams["ELEMENT_SORT_ORDER"] = 'desc';
}

ob_start();
?>
<div class="section-sort">
	<select class="section-sort-select" onchange="javascript:window.location.href='?<?= SORT_BY_PARAM ?>=' + this.value;">
		<?php
		foreach ($arParams['SORT_BY_LIST'] as $value => $label) {
			printf('<option value="%1$s"%3$s>%2$s</option>',
				$value,
				$label,
				$value == $arResult['SORT_BY'] ? ' selected' : ''
			) . "\n";
		}
		?>
	</select>
</div>
<?php
$arResult['SORT_BY_HTML'] = ob_get_clean();
