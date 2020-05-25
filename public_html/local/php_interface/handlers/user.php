<?php

namespace handlers;

use Bitrix\Main\Security\Random;
use Bitrix\Main\UserTable;

/**
 *
 */
class User
{
    public function beforeAdd()
    {
    }

    public function afterAdd()
    {
        //---------- Подставим пароль в сессию для метода OnSendUserInfoHandler ----------//
        if ($_SESSION['SESS_AUTH']) {
            $_SESSION['SESS_AUTH']['CONFIRM_PASSWORD'] = $arFields['CONFIRM_PASSWORD'];
        }
    }

    public function beforeRegister(&$arFields)
    {
        global $APPLICATION;

        //CSS ANTIBOT
        if ( ! $_REQUEST['order']) {

            if (isset($_REQUEST['ANTIBOT']) && is_array($_REQUEST['ANTIBOT'])) {
                foreach ($_REQUEST['ANTIBOT'] as $k => $v) {
                    if (empty($v)) {
                        unset($_REQUEST['ANTIBOT'][$k]);
                    }
                }
            }

            if ($_REQUEST['ANTIBOT'] || ! isset($_REQUEST['ANTIBOT'])) {

                //Раскомментировать для логирования при необходимости
                //$_REQUEST['DATE'] = date('d-m-Y H:i:s');
                //$tttfile          = dirname(__FILE__) . '/log_OnBeforeUserRegister.log';
                //file_put_contents($tttfile, "<pre>" . print_r($_REQUEST, 1) . "</pre>\n");

                $APPLICATION->ThrowException('Ошибка регистрации');

                return false;
            }
        }
        //\\CSS ANTIBOT
    }

    public function afterRegister(&$arFields)
    {
        if ($USER_ID = intval($arFields['USER_ID'])) {
            $lid = ($arFields['LID'] ? $arFields['LID'] : SITE_ID);

            //---------- Создаем профиль покупателя после регистрации ----------//
            if ($arFields['ACTIVE'] == 'Y' && \Bitrix\Main\Loader::includeModule('sale')) {
                //Тут коды свойств магазина, в них надо подставить соответствующие значения из формы регистрации
                $arSaleProps = array(
                    'LOCATION' => 1,
                    'NAME'     => trim($arFields['NAME']),
                    'EMAIL'    => trim($arFields['EMAIL']),
                );

                $arProfileFields = array(
                    "NAME"           => $arSaleProps['EMAIL'],
                    "USER_ID"        => $USER_ID,
                    "PERSON_TYPE_ID" => 1,
                );

                //Добавит профиль покупателя без свойств
                if ($PROFILE_ID = CSaleOrderUserProps::Add($arProfileFields)) {
                    $dbUserProps = CSaleOrderUserProps::GetList(
                        array("DATE_UPDATE" => "DESC"),
                        array(
                            "ID"      => $PROFILE_ID,
                            "USER_ID" => $USER_ID,
                        ),
                        false,
                        false,
                        array("ID", "PERSON_TYPE_ID", "DATE_UPDATE")
                    );

                    //Добавит свойства в профиль
                    if ($arUserProps = $dbUserProps->GetNext()) {
                        $dbOrderProps = CSaleOrderProps::GetList(
                            array("SORT" => "ASC", "NAME" => "ASC"),
                            array(
                                "PERSON_TYPE_ID" => $arUserProps["PERSON_TYPE_ID"],
                                "USER_PROPS"     => "Y",
                            ),
                            false,
                            false,
                            array("ID", "NAME", "CODE")
                        );
                        while ($arOrderProps = $dbOrderProps->GetNext()) {
                            $curVal = htmlspecialcharsEx($arSaleProps[$arOrderProps["CODE"]]);
                            if (isset($curVal)) {
                                $arPropFields = array(
                                    "USER_PROPS_ID"  => $PROFILE_ID,
                                    "ORDER_PROPS_ID" => $arOrderProps["ID"],
                                    "NAME"           => $arOrderProps["NAME"],
                                    "VALUE"          => $curVal,
                                );
                                CSaleOrderUserPropsValue::Add($arPropFields);
                            }
                        }
                    }
                }
            }

            //---------- Отправим письмо пользователю после регистрации со всеми данными ----------//
            $arUserFields = array(
                "USER_ID"   => $arFields['USER_ID'],
                "STATUS"    => ($arFields["ACTIVE"] == "Y" ? 'Активен' : 'Не активен'),
                "MESSAGE"   => '',
                "LOGIN"     => $arFields["LOGIN"],
                "PASSWORD"  => $arFields["PASSWORD"],
                "URL_LOGIN" => urlencode($arFields["LOGIN"]),
                "CHECKWORD" => $arFields["CHECKWORD"],
                "NAME"      => $arFields["NAME"],
                "LAST_NAME" => $arFields["LAST_NAME"],
                "EMAIL"     => $arFields["EMAIL"],
            );

            if ( ! $_REQUEST['order']) {
                CEvent::SendImmediate('USER_INFO', $lid, $arUserFields, 'N');
            }

            //Если отправить стандартную информацию пользователю, но без пароля,
            //тогда отправку выше CEvent::SendImmediate() надо закомментить, а эту раскомментить
            //CUser::SendUserInfo($USER->GetID(), SITE_ID, 'Вы успешно зарегистрированы.', true);
        }
    }

    public function sendUserInfo(&$arParams)
    {
        //---------- Подставим пароль в поля почтового шаблона ----------//
        $bPassword = ($_REQUEST['USER_PASSWORD'] && $_REQUEST['USER_PASSWORD'] == $_REQUEST['USER_CONFIRM_PASSWORD']);

        if ( ! $bPassword && $_SESSION['SESS_AUTH']['CONFIRM_PASSWORD']) {
            $bPassword                 = true;
            $_REQUEST['USER_PASSWORD'] = $_SESSION['SESS_AUTH']['CONFIRM_PASSWORD'];
        }

        if ($arParams['FIELDS'] && $bPassword) {
            $arParams['FIELDS']['PASSWORD'] = $_REQUEST['USER_PASSWORD'];
        }
    }

    /**
     * @note REGISTER[LOGIN] required in main.register component.
     * You must insert hidden input with random string value.
     * Try \Bitrix\Main\Security\Random::getString(lenght: Int); for example
     */
    public function fetchLoginByEmail(&$arFields)
    {
        // Get first part email.
        list($arFields['LOGIN']) = explode('@', $arFields['EMAIL'], 2);

        // Check unique.
        $userRowsList = UserTable::getList(array(
            'filter' => array('=LOGIN' => $arFields['LOGIN']),
            'limit' => 1,
        ));

        // Add random string when login exists.
        if($userRowsList->getSelectedRowsCount() > 0) {
            $arFields['LOGIN'] .= '_' . Random::getString(4);
        }

        return $arFields;
    }

    function checkEmailField(&$arFields)
    {
        global $APPLICATION;

        $sLogin = trim($arFields["LOGIN"]);

        // not a mail
        if(false === strpos($sLogin, '@')) {
            return $arFields;
        }

        // Need when exlude check email string
        // if( ! $sLogin) {
        //     // Login field is empty.
        //     $APPLICATION->ThrowException('Введите электронный адрес.', "EMAIL_IS_EMPTY");
        //     return $arFields;
        // }

        $userRowsList = UserTable::getList(array(
            'select' => array('LOGIN'),
            'filter' => array(
                '=ACTIVE' => true,
                '=EMAIL' => $sLogin,
            ),
            'limit' => 1,
        ));

        if($arUser = $userRowsList->fetch()) {
            // Try LOGIN selected by EMAIL.
            $arFields = array_merge($arFields, $arUser);
        } else {
            // Show error.
            $APPLICATION->ThrowException('Не верный электронный адрес.', "EMAIL_NOT_EXISTS");
            return $arFields;
        }

        return $arFields;
    }
}
