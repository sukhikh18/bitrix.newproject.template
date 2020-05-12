<? if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

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

$paramsPrefix = 'LIST_';
$paramsPrefixLen = strlen($paramsPrefix);
$arParams = array_walk($arParams, function($paramValue, $param) use (&$arParams, $arParamsPrefix, $paramsPrefixLen) {
    if(0 === strpos($param, $arParamsPrefix)) {
        $arParams[substr($param, $paramsPrefixLen)] = $paramValue;
        unset($arParams[$param]);
    }
});

if ('Y' == $arParams["USE_RSS"] && method_exists($APPLICATION, 'addheadstring')) {
    $rssUrl = $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["rss_section"];
    $rssUrl = CComponentEngine::makePathFromTemplate($rssUrl, array_map("urlencode", $arResult["VARIABLES"]));
    $APPLICATION->AddHeadString('<link rel="alternate" type="application/rss+xml" title="' . $rssUrl . '" href="' . $rssUrl . '" />');
}

?>
<section class="news news--section component--news">
    <? if ($arParams["USE_SEARCH"] == "Y"): ?>
    <section class="news__search component--search-form">
        <? $APPLICATION->IncludeComponent(
            "bitrix:search.form",
            "",
            Array(
                "PAGE" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["search"],
                "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"]
            ),
            $component
        ); ?>
    </section>
    <? endif ?>

    <? if ($arParams["USE_FILTER"] == "Y"): ?>
    <section class="news__filter component--catalog-filter">
        <? $APPLICATION->IncludeComponent(
            "bitrix:catalog.filter",
            "",
            $arParams,
            $component
        ); ?>
    </section>
    <? endif ?>

    <section class="news__list component--news-list">
        <? $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "",
            array_merge($arParams, array(
                "IBLOCK_URL"    => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
                "SECTION_URL"   => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                "DETAIL_URL"    => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
                "SEARCH_PAGE"   => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["search"],

                "SET_BROWSER_TITLE"         => "Y",
                "SET_META_KEYWORDS"         => "Y",
                "SET_META_DESCRIPTION"      => "Y",

                "PARENT_SECTION"      => $arResult["VARIABLES"]["SECTION_ID"],
                "PARENT_SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "INCLUDE_SUBSECTIONS" => "Y",
            )),
            $component
        ); ?>
    </section>
</section><!-- .news--section -->
