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

?>
<section class='<?= $arResult['SECTION_CLASS'] ?>'>
    <?php if ("Y" == $arParams['LAZY_LOAD'] && ! empty($_GET['LAZY_LOAD']))
        echo "<!--RestartBuffer-->" ?>
    <?php /*if( $arParams["DISPLAY_TOP_PAGER"] ):?>
    <div class="<?= $arParams['IBLOCK_CODE'] ?>_<?= $arParams['ITEM_CLASS'] ?>__pager <?= $arParams['IBLOCK_CODE'] ?>_<?= $arParams['ITEM_CLASS'] ?>__pager_top"><?= $arResult["NAV_STRING"] ?></div>
    <?endif;*/ ?>

    <div class="<?= $arParams['ROW_CLASS'] ?>">
        <?php foreach ($arResult["ITEMS"] as $arItem): ?>
            <div class="<?= $arItem['COLUMN_CLASS'] ?>" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
                <?php

                $articleClass = $arParams['ITEM_CLASS'];

                if(in_array($arParams['THUMBNAIL_POSITION'], array('LEFT', 'RIGHT'))) {
                    $articleClass = 'media ' . $articleClass;
                }
                ?>

                <article class="<?= $articleClass ?>">
                    <?php
                    if (in_array($arParams['THUMBNAIL_POSITION'], array('LEFT', 'FLOAT_L', 'FLOAT_R')))
                        echo $arItem['HTML']['PICT']; ?>

                    <div class="media-body <?= $arParams['ITEM_CLASS'] ?>__body">
                        <?php
                        foreach ($arParams['SORT_ELEMENTS'] as $elem) {
                            if (isset($arItem['HTML'][$elem])) echo $arItem['HTML'][$elem];
                        }
                        ?>
                    </div>

                    <?php if('RIGHT' == $arParams['THUMBNAIL_POSITION']) echo $arItem['HTML']['PICT']; ?>

                    <?php if ($arItem['DETAIL_PAGE_URL'] && $arParams['USE_GLOBAL_LINK']): ?>
                        <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"></a>
                    <?php endif ?>
                </article>
            </div>

            <?php // add edit areas
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
                CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'],
                CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array(
                    "CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')
                ));
            ?>
        <? endforeach ?>
    </div><!-- .<?= $arParams['ROW_CLASS'] ?> -->

    <?php if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
        <div class="<?= $arParams['IBLOCK_CODE'] ?>_<?= $arParams['ITEM_CLASS'] ?>__pager <?= $arParams['IBLOCK_CODE'] ?>_<?= $arParams['ITEM_CLASS'] ?>__pager_bottom"><?= $arResult["NAV_STRING"]; ?></div>
    <?php endif; ?>

    <?php if ($arResult['MORE_ITEMS_LINK'] && "Y" == $arParams['LAZY_LOAD']): ?>
        <div class="ajax-pager-wrap">
            <a class="more-items-link btn btn-red" href="<?= $arResult['MORE_ITEMS_LINK'] ?>">больше<br> статей</a>
        </div>
    <?php endif ?>

    <?php if ("Y" == $arParams['LAZY_LOAD'] && ! empty($_GET['LAZY_LOAD']))
        echo "<!--RestartBuffer-->" ?>
</section>
