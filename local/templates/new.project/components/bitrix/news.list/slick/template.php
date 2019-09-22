<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

if( !sizeof($arResult["ITEMS"]) ) return;

extract( $arResult['VAR'] );

// if( !$arParams["EXCLUDE_STYLE"] )  $this->addExternalCss($templateFolder . "/assets/slick/slick.css");
// if( !$arParams["EXCLUDE_THEME"] )  $this->addExternalCss($templateFolder . "/assets/slick/slick-theme.css");
// if( !$arParams["EXCLUDE_SCRIPT"] ) $this->addExternalJS ($templateFolder . "/assets/slick/slick.min.js");

$rnd = randString(6);

$arResult["ITEMS"] = array_merge($arResult["ITEMS"], $arResult["ITEMS"], $arResult["ITEMS"], $arResult["ITEMS"], $arResult["ITEMS"]);

?>
<section class='<?= $SECTION_CLASS ?>'>
    <?= $BEFORE_ROW ?>
    <div class="<?= $ROW_CLASS ?>" id="slick-<?= $rnd ?>">
        <?php foreach ($arResult["ITEMS"] as $arItem): extract($arItem['VAR']) ?>
            <div class="<?= $COLUMN_CLASS ?>" id="<?= $COLUMN_ID ?>">
                <article class="<?= $ARTICLE_CLASS ?>">
                    <?= $BEFORE_ARTICLE_BODY ?>
                    <div class="media-body <?= $arParams['ITEM_CLASS'] ?>__body">
                        <?php

                        /**
                         * Show elements by SORT_ELEMENTS param include: PICT, NAME, DESC, MORE, DATE, SECT
                         * You may use <?= $PICT ?> instead this function
                         */
                        $SHOW_ELEMENTS();

                        ?>
                    </div>
                    <?= $AFTER_ARTICLE_BODY ?>
                </article>
            </div>
        <? endforeach ?>
    </div><!-- .<?= $ROW_CLASS ?> -->
    <?= $AFTER_ROW ?>
</section>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        var props = <?
        // Do not use CUtil::PhpToJSObject() becouse need ints
        echo json_encode( $arResult['SlickProps'] ); ?> || {};

        $('#slick-<?= $rnd ?>').slick( props );
    });
</script>
