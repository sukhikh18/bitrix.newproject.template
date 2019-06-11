<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

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
