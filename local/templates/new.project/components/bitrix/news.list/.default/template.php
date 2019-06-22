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

?>
<section class='<?= $arResult['SECTION_CLASS'] ?>'>
    <?if( $arParams["DISPLAY_TOP_PAGER"] ):?>
    <div class="<?= $arParams['IBLOCK_CODE'] ?>__pager <?= $arParams['IBLOCK_CODE'] ?>__pager_top"><?= $arResult["NAV_STRING"] ?></div>
    <?endif;?>

    <div class="<?= $arParams['ROW_CLASS'] ?>">
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <div class="<?= $arItem['COLUMN_CLASS'] ?>" id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
                <?= $arItem['HTML']['GL_LINK_START'] ?>
                <article class="<?if('HORIZONTAL' == $arParams['ITEM_DIRECTION']) echo "media "?><?= $arParams['ITEM_CLASS'] ?>">
                    <?if( "N" !== $arParams["DISPLAY_PICTURE"] ):?>
                    <div class="<?= $arParams['ITEM_CLASS'] ?>__image">
                        <?= $arItem['HTML']['IMAGE'] ?>
                    </div>
                    <?endif?>

                    <div class="media-body <?= $arParams['ITEM_CLASS'] ?>__body">
                        <?php
                        if( "N" !== $arParams["DISPLAY_NAME"] ) {
                            echo $arItem['HTML']['NAME'];
                        }

                        if( "Y" === $arParams["DISPLAY_DATE"] && $arItem["DISPLAY_ACTIVE_FROM"]) {
                            printf('<div class="%s__date">%s</div>',
                                $arParams['ITEM_CLASS'],
                                $arItem["DISPLAY_ACTIVE_FROM"]
                            );
                        }

                        if( "N" !== $arParams["DISPLAY_PREVIEW_TEXT"] && $arItem["PREVIEW_TEXT"]) {
                            printf('<div class="%s__desc">%s</div>',
                                $arParams['ITEM_CLASS'],
                                $arItem["PREVIEW_TEXT"]
                            );
                        }
                        ?>

                        <?= $arItem["DETAIL_PAGE_URL_HTML"] ?>
                    </div>
                </article>
                <?= $arItem['HTML']['GL_LINK_END'] ?>
            </div>

            <?// add edit areas
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
                CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'],
                CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array(
                    "CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM') ) );
            ?>
        <?endforeach?>
    </div><!-- .<?= $arParams['ROW_CLASS'] ?> -->

    <?if( $arParams["DISPLAY_BOTTOM_PAGER"] ):?>
    <div class="<?= $arParams['IBLOCK_CODE'] ?>__pager <?= $arParams['IBLOCK_CODE'] ?>__pager_bottom"><?=$arResult["NAV_STRING"];?></div>
    <?endif;?>
</section>
