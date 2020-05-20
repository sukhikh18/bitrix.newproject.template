<?
if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arDefaultParams = array(
    'VIEW_MODE'         => 'LIST',
    'SHOW_PARENT_NAME'  => 'Y',
    'HIDE_SECTION_NAME' => 'N'
);

$arParams = array_merge($arDefaultParams, $arParams);

if ('N' != $arParams['SHOW_PARENT_NAME']) {
    $arParams['SHOW_PARENT_NAME'] = 'Y';
}
if ('Y' != $arParams['HIDE_SECTION_NAME']) {
    $arParams['HIDE_SECTION_NAME'] = 'N';
}

if (0 < $arResult['SECTIONS_COUNT']) {
    $boolClear     = false;
    $arNewSections = array();

    foreach ($arResult['SECTIONS'] as &$arOneSection) {
        if (1 < $arOneSection['RELATIVE_DEPTH_LEVEL']) {
            $boolClear = true;
            continue;
        }
        $arNewSections[] = $arOneSection;
    }
    unset($arOneSection);

    if ($boolClear) {
        $arResult['SECTIONS']       = $arNewSections;
        $arResult['SECTIONS_COUNT'] = count($arNewSections);
    }
    unset($arNewSections);

    $boolPicture = false;
    $boolDescr   = false;
    $arSelect    = array('ID');
    $arMap       = array();

    reset($arResult['SECTIONS']);
    $arCurrent = current($arResult['SECTIONS']);

    if ( ! isset($arCurrent['PICTURE'])) {
        $boolPicture = true;
        $arSelect[]  = 'PICTURE';
    }

    if ($boolPicture || $boolDescr) {
        foreach ($arResult['SECTIONS'] as $key => $arSection) {
            $arMap[$arSection['ID']] = $key;
        }

        $rsSections = CIBlockSection::GetList(array(), array('ID' => array_keys($arMap)), false, $arSelect);
        while ($arSection = $rsSections->GetNext()) {
            if ( ! isset($arMap[$arSection['ID']])) continue;

            $key = $arMap[$arSection['ID']];
            if ($boolPicture) {
                $arSection['PICTURE']                   = intval($arSection['PICTURE']);
                $arSection['PICTURE']                   = (0 < $arSection['PICTURE'] ? CFile::GetFileArray($arSection['PICTURE']) : false);
                $arResult['SECTIONS'][$key]['PICTURE']  = $arSection['PICTURE'];
                $arResult['SECTIONS'][$key]['~PICTURE'] = $arSection['~PICTURE'];
            }

            if ($boolDescr) {
                $arResult['SECTIONS'][$key]['DESCRIPTION']       = $arSection['DESCRIPTION'];
                $arResult['SECTIONS'][$key]['~DESCRIPTION']      = $arSection['~DESCRIPTION'];
                $arResult['SECTIONS'][$key]['DESCRIPTION_TYPE']  = $arSection['DESCRIPTION_TYPE'];
                $arResult['SECTIONS'][$key]['~DESCRIPTION_TYPE'] = $arSection['~DESCRIPTION_TYPE'];
            }
        }
    }
}

$arResult['PARENT_SECTION_NAME'] = isset($arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]) &&
    "" !== $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
    ? $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
    : $arResult['SECTION']['NAME'];
