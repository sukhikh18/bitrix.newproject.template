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

extract( $arResult['VAR'] );

?>
<section class='<?= $SECTION_CLASS ?>'>
    <?= $arResult['ACTION']['BEFORE_ROW'] ?>

    <div class="<?= $ROW_CLASS ?>">
        <?php foreach ($arResult["ITEMS"] as $arItem): extract($arItem['VAR']) ?>
            <div class="<?= $COLUMN_CLASS ?>" id="<?= $COLUMN_ID ?>">
                <article class="<?= $ARTICLE_CLASS ?>">
                    <?= $arItem['ACTION']['BEFORE_ARTICLE_BODY'] ?>
                    <div class="media-body <?= $arParams['ITEM_CLASS'] ?>__body">
                        <?php

                        /**
                         * Show elements by SORT_ELEMENTS param include: PICT, NAME, DESC, MORE, DATE, SECT
                         * You may use <?= $PICT ?> instead this function
                         */
                        $SHOW_ELEMENTS();

                        ?>
                    </div>
                    <?= $arItem['ACTION']['AFTER_ARTICLE_BODY'] ?>
                </article>
            </div>
        <? endforeach ?>
    </div><!-- .<?= $ROW_CLASS ?> -->

    <?= $arResult['ACTION']['AFTER_ROW'] ?>
</section>
