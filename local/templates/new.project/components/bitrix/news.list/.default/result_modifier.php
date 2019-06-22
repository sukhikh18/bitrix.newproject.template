<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$res = CIBlock::GetByID( $arParams['IBLOCK_ID'] );
if($ar_res = $res->GetNext()) {
    $arParams['IBLOCK_CODE'] = $ar_res['CODE'];
}

if( empty($arParams['COLUMNS']) ) $arParams['COLUMNS'] = 1;

$SECTION_CLASS = array('news-list');
if( !empty($arParams['ITEM_CLASS']) )  $SECTION_CLASS[] = $arParams['ITEM_CLASS'] . "-list";
if( !empty($arParams['IBLOCK_CODE']) ) $SECTION_CLASS[] = "news-list_type_" . $arParams['IBLOCK_CODE'];
if( !empty($arParams['IBLOCK_ID']) )   $SECTION_CLASS[] = "news-list_id_" . $arParams['IBLOCK_ID'];
$arResult['SECTION_CLASS'] = implode(' ', $SECTION_CLASS);

$arParams['COLUMN_CLASS'] = function_exists('get_column_class') ?
    get_column_class($arParams['COLUMNS']) : 'columns-' . $arParams['COLUMNS'];

/**
 * Set defaults html attrs
 */
if( empty($arParams['ROW_CLASS']) ) $arParams['ROW_CLASS'] = 'row';
if( empty($arParams['ITEM_CLASS']) ) $arParams['ITEM_CLASS'] = 'item';
if( empty($arParams["NAME_TAG"]) ) $arParams["NAME_TAG"] = 'h3';

foreach ($arResult["ITEMS"] as &$arItem)
{
    // disable access if is link empty (not exists)
    if( !$arItem["DETAIL_PAGE_URL"] || "#" == $arItem["DETAIL_PAGE_URL"] )
        $arResult["USER_HAVE_ACCESS"] = false;

    $arItem['DETAIL_PAGE_URL'] = ("N" != $arParams["HIDE_LINK_WHEN_NO_DETAIL"]) ||
        ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"]) ? $arItem["DETAIL_PAGE_URL"] : false;

    /**
     * @todo
     * /
    if( !empty($arItem['PROPERTIES'][ $arParams['EXTERNAL_LINK_PROPERTY'] ]['VALUE']) ) {
        $arItem['DETAIL_PAGE_URL'] = $arItem['PROPERTIES'][ $arParams['EXTERNAL_LINK_PROPERTY'] ]['VALUE'];
        $more = 'читать в источнике';
    } // */

    if( !empty($arItem['DETAIL_PAGE_URL']) && "Y" == $arParams["DISPLAY_MORE_LINK"] ) {
        $arItem['DETAIL_PAGE_URL_HTML'] = printf('<a class="item__more" href="%s">%s</a>',
            $arItem['DETAIL_PAGE_URL'],
            $arParams["MORE_LINK_TEXT"]
        );
    }

    $arItem['HTML'] = array(
        'IMAGE' => '',
        'NAME' => '',
        'GL_LINK_START' => '',
        'GL_LINK_END' => '',
    );

    /** @var string */
    $arItem['COLUMN_CLASS'] = $arParams['ITEM_CLASS'].'--column '.$arParams['COLUMN_CLASS'];

    /**
     * Set preview picture
     */
    if( "Y" == $arParams["DISPLAY_PICTURE"] && !empty($arItem["PREVIEW_PICTURE"]["SRC"]) ) {
        $columnClass .= ' has-picture';

        $arItem['HTML']['IMAGE'] = sprintf('<img src="%s" alt="">',
            $arItem["PREVIEW_PICTURE"]["SRC"]);

        /** @var string $arParams['PICTURE_DETAIL_URL'] Y|N */
        if( "Y" == $arParams['PICTURE_DETAIL_URL'] && !empty($arItem["DETAIL_PICTURE"]["SRC"]) ) {
            $arItem['HTML']['IMAGE'] = sprintf('<a href="%s" class="zoom">%s</a>',
                $arItem["DETAIL_PICTURE"]["SRC"],
                $arItem['HTML']['IMAGE']
            );

            if("Y" == $arParams['WIDE_GLOBAL_LINK']) {
                $arItem['HTML']['IMAGE'] = '<object>' .$arItem['HTML']['IMAGE']. '</object>';
            }
        }
    }

    /**
     * Set name html
     * @var string $arParams["DISPLAY_NAME"] Y|N
     */
    if("Y" == $arParams["DISPLAY_NAME"]) {
        $arItem['HTML']['NAME'] = sprintf('<%1$s class="%3$s__name">%2$s</%1$s>',
            $arParams["NAME_TAG"],
            $arItem["NAME"],
            $arParams['ITEM_CLASS']
        );
    }

    /**
     * Set global link wrapper
     */
    if("Y" == $arParams['WIDE_GLOBAL_LINK']) {
        // add wide global link
        $arItem['HTML']['GL_LINK_START'] = "<a href=". $arItem["DETAIL_PAGE_URL"] .">";
        $arItem['HTML']['GL_LINK_END'] = '</a>';
    }
    else {
        if("Y" != $arParams['HIDE_GLOBAL_LINK'] && $arItem["DETAIL_PAGE_URL"]) {
            // Add link to image
            if( "Y" != $arParams['PICTURE_DETAIL_URL'] || empty($arItem["DETAIL_PICTURE"]["SRC"]) ) {
                $arItem['HTML']['IMAGE'] = sprintf('<a href="%s">%s</a>',
                    $arItem["DETAIL_PAGE_URL"],
                    $arItem['HTML']['IMAGE']
                );
            }

            // add title link
            $arItem['HTML']['NAME'] = sprintf('<a href="%s">%s</a>',
                $arItem["DETAIL_PAGE_URL"],
                $arItem["NAME"]
            );
        }
    }
}
