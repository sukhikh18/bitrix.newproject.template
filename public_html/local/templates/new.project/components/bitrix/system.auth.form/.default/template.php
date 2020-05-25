<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>
<div class="custom-auth">
    <form name="custom-auth-form" method="post" action="">
        <?php

        if ($arResult["BACKURL"] <> '') {
            echo '<input type="hidden" name="backurl" value="' . $arResult["BACKURL"] . '" />' . "\n";
        }

        foreach ($arResult["POST"] as $key => $value) {
            echo '<input type="hidden" name="' . $key . '" value="' . $value . '" />' . "\n";
        }

        ?>
        <input type="hidden" name="AUTH_FORM" value="Y" />
        <input type="hidden" name="TYPE" value="AUTH" />

        <div class="custom-auth__errors" data-entity="error-messages" style="color: red;">
            <?php if ('Y' === $arResult['SHOW_ERRORS'] && $arResult['ERROR'] && $arResult['ERROR_MESSAGE']) {
                ShowMessage($arResult['ERROR_MESSAGE']);
            } ?>
        </div>

        <div class="form-group form-group--name">
            <input type="text"
                name="USER_LOGIN"
                class="form-control"
                placeholder="Логин или эл. почта"
                autocomplete="username"
                maxlength="50" />
            <script>
                BX.ready(function () {
                    var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
                    if (loginCookie) {
                        var form = document.forms["custom-auth-form"];
                        var loginInput = form.elements["USER_LOGIN"];
                        loginInput.value = loginCookie;
                    }
                });
            </script>
        </div>

        <div class="form-group form-group--pwd">
            <input type="password"
                name="USER_PASSWORD"
                class="form-control"
                placeholder="Введите пароль"
                autocomplete="current-password"
                maxlength="50" />
        </div>

        <div class="form-group form-group--remember">
            <?php if ("Y" === $arResult["STORE_PASSWORD"]): ?>
                <label class="form-check">
                    <input
                        type="checkbox"
                        name="USER_REMEMBER"
                        class="form-check-input"
                        value="Y" />
                    <span class="form-check-label"><?= GetMessage("AUTH_REMEMBER_ME") ?></span>
                </label>
            <? endif ?>
        </div>

        <? if ($arResult["CAPTCHA_CODE"] && 'Y' == $arResult["USE_CAPTCHA"]) : ?>
        <div class="form-group">
            <div class="form-group form-captcha">
                <label class="d-flex justify-content-between"><?= GetMessage("REGISTER_CAPTCHA_PROMT") ?>:
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>"
                width="180" height="40" alt="CAPTCHA"/></label>
                <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
                <input type="text" name="captcha_word" maxlength="50" value="" class="form-control" autocomplete="off" />
            </div>
        </div>
        <?php endif; ?>

        <? /* @todo if ($arResult["AUTH_SERVICES"]): ?>
            <div class="auth-form__social-login mt-4">
                <span>Войти с помощью:</span>
                <? $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "flat",
                    array(
                        "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
                        "SUFFIX" => "form",
                    ),
                    $component->__parent,
                    array("HIDE_ICONS" => "Y")
                ); ?>
            </div>
        <? endif */ ?>

        <p class="custom-auth__action">
            <button class="btn btn-primary" type="submit">Войти</button>
        </p>

        <p class="custom-auth__other">
            <? if ($arResult["NEW_USER_REGISTRATION"] == "Y"): ?>
                <a class="register" href="<?= PATH_TO_REGISTER ?>" rel="nofollow">Регистрация</a> |
            <? endif ?>

            <a class="forgot" href="<?= PATH_TO_FORGOT_PASSWORD ?>" rel="nofollow">Забыли пароль?</a>
        </p>
    </form>
</div>
