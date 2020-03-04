<?php

use \Bitrix\Main\Localization\Loc;

const SORT_BY_PARAM = 'sort_by';
const SHOW_BY_PARAM = 'show_by';

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

if( ! function_exists('displayOption')) {
    function displayOption($label, $value, $active) {
    	$selected = $active !== $value ?: ' selected';
    	if( $attributes ) $selected .= ' ';

    	printf('<option value="%1$s"%3$s%4$s>%2$s</option>', $value, $label, $selected, $attributes);
    }
}

/**
 * Sort by selector
 */
$sortByUrl = $APPLICATION->GetCurPageParam(SORT_BY_PARAM . "=' + this.value + '", array(SORT_BY_PARAM));
$sortByDefault = '';
$arParams['SORT_BY_LIST'] = array(
	$sortByDefault => Loc::getMessage('SORT_BY_LIST_DEFAULT'),
	'price_asc' => Loc::getMessage('SORT_BY_LIST_PRICE_ASC'),
	'price_desc' => Loc::getMessage('SORT_BY_LIST_PRICE_DESC'),
	'stock' => Loc::getMessage('SORT_BY_LIST_STOCK'),
);

$arResult['SORT_BY'] = ( ! empty($_REQUEST[SORT_BY_PARAM]) && is_string($_REQUEST[SORT_BY_PARAM]) &&
	array_key_exists($_REQUEST[SORT_BY_PARAM], $arParams['SORT_BY_LIST']))
	? $_REQUEST[SORT_BY_PARAM] : $sortByDefault;

if( 'price_asc' === $arResult['SORT_BY'] || 'price_desc' === $arResult['SORT_BY'] ) {
	$arParams["ELEMENT_SORT_FIELD"] = 'catalog_PRICE_1';
	$arParams["ELEMENT_SORT_ORDER"] = ( 'price_asc' === $arResult['SORT_BY'] ) ? 'asc' : 'desc';
}
elseif( 'stock' === $arResult['SORT_BY'] ) {
	$arParams["ELEMENT_SORT_FIELD"] = 'CATALOG_QUANTITY';
	$arParams["ELEMENT_SORT_ORDER"] = 'desc';
}


ob_start();
?>
<div class="section-sort">
	<select class="section-sort-select"	onchange="javascript:window.location.href='<?= $sortByUrl ?>'">
		<?php array_walk($arParams['SORT_BY_LIST'], 'displayOption', $arResult['SORT_BY']) ?>
	</select>
</div>
<?php
$arResult['SORT_BY_HTML'] = ob_get_clean();

/**
 * Show by selector
 */
$showByUrl = $APPLICATION->GetCurPageParam(SHOW_BY_PARAM . "=' + this.value + '", array(SHOW_BY_PARAM));
$showByDefault = ! empty($arParams["PAGE_ELEMENT_COUNT"]) ? intval($arParams["PAGE_ELEMENT_COUNT"]) : 9;
$arParams['SHOW_BY_LIST'] = array($showByDefault, 24, 42, 60);
$arParams["PAGE_ELEMENT_COUNT"] = ! empty($_REQUEST[SHOW_BY_PARAM]) ? intval($_REQUEST[SHOW_BY_PARAM]) : $showByDefault;

ob_start();
?>
<div class="section-show">
	<div class="section-show-label">Показывать по&nbsp;</div>
	<select class="section-show-select" onchange="javascript:window.location.href='<?= $showByUrl ?>'">
		<?php array_walk(array_combine($arParams['SHOW_BY_LIST'], $arParams['SHOW_BY_LIST']), 'displayOption',
			$arParams["PAGE_ELEMENT_COUNT"]) ?>
	</select>
</div>
<?php

$arResult['SHOW_BY_HTML'] = ob_get_clean();
