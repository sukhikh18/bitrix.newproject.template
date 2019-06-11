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

// included from news.list/{tpl_name}/template.php

$HTML = array(
    'image' => '',
    'title' => '',
    'gl-link-start' => '',
    'gl-link-end'
);

$hasPicture = "Y" == $arParams["DISPLAY_PICTURE"] && !empty($arItem["PREVIEW_PICTURE"]["SRC"]);

$columnClass = $arParams['ITEM_CLASS'].' '.$arParams['COLUMN_CLASS'];
if( $hasPicture )
    $columnClass.= ' has-picture';

if( $hasPicture ) {
    $HTML['image'] = function_exists('bx_get_image') ?
        bx_get_image($arItem["PREVIEW_PICTURE"]) : '<img src="'. $arItem["PREVIEW_PICTURE"]["SRC"] .'">';

    if( "Y" == $arParams['PICTURE_DETAIL_URL'] && !empty($arItem["DETAIL_PICTURE"]["SRC"]) ) {
        $HTML['image'] = sprintf('<a href="%s" class="zoom">%s</a>',
            $arItem["DETAIL_PICTURE"]["SRC"],
            $HTML['image']
        );

        if("Y" == $arParams['WIDE_GLOBAL_LINK'])
            $HTML['image'] = '<object>' .$HTML['image']. '</object>';
    }
}

if("Y" == $arParams['WIDE_GLOBAL_LINK']) {
    // add wide global link
    $HTML['gl-link-start'] = "<a href=". $arItem["DETAIL_PAGE_URL"] .">";
    $HTML['gl-link-end'] = '</a>';
}
else {
    if("Y" != $arParams['HIDE_GLOBAL_LINK'] && $arItem["DETAIL_PAGE_URL"]) {
        // Add link to image
        if( "Y" != $arParams['PICTURE_DETAIL_URL'] || empty($arItem["DETAIL_PICTURE"]["SRC"]) ) {
            $HTML['image'] = sprintf('<a href="%s">%s</a>',
                $arItem["DETAIL_PAGE_URL"],
                $HTML['image']
            );
        }

        // add link to title
        $HTML['title'] = sprintf('<a href="%s">%s</a>',
            $arItem["DETAIL_PAGE_URL"],
            $arItem["NAME"]
        );
    }
}

if("Y" == $arParams["DISPLAY_NAME"]) {
    if( !$HTML['title'] )
        $HTML['title'] = $arItem["NAME"];

    $HTML['title'] = sprintf('<%1$s class="%3$s__name">%2$s</%1$s>',
        $arParams["NAME_TAG"],
        $HTML['title'],
        $arParams['ITEM_CLASS']
    );
}
?>
        <div class="<?=$columnClass;?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>"><?=$HTML['gl-link-start'];?>
            <article class="media <?=$arParams['ITEM_CLASS'];?>">
                <div class="<?=$arParams['ITEM_CLASS'];?>__image"><?=$HTML['image'];?></div>

                <div class="media-body <?=$arParams['ITEM_CLASS'];?>__body">
                    <?=$HTML['title'];?>

                    <?php
                    if( "Y" == $arParams["DISPLAY_DATE"] && $arItem["DISPLAY_ACTIVE_FROM"]) {
                        printf('<div class="%s__date">%s</div>',
                            $arParams['ITEM_CLASS'],
                            $arItem["DISPLAY_ACTIVE_FROM"]
                        );
                    }

                    if( "Y" == $arParams["DISPLAY_PREVIEW_TEXT"] && $arItem["PREVIEW_TEXT"]) {
                        printf('<div class="%s__desc">%s</div>',
                            $arParams['ITEM_CLASS'],
                            $arItem["PREVIEW_TEXT"]
                        );
                    }
                    ?>

                    <?=$arItem["DETAIL_PAGE_URL_HTML"];?>
                </div>
            </article>
        <?=$HTML['gl-link-end'];?></div>