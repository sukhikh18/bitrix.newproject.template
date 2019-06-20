<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/**
 * @global $arCurrentValues
 */

$arComponentParameters = array(
	"GROUPS" => array(
        // BASE
        // DATA_SOURCE
        // VISUAL
        // USER_CONSENT
        // URL_TEMPLATES
        // SEF_MODE
        // AJAX_SETTINGS
        // CACHE_SETTINGS
        // ADDITIONAL_SETTINGS
	),
	"PARAMETERS" => array(
        // 'CACHE_TIME' => array('DEFAULT' => 120),
        "TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => "Источник данных",
            "TYPE" => "LIST",
            "VALUES"    =>  array(
                "flle"   =>  "Из файла",
                "iblock" =>  "Из инфоблока",
            ),
            "REFRESH" =>  "Y",
        ),
	),
);

if( 'flle' == $arCurrentValues['TYPE'] ) {
    $arComponentParameters["PARAMETERS"]["BLOCKS"] = array(
        "PARENT" => "DATA_SOURCE",
        "NAME" => "Блоки",
        "TYPE" => "STRING",
        "MULTIPLE" => "Y",
    );
}

if ( CModule::IncludeModule("iblock") && 'iblock' == $arCurrentValues['TYPE'] ) {
    /**
     * Get iblock types
     * @var array
     */
    $iblockTypes = \Bitrix\Iblock\TypeTable::getList(array('select' => array('ID', 'LANG_MESSAGE')))->FetchAll();

    $arIBlockTypes = array();

    foreach ($iblockTypes as $iblockType)
    {
        $arIBlockTypes[ $iblockType['ID'] ] =!empty($iblockType['IBLOCK_TYPE_LANG_MESSAGE_ELEMENTS_NAME']) ?
            $iblockType['IBLOCK_TYPE_LANG_MESSAGE_ELEMENTS_NAME'] :
            $iblockType['ID'];
    }

    $arComponentParameters["PARAMETERS"]["IBLOCK_TYPE"] = array(
        "PARENT" => "DATA_SOURCE",
        "NAME" => "Тип инфоблока",
        "TYPE" => "LIST",
        "REFRESH" =>  "Y",
        "VALUES" => $arIBlockTypes,
    );

    /**
     * @todo how it work on d7?
     * Get iblocks by type
     * @var array $args
     */
    // $args = array(
    //     'select' => array('*'),
    //     'filter' => array(
    //         'IBLOCK_TYPE_ID' => $arCurrentValues['IBLOCK_TYPE'],
    //     ),
    // );

    /**
     * @var array list of b_iblock_element
     */
    // $iblocks = \Bitrix\Iblock\ElementTable::getList($args)->FetchAll();
    $rsIblocks = CIBlock::GetList(
        Array(),
        Array(
            'TYPE' => $arCurrentValues['IBLOCK_TYPE'],
            'ACTIVE' => 'Y',
        ),
        true
    );

    $arIblocks = array();
    while($arIblock = $rsIblocks->Fetch())
    {
        $arIblocks[ $arIblock['ID'] ] = $arIblock['NAME'];
    }

    $arComponentParameters["PARAMETERS"]["IBLOCK_ID"] = array(
        "PARENT" => "DATA_SOURCE",
        "NAME" => "ID инфоблока",
        "TYPE" => "LIST",
        "REFRESH" =>  "Y",
        "VALUES" => $arIblocks,
    );

    /**
     * Get sections
     */
    $args = array(
        'filter' => array(
            'IBLOCK_ID' => $arCurrentValues["IBLOCK_ID"],
        ),
        'select' =>  array('ID', 'NAME'),
    );

    $rsSection = \Bitrix\Iblock\SectionTable::getList( $args );

    $arSections = array('' => 'Не указано');
    foreach ($rsSection as $arSection) {
        $arSections[ $arSection['ID'] ] = $arSection['NAME'];
    }

    $arComponentParameters["PARAMETERS"]["IBLOCK_SECTION"] = array(
        "PARENT" => "DATA_SOURCE",
        "NAME" => "Раздел инфоблока",
        "TYPE" => "LIST",
        "VALUES" => $arSections,
    );
}

$arComponentParameters["PARAMETERS"]["SHOW"] = array(
    "PARENT" => "VISUAL",
    "NAME" => "Показывать блок",
    "TYPE" => "STRING",
    "DEFAULT" => "0",
);
