<? if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main;
use Bitrix\Main\Security\Random;

$form_id = 'form-' . Random::getInt(0, 999);

$assets = Main\Page\Asset::getInstance();
$min    = ("N" == Main\Config\Option::get("main", "use_minified_assets")) ? '' : '.min';

$assets->addCss(TPL . '/assets/fancybox/jquery.fancybox' . $min . '.css');
$assets->addJs(TPL . '/assets/fancybox/jquery.fancybox' . $min . '.js');

$documentRoot = Main\Application::getDocumentRoot();
$folder       = $this->GetFolder();

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
$this->setFrameMode(false);
?>
<section class="news news--search component component--news">
    <section class="news__search component--search-page">
        <? $APPLICATION->IncludeComponent(
            "bitrix:search.page",
            "",
            Array(
                "CHECK_DATES"                                  => $arParams["CHECK_DATES"] !== "N" ? "Y" : "N",
                "arrWHERE"                                     => array("iblock_" . $arParams["IBLOCK_TYPE"]),
                "arrFILTER"                                    => array("iblock_" . $arParams["IBLOCK_TYPE"]),
                "SHOW_WHERE"                                   => "N",
                "NO_WORD_LOGIC"                                => "Y",
                "USE_TITLE_RANK"                               => "Y",
                "DISPLAY_TOP_PAGER"                            => "N",
                "TAGS_INHERIT"                                 => "Y",
                "CACHE_TYPE"                                   => $arParams["CACHE_TYPE"],
                "CACHE_TIME"                                   => $arParams["CACHE_TIME"],
                "SET_TITLE"                                    => $arParams["SET_TITLE"],
                "arrFILTER_iblock_" . $arParams["IBLOCK_TYPE"] => array($arParams["IBLOCK_ID"]),
            ),
            $component
        ); ?>
    </section>

    <p>
        <a href="<?= $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"] ?>"><?= GetMessage("T_NEWS_DETAIL_BACK") ?></a>
    </p>
</section><!-- .component--news -->