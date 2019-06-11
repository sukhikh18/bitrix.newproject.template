<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

foreach ($arResult["QUESTIONS"] as $FIELD_SID => &$arQuestion) {
    $q = array('');
    if( false != strpos($arQuestion["HTML_CODE"], '<br />') ) {
        $q = explode('<br />', $arQuestion["HTML_CODE"]);
        // $arQuestion["PLACEHOLDER"] = $q[0];
        $arQuestion["HTML_CODE"] = $q[1];
    }

    // $arQuestion["HTML_CODE"] = str_replace('value', 'placeholder', $arQuestion["HTML_CODE"]);
    if( false != strpos($arQuestion["HTML_CODE"], 'value=""') ) {
        $arQuestion["HTML_CODE"] = str_replace('value=""', 'placeholder="'. $q[0] .'"', $arQuestion["HTML_CODE"]);
    }
    elseif( isset($q[0]) ) {
        $pattern = "/value=\"(\w+)\"/ui";
        $replacement = "placeholder=\"". $q[0] ."\"";
        $arQuestion["HTML_CODE"] = preg_replace($pattern, $replacement, $arQuestion["HTML_CODE"]);
    }
}
