<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main;

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

$documentRoot = Main\Application::getDocumentRoot();
$folder = $this->GetFolder();
?>
<section class='<?=$arResult['SECTION_CLASS'];?>'>
    <?if( $arParams["DISPLAY_TOP_PAGER"] ):?>
    <div class='news-list__pager news-list__pager_top'><?=$arResult["NAV_STRING"];?></div>
    <?endif;?>
    <div class="<?=$arParams['ROW_CLASS'];?>">
        <?
        foreach($arResult["ITEMS"] as $arItem) {
            // add edit areas
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
                CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'],
                CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array(
                    "CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM') ) );

            $file = new Main\IO\File( $documentRoot . $folder . "/template-content.php" );
            if ($file->isExists()) include($file->getPath());
        }
        ?>
    </div><!-- .<?=$arParams['ROW_CLASS'];?> -->
    <?if( $arParams["DISPLAY_BOTTOM_PAGER"] ):?>
    <div class='news-list__pager news-list__pager_bottom'><?=$arResult["NAV_STRING"];?></div>
    <?endif;?>
</section>
