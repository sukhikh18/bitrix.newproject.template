<?php

namespace Local\Handlers;

use Bitrix\Main\Security\Random;
use Bitrix\Main\UserTable;

class User
{
    /**
     * @note REGISTER[LOGIN] required in main.register component.
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
