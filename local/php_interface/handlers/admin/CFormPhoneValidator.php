<?php

class CFormPhoneValidator
{
    function getDescription()
    {
        return array(
            'NAME' => 'phone_ru', // идентификатор
            'DESCRIPTION' => 'Российский номер телефона', // наименование
            'TYPES' => array('text'), // типы полей
            'SETTINGS' => array(__CLASS__, 'getSettings'), // метод, возвращающий массив настроек
            'CONVERT_TO_DB' => array(__CLASS__, 'toDB'), // метод, конвертирующий массив настроек в строку
            'CONVERT_FROM_DB' => array(__CLASS__, 'fromDB'), // метод, конвертирующий строку настроек в массив
            'HANDLER' => array(__CLASS__, 'doValidate') // валидатор
        );
    }

    function getSettings()
    {
        return array();
    }

    function toDB($arParams)
    {
        return serialize($arParams);
    }

    function fromDB($strParams)
    {
        return unserialize($strParams);
    }

    static function checkPhoneNumber($phoneNumber)
    {
        // Remove spaces and other not needed signs.
        $phoneNumber = preg_replace('/\s|\+|-|\(|\)/','', $phoneNumber);
        // Return true when number length equal.
        return is_numeric($phoneNumber) && strlen($phoneNumber) > 5;
    }

    function doValidate($arParams, $arQuestion, $arAnswers, $arValues)
    {
        global $APPLICATION;

        if( ! static::checkPhoneNumber(current($arValues))) {
            $APPLICATION->ThrowException('Номер телефона введен не верно.');
            return false;
        }

        return true;
    }
}