<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if( empty($arParams["NAME_TAG"]) ) $arParams["NAME_TAG"] = 'h3';
if( empty($arParams['COLUMNS']) ) $arParams['COLUMNS'] = 3;

$arParams['COLUMN_CLASS'] = function_exists('get_column_class') ?
    get_column_class( $arParams['COLUMNS'] ) : 'columns-' . $arParams['COLUMNS'];
$arParams['ROW_CLASS'] = !empty($arParams['ROW_CLASS']) ? $arParams['ROW_CLASS'] : 'unstyled';

$arNewResult = array();
$sectionLinc = array();
$arNewResult['ROOT'] = array();
$sectionLinc[0] = &$arNewResult['ROOT'];

foreach ($arResult['SECTIONS'] as $arSection) {
	$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']] = $arSection;
	$sectionLinc[$arSection['ID']] = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
}
unset($sectionLinc);
$arResult['SECTIONS'] = (array) $arNewResult['ROOT']['CHILD'];

$res = CIBlock::GetByID( $arParams['IBLOCK_ID'] );
if($ar_res = $res->GetNext())
    $arParams['IBLOCK_CODE'] = $ar_res['CODE'];
