<?php if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

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

$strSectionEdit        = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete      = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?>
<section class="catalog-section-list">
    <?php // parent name.
    if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID']) :
        $this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
        $this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete,
            $arSectionDeleteParams);
        ?>
        <?php // link himself: <!-- <a href="<? echo $arResult['SECTION']['SECTION_PAGE_URL']; ? >"></a> --> ?>
        <h1 class="catalog-section-list__title" id="<? echo $this->GetEditAreaId($arResult['SECTION']['ID']); ?>"><?= $arResult['PARENT_SECTION_NAME'] ?></h1>
    <?php endif; ?>

    <?php if (0 < $arResult["SECTIONS_COUNT"]): ?>
    <div class="row">
        <?php foreach ($arResult['SECTIONS'] as &$arSection):
            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete,
                $arSectionDeleteParams);

            // prepare section thumbnail.
            if (false === $arSection['PICTURE']) {
                $arSection['PICTURE'] = array(
                    'SRC'   => $this->GetFolder() . '/images/placeholder.png',
                    'ALT'   => (
                    '' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                        ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                        : $arSection["NAME"]
                    )
                );
            }

            $count = $arParams["COUNT_ELEMENTS"] ? "<span>{$arSection['ELEMENT_CNT']}</span>" : '';
        ?>

        <div class="section-item--column" id="<?= $this->GetEditAreaId($arSection['ID']); ?>">
            <div class="section-item">
                <div class="section-item__prev">
                    <img src="<?= $arSection['PICTURE']['SRC'] ?>" alt="<?= $arSection['PICTURE']['ALT'] ?>">
                </div>

                <?php if ('Y' != $arParams['HIDE_SECTION_NAME']): ?>
                    <h5 class="section-item__name"><?= $arSection['NAME']; ?><?= $count ?></h5>
                <?php endif; ?>

                <a href="<? echo $arSection['SECTION_PAGE_URL']; ?>" class="section-item__link"></a>
            </div>
        </div>

        <?php endforeach; unset($arSection); ?>
    </div>
    <? endif; ?>
</section><!-- .catalog-section-list -->
