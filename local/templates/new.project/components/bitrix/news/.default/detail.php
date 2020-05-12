<? if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main;

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

if(class_exists('HTTP_Query')) {
    HTTP_Query::get_instance()->set(array(
        'VARIABLES'   => $arResult["VARIABLES"],
        "DETAIL_URL"  => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
        "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
        "IBLOCK_URL"  => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
        "SEARCH_PAGE" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["search"],
    ));
}

$paramsPrefix = 'DETAIL_';
$paramsPrefixLen = strlen($paramsPrefix);
$arParams = array_walk($arParams, function($paramValue, $param) use (&$arParams, $arParamsPrefix, $paramsPrefixLen) {
    if(0 === strpos($param, $arParamsPrefix)) {
        // @todo write debug when $arParams[$key] already exists.
        $arParams[substr($param, $paramsPrefixLen)] = $paramValue;
        unset($arParams[$param]);
    }
});

ob_start();
$ElementID = $APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    '',
    array_merge($arParams, Array(
        "DETAIL_URL"        => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
        "SECTION_URL"       => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
        "IBLOCK_URL"        => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
        "SEARCH_PAGE"       => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["search"],
        "ELEMENT_ID"        => $arResult["VARIABLES"]["ELEMENT_ID"],
        "ELEMENT_CODE"      => $arResult["VARIABLES"]["ELEMENT_CODE"],
        "SECTION_ID"        => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE"      => $arResult["VARIABLES"]["SECTION_CODE"],

        "SET_TITLE"         => "Y",
        "PAGER_SHOW_ALWAYS" => "N",
    )),
    $component
);
$bxNewsDetail = ob_get_clean();

if($arParams["USE_CATEGORIES"] == "Y" && $ElementID) {
    global $arCategoryFilter;

    $obCache    = new CPHPCache;
    /**
     * Get unique cache string
     * @var string $strCacheID
     */
    $strCacheID = $componentPath . LANG . $arParams["IBLOCK_ID"] . $ElementID . $arParams["CATEGORY_CODE"];
    if (($tzOffset = CTimeZone::GetOffset()) <> 0) $strCacheID .= "_" . $tzOffset;

    /**
     * Get cache live time
     * @var int $intCacheTime
     */
    $isOptionCahceDisabled = COption::GetOptionString("main", "component_cache_on", "Y") == "N";
    if ($arParams["CACHE_TYPE"] == "N" || $arParams["CACHE_TYPE"] == "A" && $isOptionCahceDisabled) {
        $intCacheTime = 0;
    } else {
        $intCacheTime = intval($arParams["CACHE_TIME"]);
    }

    /**
     * To cache filter variables by properties.
     */
    if ($obCache->StartDataCache($intCacheTime, $strCacheID, $componentPath)) {
        $rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $ElementID, "sort", "asc", array(
            "ACTIVE" => "Y",
            "CODE" => $arParams["CATEGORY_CODE"]
        ));

        $arCategoryFilter = array();
        while ($arProperty = $rsProperties->Fetch()) {
            if(!empty($arProperty["VALUE"])) {
                if(is_array($arProperty["VALUE"])) {
                    foreach ($arProperty["VALUE"] as $value) $arCategoryFilter[$value] = true;
                } else {
                    $arCategoryFilter[$arProperty["VALUE"]] = true;
                }
            }
        }

        $obCache->EndDataCache($arCategoryFilter);
    } else {
        $arCategoryFilter = $obCache->GetVars();
    }

    if(!empty($arCategoryFilter)) {
        $arCategoryFilter = array(
            "PROPERTY_" . $arParams["CATEGORY_CODE"] => array_keys($arCategoryFilter),
            "!" . "ID"                               => $ElementID,
        );
    }
}

?>
<section class="news news--detail component--news">
    <section class="news__detail component--news-detail">
        <?= $bxNewsDetail ?>
    </section>

    <? if ($arParams['BACKLINK_TEXT']): $backlinkUrl = $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"]; ?>
    <p class="news__backlink">
        <a class="btn btn-primary" href="<?= $backlinkUrl ?>"><?= $arParams['BACKLINK_TEXT'] ?></a>
    </p>
    <? endif ?>

    <? if ($arParams["USE_CATEGORIES"] == "Y" && $ElementID && !empty($arCategoryFilter)): ?>
    <section class="news__categories component--news-list">
        <h3><?= GetMessage("CATEGORIES") ?></h3>

        <? foreach ($arParams["CATEGORY_IBLOCK"] as $iblock_id): ?>
        <? $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            '',
            Array(
                "IBLOCK_ID"                 => $iblock_id,
                "NEWS_COUNT"                => $arParams["CATEGORY_ITEMS_COUNT"],
                "SET_TITLE"                 => "N",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "CACHE_TYPE"                => $arParams["CACHE_TYPE"],
                "CACHE_TIME"                => $arParams["CACHE_TIME"],
                "CACHE_GROUPS"              => $arParams["CACHE_GROUPS"],
                "FILTER_NAME"               => "arCategoryFilter",
                "CACHE_FILTER"              => "Y",
                "DISPLAY_TOP_PAGER"         => "N",
                "DISPLAY_BOTTOM_PAGER"      => "N",
            ),
            $component
        ); ?>
        <? endforeach ?>
    </section>
    <? endif ?>

    <? if ($arParams["USE_REVIEW"] == "Y" && IsModuleInstalled("forum") && $ElementID): ?>
    <section class="news__reviews component--forum-topic-reviews">
        <? $APPLICATION->IncludeComponent(
            "bitrix:forum.topic.reviews",
            "",
            array_merge($arParams, array(
                "ELEMENT_ID"           => $ElementID,
                "URL_TEMPLATES_DETAIL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
            )),
            $component
        ); ?>
    </section>
    <? endif ?>
</section><!-- .component--news -->
