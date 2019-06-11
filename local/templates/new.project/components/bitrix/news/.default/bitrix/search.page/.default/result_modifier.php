<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arParams['IBLOCK_CODE'] = '';
if( !empty($arParams['IBLOCK_ID']) ) {
    $res = CIBlock::GetByID( $arParams['IBLOCK_ID'] );
    if($ar_res = $res->GetNext())
        $arParams['IBLOCK_CODE'] = $ar_res['CODE'];
}
