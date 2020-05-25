<?php
/**
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 * @global CUser $USER
 * @global CMain $APPLICATION
 */

if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Security\Random;

?>
<div class="custom-auth">
    <form name="custom-register-form" method="post" action="<?= POST_FORM_ACTION_URI ?>" enctype="multipart/form-data">
        <input type="hidden" name="register_submit_button" value="1">
        <? if ($arResult["BACKURL"] <> '') {
            echo '<input type="hidden" name="backurl" value="' . $arResult["BACKURL"] . '" />';
        } ?>

        <div class="custom-auth__errors" data-entity="error-messages">
            <?php
            if (count($arResult["ERRORS"]) > 0) {
                foreach ($arResult["ERRORS"] as $key => $error) {
                    if (intval($key) == 0 && $key !== 0) {
                        $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#",
                            "&quot;" . GetMessage("REGISTER_FIELD_" . $key) . "&quot;", $error);
                    }
                }

                ShowError(implode("<br />", $arResult["ERRORS"]));
            } elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y") {
                echo '<p>' . GetMessage("REGISTER_EMAIL_WILL_BE_SENT") . '</p>';
            }
            ?>
        </div>

        <?php
        foreach ($arResult["SHOW_FIELDS"] as $FIELD) {
            switch ($FIELD) {
                case 'LOGIN':
                    /*?>
                    <div class="form-group form-name">
                        <label>Введите ваш новый логин</label>
                        <input type="text" placeholder="Логин" name="REGISTER[LOGIN]"
                            value="<?= $arResult["VALUES"]["LOGIN"] ?>" class="form-control" autocomplete="login" />
                    </div>
                    */ ?>
                    <input type="hidden" name="REGISTER[LOGIN]" value="<?= Random::getString(4); ?>" />
                    <?php
                    break;

                case 'NAME':
                    ?>
                    <div class="form-group form-name">
                        <label>Введите ваше имя</label>
                        <input type="text" placeholder="Ф.И.О." name="REGISTER[NAME]"
                            value="<?= $arResult["VALUES"]["NAME"] ?>" class="form-control" autocomplete="name" />
                    </div>
                    <?php
                    break;

                case 'PERSONAL_PHONE':
                    ?>
                    <div class="form-group form-personal_phone">
                        <label>Введите ваш номер телефона</label>
                        <input type="tel" placeholder="Номер телефона" name="REGISTER[PERSONAL_PHONE]"
                            value="<?= $arResult["VALUES"]["PERSONAL_PHONE"] ?>" class="form-control" autocomplete="tel" />
                    </div>
                    <?php
                    break;

                case 'EMAIL':
                    ?>
                    <div class="form-group form-email">
                        <label>Введите ваш Email</label>
                        <input type="text" placeholder="Электронная почта" name="REGISTER[EMAIL]"
                            value="<?= $arResult["VALUES"]["EMAIL"] ?>" class="form-control" autocomplete="email" required="true" />
                    </div>
                    <?php
                    break;

                case 'USER_PROPERTIES':
                foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField) {
                    // @todo 'string' == ['USER_TYPE']['USER_TYPE_ID']
                    /*$APPLICATION->IncludeComponent(
                    "bitrix:system.field.edit",
                    $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                    array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS"=>"Y"));*/
                    ?>
                    <div class="form-group form-<?= strtolower($FIELD_NAME) ?>">
                        <label><?= $arUserField['EDIT_FORM_LABEL'] ?></label>
                        <?php
                        if('UF_CITY' === $FIELD_NAME) {
                            /** @var Bitrix\Main\ORM\Query\Result $resCities [description] */
                            $resCities = \Bitrix\Sale\Location\LocationTable::getList(array(
                                'filter' => array(
                                    '=NAME.LANGUAGE_ID' => LANGUAGE_ID,
                                    '=TYPE_CODE' => 'CITY',
                                ),
                                'select' => array(
                                    'ID' => 'ID',
                                    'NAME_RU' => 'NAME.NAME',
                                    'TYPE_CODE' => 'TYPE.CODE',
                                )
                            ));

                            echo '<select name="'. $FIELD_NAME .'" class="form-control">';
                            echo "<option></option>";

                            /** @var array $arCity ['ID', 'NAME_RU', 'TYPE_CODE'] */
                            while ($arCity = $resCities->fetch()) {
                                echo "<option value=\"{$arCity['ID']}:{$arCity['NAME_RU']}\">{$arCity['NAME_RU']}</option>";
                            }

                            echo '</select>';
                        } else {
                            ?>
                            <input type="text" name="<?= $FIELD_NAME ?>" value="<?= $arResult["VALUES"][$FIELD_NAME] ?>" class="form-control">
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                    break;

                case 'PASSWORD':
                    ?>
                    <div class="form-group form-email">
                        <label>Введите ваш новый пароль</label>
                        <input type="password" placeholder="Пароль" name="REGISTER[PASSWORD]" class="form-control"
                            value="<?= $arResult["VALUES"]["PASSWORD"] ?>" style="background: inherit;"
                            autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly />
                    </div>
                    <?php
                    break;

                case 'CONFIRM_PASSWORD':
                    ?>
                    <input type="hidden" name="REGISTER[CONFIRM_PASSWORD]" class="form-control" autocomplete="off"
                        value="<?= $arResult["VALUES"]["CONFIRM_PASSWORD"] ?: '1' ?>" readonly />
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var password = document['custom-register-form']['REGISTER[PASSWORD]'],
                                confirm = document['custom-register-form']['REGISTER[CONFIRM_PASSWORD]'];

                            if(confirm.hasAttribute('readonly')) {
                                confirm.removeAttribute('readonly');
                            }

                            password.addEventListener('keyup', function(e) {
                                confirm.value = password.value;
                            });
                        });
                    </script>
                    <?php
                    break;

                default:
                    ?>
                    <div class="form-group">
                        <input type="text" class="form-control" name="REGISTER[<?= $FIELD ?>]"
                            value="<?= $arResult["VALUES"][$FIELD] ?>" />
                    </div>
                    <?php
                    break;
            }
        }

        ?>
        <? if ('Y' == $arResult["USE_CAPTCHA"]) : ?>
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

        <div class="form-helpers">
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="privacy_accept" value="Y">
                    <span class="form-check-label">
                        Нажимая кнопку "Зарегистрироваться", я подтверждаю, что я ознакомился с
                        <a href="/politika-konfidentsialnosti/" target="_blank">политикой обработки персональных данных</a>
                        и даю согласие на обработку мои персональных данных
                    </span>
                </label>
            </div>
        </div>

        <div class="submit-wrap mt-2 mb-2">
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </div>

        <?php /*
        if ($arResult["AUTH_SERVICES"]):?>
            <div class="social-login social-register">
                <span>Зарегистрироваться с помощью:</span>
                <? $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "flat",
                    array(
                        "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
                        "SUFFIX" => "form",
                    ),
                    $component->__parent,
                    array("HIDE_ICONS" => "Y")
                ); ?>
            </div>
        <? endif */?>
    </form>

    <!-- <a class="login" href="/auth/?login=yes" data-fancybox="" data-type="ajax" data-src="/auth/?action=getForm"
       rel="nofollow">Уже зарегистрированы? Войти</a> -->
</div>
