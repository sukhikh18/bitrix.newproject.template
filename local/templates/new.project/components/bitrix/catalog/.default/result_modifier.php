<?php

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
