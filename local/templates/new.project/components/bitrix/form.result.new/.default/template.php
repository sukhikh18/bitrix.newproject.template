<? if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if ($arResult["isFormImage"] == "Y"): ?>
    <a href="<?= $arResult["FORM_IMAGE"]["URL"] ?>" target="_blank" alt="<?= GetMessage("FORM_ENLARGE") ?>"><img
                src="<?= $arResult["FORM_IMAGE"]["URL"] ?>"
                <? if ($arResult["FORM_IMAGE"]["WIDTH"] > 300): ?>width="300"
                <? elseif ($arResult["FORM_IMAGE"]["HEIGHT"] > 200): ?>height="200"<? else: ?><?= $arResult["FORM_IMAGE"]["ATTR"] ?><? endif; ?>
                hspace="3" vscape="3" border="0"/></a>
<? endif; ?>

<? if ($arResult["isFormTitle"]): ?><h4><?= $arResult["FORM_TITLE"] ?></h4><? endif; ?>
<?
if ('TOP' == $arParams['SHOW_DESCRIPTION']) {
    echo '<div class="description">' . $arResult["FORM_DESCRIPTION"] . '</div>';
}

echo $arResult["FORM_HEADER"];
foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
    if( 'hidden' == $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] ) {
        echo $arQuestion["HTML_CODE"];
        continue;
    }

    if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])) {
        printf('<span class="error-fld" title="%s"></span>', htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID]));
    }

    echo '<div class="form-group">';

    switch ($arQuestion['STRUCTURE'][0]['FIELD_TYPE']) {
        case 'checkbox':
            echo $arQuestion["HTML_CODE"], $arQuestion['LABEL'];
            break;

        default:
            echo $arQuestion['LABEL'], $arQuestion["HTML_CODE"];
            break;
    }

    echo '</div>';
}

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
    <input <?= (intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : ""); ?> type="submit"
                                                                                      name="web_form_submit"
                                                                                      value="<?= htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>"
                                                                                      class="btn btn-primary"/>
<?
if ('BOTTOM' == $arParams['SHOW_DESCRIPTION']) {
    echo '<div class="description">' . $arResult["FORM_DESCRIPTION"] . '</div>';
}
?>
<?= $arResult["FORM_FOOTER"]; ?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        /**
         * Serialize form data with files
         *
         * @param  [jQueryObject] $form form for serialize.
         * @return [FormData]
         */
        var serializeForm = function( $form ) {
            var formData = new FormData();

            // Append form data.
            var params = $form.serializeArray();
            $.each(params, function (i, val) {
                formData.append(val.name, val.value);
            });

            // Append files.
            $.each($form.find("input[type='file']"), function(i, tag) {
                $.each($(tag)[0].files, function(i, file) {
                    formData.append(tag.name, file);
                });
            });

            // Append is ajax mark.
            formData.append('is_ajax', 'Y');

            return formData;
        };

        var $form = $('form[name="<?= $arResult['arForm']['SID'] ?>"]'),
            $messages = $form.find('.messages');

        $form.on('submit', function (event) {
            event.preventDefault();

            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                dataType: 'HTML',
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                data: serializeForm($form)
            })
                .done(function(response) {
                    $messages.html( response );
                })
                .fail(function(response) {
                    console.log( response );
                })
        });
    });
</script>
