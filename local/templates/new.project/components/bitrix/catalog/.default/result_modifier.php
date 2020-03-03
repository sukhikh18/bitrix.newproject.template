<?php

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
