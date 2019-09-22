<?
if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if(!function_exists('esc_attr')) {
    function esc_attr($value) {
        return htmlspecialcharsEx($value);
    }
}

if(!function_exists('esc_url')) {
    function esc_url($value) {
        return htmlspecialcharsEx($value);
    }
}

/**
 * @todo INSERT TO PARAMS
 */
$arParams['PICTURE_URL'] = 'DETAIL_PAGE'; // || "" || DETAIL_PICTURE;

// define iblock code
$res = CIBlock::GetByID($arParams['IBLOCK_ID']);
if ($ar_res = $res->GetNext()) $arParams['IBLOCK_CODE'] = $ar_res['CODE'];

// define empty variables
if (empty($arParams['COLUMNS'])) $arParams['COLUMNS'] = 1;
if (empty($arParams['SORT_ELEMENTS'])) $arParams['SORT_ELEMENTS'] = 'PICT,NAME,DESC,MORE';
$arResult['VAR']['ROW_CLASS'] = !empty($arParams['ROW_CLASS']) ? $arParams['ROW_CLASS'] : 'row';
if (empty($arParams['ITEM_CLASS'])) $arParams['ITEM_CLASS'] = 'item';
if (empty($arParams["NAME_TAG"])) $arParams["NAME_TAG"] = 'h3';

// define list class
$SectionClass = array('news-list');
if ( ! empty($arParams['ITEM_CLASS']))  $SectionClass[] = $arParams['ITEM_CLASS'] . "-list";
if ( ! empty($arParams['IBLOCK_CODE'])) $SectionClass[] = "news-list_type_" . $arParams['IBLOCK_CODE'];
if ( ! empty($arParams['IBLOCK_ID']))   $SectionClass[] = "news-list_id_" . $arParams['IBLOCK_ID'];

$arResult['VAR']['SECTION_CLASS'] = implode(' ', $SectionClass);

// define item column base attributes
$arParams['COLUMN_CLASS'] = function_exists('get_column_class') ?
    get_column_class($arParams['COLUMNS']) : 'columns-' . $arParams['COLUMNS'];

// prepare sort elements string
$arParams['SORT_ELEMENTS'] = array_flip(array_map(function ($value) {
    $value = function_exists('mb_strtoupper') ? mb_strtoupper($value) : strtoupper($value);

    return trim($value);
}, explode(',', $arParams['SORT_ELEMENTS'])));

// insert in template on custom position
if ($arParams['THUMBNAIL_POSITION']) {
    unset($arParams['SORT_ELEMENTS']['PICT']);
}

// Transfer to epilogue
if ($cp = $this->__component) {
    $cp->arResult['SECTION_CLASS'] = $arResult['SECTION_CLASS'];
    $cp->arParams['ROW_CLASS']     = $arParams['ROW_CLASS'];

    $cp->SetResultCacheKeys(array('SECTION_CLASS'));
}

foreach ($arResult["ITEMS"] as &$arItem) {
    // add edit areas
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
            CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'],
        CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array(
            "CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')
        ));

    /** @var string Y | N */
    $arItem["USER_HAVE_ACCESS"] = $arResult["USER_HAVE_ACCESS"];

    /** @var string */
    $arItem['COLUMN_CLASS'] = $arParams['ITEM_CLASS'] . '--column ' . $arParams['COLUMN_CLASS'];

    /** @var array HTML entities */
    $arItem["VAR"] = array(
        'PICT' => '',
        'NAME' => '',
        'DATE' => '',
        'DESC' => '',
        'MORE' => '',
    );

    // disable access if link is empty
    if(strlen($arItem["DETAIL_PAGE_URL"]) <= 1) {
        $arItem["USER_HAVE_ACCESS"] = false;
    }

    $arItem['DETAIL_PAGE_URL'] = $arItem["USER_HAVE_ACCESS"] &&
        ("N" === $arParams["HIDE_LINK_WHEN_NO_DETAIL"] || $arItem["DETAIL_TEXT"])
        ? esc_url($arItem["DETAIL_PAGE_URL"]) : '#';

    if( !empty($arParams['LINK_BY_PROPERTY']) ) {
        if( "Y" !== $arParams['USE_DETAIL_IS_PROP_EMPTY'] &&
            empty($arItem['PROPERTIES'][ $arParams['LINK_BY_PROPERTY'] ]['VALUE']) ) {
            $arItem['DETAIL_PAGE_URL'] = "#";
        }
        else {
            $arItem['DETAIL_PAGE_URL'] = $arItem['PROPERTIES'][ $arParams['LINK_BY_PROPERTY'] ]['VALUE'];
        }
    }

    /**
     * Thumbnail with link maybe
     */
    if (isset($arParams['SORT_ELEMENTS']['PICT']) || $arParams['THUMBNAIL_POSITION']) {

        if ( ! empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
            $arItem['COLUMN_CLASS'] .= ' has-picture';

            // create img element
            $arItem["VAR"]["PICT"] = sprintf('<img src="%s" alt="%s">',
                esc_url($arItem["PREVIEW_PICTURE"]["SRC"]),
                esc_attr($arItem["NAME"])
            );

            // wrap to link
            if($arParams['PICTURE_URL']) {
                $pictureUrl = "DETAIL_PICTURE" === $arParams['PICTURE_URL'] ?
                    esc_url($arItem["DETAIL_PICTURE"]["SRC"]) : $arItem['DETAIL_PAGE_URL'];

                if( $pictureUrl ) {
<<<<<<< Updated upstream
                    $arItem["HTML"]["PICT"] = sprintf('<a href="%s">%s</a>',
                        $pictureUrl,
                        $arItem["HTML"]["PICT"]
=======
                    $arItem["VAR"]["PICT"] = sprintf('<a href="%s">%s</a>',
                        $pictureUrl,
                        $arItem["VAR"]["PICT"]
>>>>>>> Stashed changes
                    );
                }
            }
        }

        $imageClass = esc_attr($arParams['ITEM_CLASS']) . '__pict';

        switch ($arParams['THUMBNAIL_POSITION']) {
            case 'RIGHT':
            case 'FLOAT_R':
                $imageClass = 'alignright ' . $imageClass;
                break;

            case 'LEFT':
            case 'FLOAT_L':
                $imageClass = 'alignleft ' . $imageClass;
                break;
        }

        // wrap to module box
        $arItem["VAR"]["PICT"] = sprintf('<div class="%s">%s</div>',
            $imageClass,
            $arItem["VAR"]["PICT"]
        );
    }

    /**
     * Name
     */
    if (isset($arParams['SORT_ELEMENTS']['NAME'])) {

        if( $arItem["NAME"] ) {
            $arItem["VAR"]["NAME"] = $arItem["NAME"]; // strip_tags?
        }

        if ($arItem['DETAIL_PAGE_URL']) {
            $arItem["VAR"]["NAME"] = sprintf('<a href="%s">%s</a>',
                $arItem['DETAIL_PAGE_URL'],
                $arItem["VAR"]["NAME"]
            );
        }

        // wrap to module box
        $arItem["VAR"]["NAME"] = sprintf('<%1$s class="%3$s">%2$s</%1$s>',
            esc_attr($arParams["NAME_TAG"]),
            $arItem["VAR"]["NAME"],
            esc_attr($arParams['ITEM_CLASS'] . '__name')
        );
    }

    /**
     * Date
     */
    if (isset($arParams['SORT_ELEMENTS']['DATE'])) {

        if($arItem["DISPLAY_ACTIVE_FROM"]) {
            $arItem["VAR"]["DATE"] = strip_tags($arItem["DISPLAY_ACTIVE_FROM"]);
        }

        // wrap to module box
        $arItem["VAR"]["DATE"] = sprintf('<div class="%s__date">%s</div>',
            esc_attr($arParams['ITEM_CLASS']),
            $arItem["VAR"]["DATE"]
        );
    }

    /**
     * Desc
     */
    if (isset($arParams['SORT_ELEMENTS']['DESC'])) {

        if($arItem["PREVIEW_TEXT"]) {
            $arItem["VAR"]["DESC"] = $arItem["PREVIEW_TEXT"];
        }

        $arItem["VAR"]["DESC"] = sprintf('<div class="%s__desc">%s</div>',
            esc_attr($arParams['ITEM_CLASS']),
            $arItem["VAR"]["DESC"]
        );
    }

    /**
     * Section name
     */
    if (isset($arParams['SORT_ELEMENTS']['SECT'])) {
        // Get section name by id
        $arSection = \Bitrix\Iblock\SectionTable::getList(array(
            'select' => array('ID', 'NAME'),
            'filter' => array('=ID' => $arItem['IBLOCK_SECTION_ID']),
        ))->fetch();

        if($arItem["PREVIEW_TEXT"]) {
            $arItem["VAR"]["SECT"] = $arSection['NAME'];
        }

        $arItem["VAR"]["SECT"] = sprintf('<div class="%s__sect">%s</div>',
            esc_attr($arParams['ITEM_CLASS']),
            $arItem["VAR"]["SECT"]
        );
    }

    /**
     * @todo in future
     */
    $arItem['MORE_LINK_TEXT'] = $arParams["MORE_LINK_TEXT"];
    // if( !empty($arItem['PROPERTIES'][ $arParams['EXTERNAL_LINK_PROPERTY'] ]['VALUE']) ) {
    //     $arItem['DETAIL_PAGE_URL'] = $arItem['PROPERTIES'][ $arParams['EXTERNAL_LINK_PROPERTY'] ]['VALUE'];
    //     $arItem['MORE_LINK_TEXT'] = 'Читать в источнике';
    // }

    /**
     * More button
     */
    if (isset($arParams['SORT_ELEMENTS']['MORE']) && ! empty($arItem["MORE_LINK_TEXT"]) &&
        ("Y" !== $arParams["HIDE_LINK_WHEN_NO_DETAIL"] || $arItem["DETAIL_TEXT"])) {

<<<<<<< Updated upstream
        $arItem["HTML"]["MORE"] = sprintf('<div class="%s__more"><a href="%s">%s</a></div>',
=======
        $arItem["VAR"]["MORE"] = sprintf('<div class="%s__more"><a class="btn" href="%s">%s</a></div>',
>>>>>>> Stashed changes
            esc_attr($arParams['ITEM_CLASS']),
            $arItem['DETAIL_PAGE_URL'] ? $arItem['DETAIL_PAGE_URL'] : '#',
            $arItem["MORE_LINK_TEXT"]
        );
    }

    /**
     * Properties
     */
    foreach ($arItem['DISPLAY_PROPERTIES'] as $propCode => $arProperty) {
        if(isset($arParams['SORT_ELEMENTS']['PROP_' . $propCode])) {

            if( is_array($arProperty['VALUE']) ) {
                $arProperty['VALUE'] = implode(', ', $arProperty['VALUE']);
            }

            if($arItem["PREVIEW_TEXT"]) {
                $arItem["VAR"]['PROP_' . $propCode] = $arProperty['VALUE'];
            }

            $arItem["VAR"]['PROP_' . $propCode] = sprintf('<div class="%1$s__prop %1$s-prop %1$s-prop__%2$s">%3$s</div>',
                esc_attr($arParams['ITEM_CLASS']),
                esc_attr(strtolower($propCode)),
                $arItem["VAR"]['PROP_' . $propCode]
            );
        }
    }

    $arItem['VAR']['COLUMN_ID'] = $this->GetEditAreaId($arItem['ID']);
    $arItem['VAR']['COLUMN_CLASS'] = $arItem['COLUMN_CLASS'];

    $arItem['VAR']['ARTICLE_CLASS'] = $arParams['ITEM_CLASS'];
    if(in_array($arParams['THUMBNAIL_POSITION'], array('LEFT', 'RIGHT'))) {
        $arItem['VAR']['ARTICLE_CLASS'] = 'media ' . $arItem['VAR']['ARTICLE_CLASS'];
    }

    $arResult['VAR']['BEFORE_ARTICLE_BODY'] = in_array($arParams['THUMBNAIL_POSITION'],
        array('LEFT', 'FLOAT_L', 'FLOAT_R')) ? $arItem['VAR']['PICT'] : '';

    $arResult['VAR']['AFTER_ARTICLE_BODY'] = 'RIGHT' == $arParams['THUMBNAIL_POSITION'] ?
        $arItem['VAR']['PICT'] : '';

    if ($arItem['DETAIL_PAGE_URL'] && $arParams['USE_GLOBAL_LINK']) {
        $AFTER_ARTICLE_BODY .= "\r\n<a href=\"{$arItem['DETAIL_PAGE_URL']}\"></a>";
    }
}

foreach ($arResult["ITEMS"] as &$arItem) {
    $sort = array_flip( $arParams['SORT_ELEMENTS'] );
    $arItem['VAR']['SHOW_ELEMENTS'] = function() use ($sort, $arItem) {
        foreach ($sort as $elem) {
            if (isset($arItem['VAR'][$elem])) echo $arItem['VAR'][$elem];
        }
    };
}

/**
 * Lazy load || Infinity scroll
 *
 * @fix it if is change SEO_URL
 */
$paramName  = 'PAGEN_' . $arResult['NAV_RESULT']->NavNum;
$paramValue = $arResult['NAV_RESULT']->NavPageNomer;
$pageCount  = $arResult['NAV_RESULT']->NavPageCount;

$arResult['MORE_ITEMS_LINK'] = '';
if ($arResult['NAV_RESULT']->NavPageCount <= 1) {
    $arParams['LAZY_LOAD'] = "N";
} elseif ($paramValue < $pageCount) {
    $arResult['MORE_ITEMS_LINK'] = htmlspecialcharsbx(
        $APPLICATION->GetCurPageParam(
            sprintf('%s=%s', $paramName, ++$paramValue),
            array($paramName, 'LAZY_LOAD')
        )
    );
}

if ("Y" == $arParams['LAZY_LOAD'] && ! empty($_GET['LAZY_LOAD'])) {
    $arResult['VAR']['BEFORE_ROW'] = "<!--RestartBuffer-->";
}
elseif( $arParams["DISPLAY_TOP_PAGER"] ) {
    $arResult['VAR']['BEFORE_ROW'] = sprintf('<div class="%1$s_%2$s__pager %1$s_%2$__pager_top">%3$s</div>',
        $arParams['IBLOCK_CODE'],
        $arParams['ITEM_CLASS'],
        $arResult["NAV_STRING"]
    );
}

$arResult['VAR']['AFTER_ROW'] = '';
if ($arParams["DISPLAY_BOTTOM_PAGER"]) {
    $arResult['VAR']['AFTER_ROW'] = sprintf('<div class="%1$s_%2$s__pager %1$s_%2$__pager_bottom">%3$s</div>',
        $arParams['IBLOCK_CODE'],
        $arParams['ITEM_CLASS'],
        $arResult["NAV_STRING"]
    );
}

if ($arResult['MORE_ITEMS_LINK'] && "Y" == $arParams['LAZY_LOAD']) {
    $arResult['VAR']['AFTER_ROW'].= '
    <div class="ajax-pager-wrap">
        <a class="more-items-link btn btn-red" href="'.$arResult['MORE_ITEMS_LINK'].'">больше<br> статей</a>
    </div>';
}

if ("Y" == $arParams['LAZY_LOAD'] && ! empty($_GET['LAZY_LOAD'])) {
    $arResult['VAR']['AFTER_ROW'].= '<!--RestartBuffer-->';
}
