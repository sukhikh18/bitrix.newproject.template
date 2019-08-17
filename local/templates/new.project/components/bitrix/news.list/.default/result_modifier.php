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
 * Required?
 */
if(!function_exists('__esc_html')) {
    function __esc_html($value) {
        // return htmlspecialcharsEx($value);
        return $value;
    }
}

if(!function_exists('prepare_item_link')) {
    /**
     * @param  array  &$arItem  [description]
     * @param  array  $arParams [description]
     * @return void
     */
    function prepare_item_link(&$arItem, $arParams) {
        // disable access if link is empty
        if(strlen($arItem["DETAIL_PAGE_URL"]) <= 1) {
            $arItem["USER_HAVE_ACCESS"] = false;
        }

        $arItem['DETAIL_PAGE_URL'] = $arItem["USER_HAVE_ACCESS"] &&
            ("N" === $arParams["HIDE_LINK_WHEN_NO_DETAIL"] || $arItem["DETAIL_TEXT"])
            ? esc_url($arItem["DETAIL_PAGE_URL"]) : '';
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
if (empty($arParams['ROW_CLASS'])) $arParams['ROW_CLASS'] = 'row';
if (empty($arParams['ITEM_CLASS'])) $arParams['ITEM_CLASS'] = 'item';
if (empty($arParams["NAME_TAG"])) $arParams["NAME_TAG"] = 'h3';

// define list class
$SECTION_CLASS = array('news-list');
if ( ! empty($arParams['ITEM_CLASS'])) $SECTION_CLASS[] = $arParams['ITEM_CLASS'] . "-list";
if ( ! empty($arParams['IBLOCK_CODE'])) $SECTION_CLASS[] = "news-list_type_" . $arParams['IBLOCK_CODE'];
if ( ! empty($arParams['IBLOCK_ID'])) $SECTION_CLASS[] = "news-list_id_" . $arParams['IBLOCK_ID'];

$arResult['SECTION_CLASS'] = implode(' ', $SECTION_CLASS);

// define item column class
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
    /** @var string Y | N */
    $arItem["USER_HAVE_ACCESS"] = $arResult["USER_HAVE_ACCESS"];

    /** @var string */
    $arItem['COLUMN_CLASS'] = $arParams['ITEM_CLASS'] . '--column ' . $arParams['COLUMN_CLASS'];

    /** @var array HTML entities */
    $arItem["HTML"] = array(
        'PICT' => '',
        'NAME' => '',
        'DATE' => '',
        'DESC' => '',
        'MORE' => '',
    );

    prepare_item_link($arItem, $arParams);

    /**
     * Thumbnail with link maybe
     */
    if (isset($arParams['SORT_ELEMENTS']['PICT']) || $arParams['THUMBNAIL_POSITION']) {

        if ( ! empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
            $arItem['COLUMN_CLASS'] .= ' has-picture';

            // create img element
            $arItem["HTML"]["PICT"] = sprintf('<img src="%s" alt="%s">',
                esc_url($arItem["PREVIEW_PICTURE"]["SRC"]),
                esc_attr($arItem["NAME"])
            );

            // wrap to link
            if($arParams['PICTURE_URL']) {
                $arItem["HTML"]["PICT"] = sprintf('<a href="%s">%s</a>',
                    "DETAIL_PICTURE" === $arParams['PICTURE_URL'] ?
                        esc_url($arItem["DETAIL_PICTURE"]["SRC"]) : $arItem['DETAIL_PAGE_URL'],
                    $arItem["HTML"]["PICT"]
                );
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
        $arItem["HTML"]["PICT"] = sprintf('<div class="%s">%s</div>',
            $imageClass,
            $arItem["HTML"]["PICT"]
        );
    }

    /**
     * Name
     */
    if (isset($arParams['SORT_ELEMENTS']['NAME'])) {

        if( $arItem["NAME"] ) {
            $arItem["HTML"]["NAME"] = __esc_html($arItem["NAME"]);
        }

        if ($arItem['DETAIL_PAGE_URL']) {
            $arItem["HTML"]["NAME"] = sprintf('<a href="%s">%s</a>',
                $arItem['DETAIL_PAGE_URL'],
                $arItem["HTML"]["NAME"]
            );
        }

        // wrap to module box
        $arItem["HTML"]["NAME"] = sprintf('<%1$s class="%3$s">%2$s</%1$s>',
            esc_attr($arParams["NAME_TAG"]),
            $arItem["HTML"]["NAME"],
            esc_attr($arParams['ITEM_CLASS'] . '__name')
        );
    }

    /**
     * Date
     */
    if (isset($arParams['SORT_ELEMENTS']['DATE'])) {

        if($arItem["DISPLAY_ACTIVE_FROM"]) {
            $arItem["HTML"]["DATE"] = __esc_html($arItem["DISPLAY_ACTIVE_FROM"]);
        }

        // wrap to module box
        $arItem["HTML"]["DATE"] = sprintf('<div class="%s__date">%s</div>',
            esc_attr($arParams['ITEM_CLASS']),
            $arItem["HTML"]["DATE"]
        );
    }

    /**
     * Desc
     */
    if (isset($arParams['SORT_ELEMENTS']['DESC'])) {

        if($arItem["PREVIEW_TEXT"]) {
            $arItem["HTML"]["DESC"] = $arItem["PREVIEW_TEXT"];
        }

        $arItem["HTML"]["DESC"] = sprintf('<div class="%s__desc">%s</div>',
            esc_attr($arParams['ITEM_CLASS']),
            $arItem["HTML"]["DESC"]
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
            $arItem["HTML"]["SECT"] = $arSection['NAME'];
        }

        $arItem["HTML"]["SECT"] = sprintf('<div class="%s__sect">%s</div>',
            esc_attr($arParams['ITEM_CLASS']),
            $arItem["HTML"]["SECT"]
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
        ("N" === $arParams["HIDE_LINK_WHEN_NO_DETAIL"] || $arItem["DETAIL_TEXT"])) {

        $arItem["HTML"]["MORE"] = sprintf('<a class="%s__more" href="%s">%s</a>',
            esc_attr($arParams['ITEM_CLASS']),
            $arItem['DETAIL_PAGE_URL'] ? $arItem['DETAIL_PAGE_URL'] : '#',
            $arItem["MORE_LINK_TEXT"]
        );
    }

    /**
     * Properties
     */
    foreach ($arItem['DISPLAY_PROPERTIES'] as $propCode => $arProperty) {
        if(isset($arParams['SORT_ELEMENTS'][$propCode])) {

            if( is_array($arProperty['VALUE']) ) {
                $arProperty['VALUE'] = implode(', ', $arProperty['VALUE']);
            }

            if($arItem["PREVIEW_TEXT"]) {
                $arItem["HTML"][ $propCode ] = $arProperty['VALUE'];
            }

            $arItem["HTML"][ $propCode ] = sprintf('<div class="%1$s__prop %1$s-prop %1$s-prop__%2$s">%3$s</div>',
                esc_attr($arParams['ITEM_CLASS']),
                esc_attr(strtolower($propCode)),
                $arItem["HTML"][ $propCode ]
            );
        }
    }
}

$arParams['SORT_ELEMENTS'] = array_flip($arParams['SORT_ELEMENTS']);

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
