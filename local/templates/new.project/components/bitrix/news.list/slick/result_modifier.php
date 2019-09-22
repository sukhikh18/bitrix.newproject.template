<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arParams["DISPLAY_TOP_PAGER"] = false;
$arParams["DISPLAY_BOTTOM_PAGER"] = false;
$arParams["ITEM_CLASS"] = 'slide';

if( empty($arParams['ROW_CLASS']) ) {
    $arParams['ROW_CLASS'] = '';
}
str_replace('row ', 'slick-row', $arParams['ROW_CLASS']);

$parentModitifier = __DIR__ . '/../.default/result_modifier.php';
if( is_file($parentModitifier) ) {
    include $parentModitifier;
}

$arConfParams = include __DIR__ . '/.parameters.php';

$arResult['SlickProps'] = array();

/**
 * Prepare slick props
 */
foreach ($arParams as $param => $value)
{
    $pos = strpos($param, 'SLICK_');

    if( !isset( $arConfParams[ $param ]['DEFAULT'] ) && 'N' === $value ) {
        continue;
    }
    elseif( isset($arConfParams[ $param ]) && $value == $arConfParams[ $param ]['DEFAULT'] ) {
        continue;
    }

    if( 0 === $pos ) {
        if( is_numeric($value) ) {
            $value = (float) $value;
        }
        else {
            switch ($value) {
                case 'Y': $value = true; break;
                case 'N': $value = false; break;
                default: $value = htmlspecialchars_decode($value); break;
            }
        }

        $arResult['SlickProps'][ str_replace('SLICK_', '', $param) ] = $value;
    }
}
