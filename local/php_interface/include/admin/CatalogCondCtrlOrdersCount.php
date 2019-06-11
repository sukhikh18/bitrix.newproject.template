<?php

\Bitrix\Main\Loader::includeModule('catalog');

// class CatalogCondCtrlUserProps extends \CCatalogCondCtrlComplex
// {
//     /**
//      * @return string|array
//      */
//     public static function GetControlID()
//     {
//         return array('CondUser', 'CondUserDestinationStore');
//     }

//     public static function GetControlShow($arParams)
//     {
//         $arControls = static::GetControls();
//         $arResult = array(
//             'controlgroup' => true,
//             'group' =>  false,
//             'label' => 'Поля Пользователя',
//             'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
//             'children' => array()
//         );

//         foreach ($arControls as &$arOneControl)
//         {
//             $arResult['children'][] = array(
//                 'controlId' => $arOneControl['ID'],
//                 'group' => false,
//                 'label' => $arOneControl['LABEL'],
//                 'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
//                 'control' => array(
//                     array(
//                         'id' => 'prefix',
//                         'type' => 'prefix',
//                         'text' => $arOneControl['PREFIX']
//                     ),
//                     static::GetLogicAtom($arOneControl['LOGIC']),
//                     static::GetValueAtom($arOneControl['JS_VALUE'])
//                 )
//             );
//         }
//         if (isset($arOneControl))
//             unset($arOneControl);

//         return $arResult;
//     }

//     /**
//      * @param bool|string $strControlID
//      * @return bool|array
//      */
//     public static function GetControls($strControlID = false)
//     {
//         $arControlList = array(
//             'CondUser' => array(
//                 'ID' => 'CondUser',
//                 'FIELD' => 'ID',
//                 'FIELD_TYPE' => 'int',
//                 'LABEL' => 'ID Пользователя',
//                 'PREFIX' => 'поле ID Пользователя',
//                 'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
//                 'JS_VALUE' => array(
//                     'type' => 'input'
//                 ),
//                 'PHP_VALUE' => ''
//             ),
//             'CondUserDestinationStore' => array(
//                 'ID' => 'CondUserDestinationStore',
//                 'FIELD' => 'UF_USER_FIELD',
//                 'FIELD_TYPE' => 'string',
//                 'LABEL' => 'UF_USER_FIELD Пользователя',
//                 'PREFIX' => 'поле UF_USER_FIELD Пользователя',
//                 'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
//                 'JS_VALUE' => array(
//                     'type' => 'input'
//                 ),
//                 'PHP_VALUE' => ''
//             ),
//         );

//         foreach ($arControlList as &$control)
//         {
//             if (!isset($control['PARENT']))
//                 $control['PARENT'] = true;

//             $control['EXIST_HANDLER'] = 'Y';

//             $control['MODULE_ID'] = 'mymodule';

//             $control['MULTIPLE'] = 'N';
//             $control['GROUP'] = 'N';
//         }
//         unset($control);

//         if ($strControlID === false)
//         {
//             return $arControlList;
//         }
//         elseif (isset($arControlList[$strControlID]))
//         {
//             return $arControlList[$strControlID];
//         }
//         else
//         {
//             return false;
//         }
//     }

//     public static function checkUserField($strUserField, $strCond, $strValue)
//     {
//         global $USER;
//         $arUser = $USER->GetByID($USER->GetID())->Fetch();

//         $field = $arUser[$strUserField];

//         return str_replace(array('#FIELD#', '#VALUE#'), array($field, $strValue), $strCond);
//     }
// }

/**
 * Добавляем условие для "Скидки на товар"
 */
// AddEventHandler("catalog", "OnCondCatControlBuildList", Array("CatalogCondCtrlUserProps", "GetControlDescr"));


/**
 * Добавляет возможность устанавливать условия на колличество совершеных заказов (к пр. скидка 5% со второго заказа)
 */

// \Bitrix\Main\Loader::includeModule('sale');

// class SaleCondCtrlAdvance extends \CCatalogCondCtrlComplex
// {
//     public static function GetControlID()
//     {
//         return array('CondUserOrdersCount');
//     }

//     public static function GetControlShow($arParams)
//     {
//         $arControls = static::GetControls();
//         $arResult = array(
//             'controlgroup' => true,
//             'group' =>  false,
//             'label' => 'Дополнительно',
//             'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
//             'children' => array()
//         );

//         foreach ($arControls as $arOneControl)
//         {
//             $arResult['children'][] = array(
//                 'controlId' => $arOneControl['ID'],
//                 'group' => false,
//                 'label' => $arOneControl['LABEL'],
//                 'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
//                 'control' => array(
//                     array(
//                         'id' => 'prefix',
//                         'type' => 'prefix',
//                         'text' => $arOneControl['PREFIX']
//                     ),
//                     static::GetLogicAtom($arOneControl['LOGIC']),
//                     static::GetValueAtom($arOneControl['JS_VALUE'])
//                 )
//             );
//         }
//         unset($arOneControl);

//         return $arResult;
//     }

//     /**
//      * @param bool|string $strControlID
//      * @return bool|array
//      */
//     public static function GetControls($strControlID = false)
//     {
//         $arControlList = array(
//             'CondUserOrdersCount' => array(
//                 'ID' => 'CondUserOrdersCount',
//                 'FIELD' => 'ID', // OrdersCount
//                 'FIELD_TYPE' => 'int',
//                 'LABEL' => 'Количество выполненых заказов пользователя',
//                 'PREFIX' => 'Количество заказов',
//                 'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_GR, BT_COND_LOGIC_LS, BT_COND_LOGIC_EGR, BT_COND_LOGIC_ELS)),
//                 'JS_VALUE' => array(
//                     'type' => 'input'
//                 ),
//                 'PHP_VALUE' => ''
//             ),
//         );

//         foreach ($arControlList as &$control)
//         {
//             if (!isset($control['PARENT']))
//                 $control['PARENT'] = true;

//             $control['EXIST_HANDLER'] = 'Y';

//             $control['MODULE_ID'] = 'sale';

//             $control['MULTIPLE'] = 'N';
//             $control['GROUP'] = 'N';
//         }
//         unset($control);

//         if ($strControlID === false)
//         {
//             return $arControlList;
//         }
//         elseif (isset($arControlList[$strControlID]))
//         {
//             return $arControlList[$strControlID];
//         }
//         else
//         {
//             return false;
//         }
//     }

//     public static function Generate($arOneCondition, $arParams, $arControl, $arSubs = false)
//     {
//         $strResult = false;

//         if (is_string($arControl))
//         {
//             $arControl = static::GetControls($arControl);
//         }
//         $boolError = !is_array($arControl);

//         $arValues = static::Check($arOneCondition, $arOneCondition, $arControl, false);
//         $arLogic = static::SearchLogic($arValues['logic'], $arControl['LOGIC']);

//         if (!$boolError)
//         {
//             $strResult = "\\SaleCondCtrlAdvance::checkUserField('{$arControl['FIELD']}', '{$arLogic['OP'][$arControl['MULTIPLE']]}', '{$arValues['value']}')";
//         }

//         return $strResult;
//     }

//     public static function checkUserField($strUserField, $strCond, $strValue)
//     {
//         global $USER;

//         $arUser = $USER->GetByID($USER->GetID())->Fetch();

//         $field = $arUser[ $strUserField ];

//         if( eval( 'return ' . str_replace(array('#FIELD#', '#VALUE#'), array($field, $strValue), $strCond). ';' ) ) {
//             return true;
//         }

//         return false;
//     }
// }

// /**
//  * Добавляем условие для "Правила работы с корзиной"
//  */
// AddEventHandler("sale", "OnCondSaleControlBuildList", Array("SaleCondCtrlAdvance", "GetControlDescr"));