<?
if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

foreach ($arResult["QUESTIONS"] as $FIELD_SID => &$arQuestion) {
    // Keep hidden as hidden.
    if( 'hidden' === $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] ) {
        continue;
    }

    // Check a built in label.
    $q = array('');
    if (false != strpos($arQuestion["HTML_CODE"], '<br />')) {
        $q = explode('<br />', $arQuestion["HTML_CODE"]);
        $arQuestion["HTML_CODE"] = $q[1];
    }

    // Clear value and insert own placeholder attribute value.
    $arQuestion["HTML_CODE"] = preg_replace(
        "/value=\"(\w+)?\"/ui",
        "placeholder=\"" . $q[0] . "\" value=\"\"",
        $arQuestion["HTML_CODE"]
    );

    // Add form-control class.
    if( false === strpos($arQuestion["HTML_CODE"], 'class') ) {
        $arQuestion["HTML_CODE"] = str_replace('name', 'class="form-control" name', $arQuestion["HTML_CODE"]);
    }
    else {
        $arQuestion["HTML_CODE"] = str_replace('class="', 'class="form-control ', $arQuestion["HTML_CODE"]);
    }

    // Prepare form group label.
    $arQuestion['LABEL'] = ("Y" == $arParams['SHOW_CAPTION']) ? trim($arQuestion["CAPTION"]) : '';

    if ($arQuestion['LABEL'] && "Y" == $arQuestion["REQUIRED"]) {
        $arQuestion['LABEL'] .= $arResult["REQUIRED_SIGN"];
    }

    if ($arQuestion['LABEL'] && "Y" == $arQuestion["IS_INPUT_CAPTION_IMAGE"]) {
        $arQuestion['LABEL'] .= $arQuestion["IMAGE"]["HTML_CODE"];
    }

    if( $arQuestion['LABEL'] ) {
        $arQuestion['LABEL'] = sprintf('<label for="field_%s">%s</label>', $arQuestion['STRUCTURE'][0]['ID'], $arQuestion['LABEL']);
    }
}
