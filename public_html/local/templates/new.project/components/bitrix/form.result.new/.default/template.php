<?php if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

echo $arResult["FORM_NOTE"];
if ("Y" == $arResult["isFormNote"]) {
    return;
}

if ($arResult["isFormImage"] == "Y"): ?>
    <a href="<?= $arResult["FORM_IMAGE"]["URL"] ?>" target="_blank" alt="<?= GetMessage("FORM_ENLARGE") ?>"><img
        src="<?= $arResult["FORM_IMAGE"]["URL"] ?>"
        <? if ($arResult["FORM_IMAGE"]["WIDTH"] > 300): ?>width="300"
        <? elseif ($arResult["FORM_IMAGE"]["HEIGHT"] > 200): ?>height="200"<? else: ?><?= $arResult["FORM_IMAGE"]["ATTR"] ?><? endif; ?>
        hspace="3" vscape="3" border="0"/></a>
<? endif; ?>
<?php

if ($arResult["isFormTitle"]) {
    echo "<h4>{$arResult["FORM_TITLE"]}</h4>";
}

if ($arResult["isFormErrors"] == "Y") {
    echo $arResult["FORM_ERRORS_TEXT"];
}

if ('TOP' == $arParams['SHOW_DESCRIPTION']) {
    echo '<div class="description">' . $arResult["FORM_DESCRIPTION"] . '</div>';
}

echo $arResult["FORM_HEADER"];

foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
    if ('hidden' == $arQuestion['STRUCTURE'][0]['FIELD_TYPE']) {
        echo $arQuestion["HTML_CODE"];
        continue;
    }

    $field_id = 'field_' . $arQuestion['STRUCTURE'][0]['ID'];

    $arQuestion['LABEL'] = '';
    if ("Y" === $arParams['SHOW_CAPTION']) {
        $arQuestion['LABEL'] = trim($arQuestion["CAPTION"]);
        if ($arQuestion['LABEL'] && "Y" === $arQuestion["REQUIRED"]) {
            $arQuestion['LABEL'] .= $arResult["REQUIRED_SIGN"];
        }

        if ($arQuestion['LABEL'] && "Y" == $arQuestion["IS_INPUT_CAPTION_IMAGE"]) {
            $arQuestion['LABEL'] .= $arQuestion["IMAGE"]["HTML_CODE"];
        }

        $arQuestion['LABEL'] = '<label for="' . $field_id . '">' . $arQuestion['LABEL'] . '</label>';
    }

    $arQuestion["ERROR"] = '';
    if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])) {
        $arQuestion["ERROR"] .= '<small class="d-block form-text text-muted text-danger">' .
            htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID]) .
            '</small>';
    }
?>
<div class="form-group">
<?php

switch ($arQuestion['STRUCTURE'][0]['FIELD_TYPE']) {
    case 'checkbox':
        echo $arQuestion["HTML_CODE"], $arQuestion['LABEL'], $arQuestion["ERROR"];
        break;

    default:
        echo $arQuestion['LABEL'], $arQuestion["HTML_CODE"], $arQuestion["ERROR"];
        break;
}

?>
</div>
<?php } ?>
<?php

if ($arResult["isUseCaptcha"] == "Y") {
    echo GetMessage("FORM_CAPTCHA_TABLE_TITLE");
    ?>
    <?= GetMessage("FORM_CAPTCHA_FIELD_TITLE") ?><?= $arResult["REQUIRED_SIGN"]; ?>
    <img src="/bitrix/tools/captcha.php?captcha_sid=<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>" width="180"
         height="40"/>
    <input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext"/>

    <input type="hidden" name="captcha_sid" value="<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>"/>
    <?
}

if ('BEFORE_SUBMIT' == $arParams['SHOW_DESCRIPTION']) {
    echo '<div class="description">' . $arResult["FORM_DESCRIPTION"] . '</div>';
}

?>
<p class="text-center">
    <input class="btn btn-primary"
        type="submit"
        name="web_form_submit"
        value="<?= htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>"
        <?= (intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : ""); ?> />
</p>
<?php

if ('BOTTOM' == $arParams['SHOW_DESCRIPTION']) {
    echo '<div class="description">' . $arResult["FORM_DESCRIPTION"] . '</div>';
}

echo $arResult["FORM_FOOTER"];
