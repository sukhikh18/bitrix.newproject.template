<?php

namespace Local\Handlers;

use Bitrix\Main\Loader;
use Bitrix\Main\Mail\Mail as BXMail;
use Bitrix\Sale\Order;
use Bitrix\Main\Event;

class Mail
{
    static function getFromAddress()
    {
        return defined('EMAIL_FROM') && !empty(EMAIL_FROM) ? EMAIL_FROM : 'no-reply@' . $_SERVER['SERVER_NAME'];
    }

    static function getAdminAddress($siteId = false)
    {
        return defined('EMAIL_ADMIN') && !empty(EMAIL_ADMIN) ? EMAIL_ADMIN :
            COption::GetOptionString('main', 'email_from', 'no-reply@' . $_SERVER['SERVER_NAME'], $siteId);
    }

    static function getShopAdminAddress($siteId = false)
    {
        return defined('EMAIL_ADMIN') && !empty(EMAIL_ADMIN) ? EMAIL_ADMIN :
            COption::GetOptionString('sale', 'order_email', 'sale@' . $_SERVER['SERVER_NAME'], $siteId);
    }

    function changeFromAddress(&$arFields, &$arTemplate)
    {
        $arTemplate['EMAIL_FROM'] = static::getFromAddress();
    }

    function adminNotifications(&$arFields, &$arTemplate)
    {
        if(defined('EMAIL_ADMIN') && !empty(EMAIL_ADMIN)) {
            $mainFrom = COption::GetOptionString('main', 'email_from');
            $saleFrom = COption::GetOptionString('sale', 'order_email');

            if(in_array($arTemplate['TO'], array($mainFrom, $saleFrom))) {
                $arTemplate['TO'] = EMAIL_ADMIN;
            }
        }
    }

    function debugMailMessages(&$arFields, &$arTemplate)
    {
        if(defined('DEVELOPER_TESTMAIL') && !empty(DEVELOPER_TESTMAIL)) {
            if($arTemplate['BCC']) $arTemplate['BCC'] .= ',';
            $arTemplate['BCC'] .= DEVELOPER_TESTMAIL;
        }
    }

    function notifyNewOrder(Event $event)
    {
        Loader::includeModule('catalog');
        /** @var Order $order */
        $order = $event->getParameter("ENTITY");
        /** @var bool [description] */
        $isNew = $event->getParameter("IS_NEW");

        if ( ! $isNew) return true;

        $orderId = $order->getId();
        $sideId = $order->getSiteId();
        $orderPrice = $order->getPrice();
        $currency = $order->getCurrency();
        $orderAdminLink = sprintf(
            '%s/bitrix/admin/sale_order_view.php?ID=%d&lang=ru&filter=Y&set_filter=Y',
            'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['SERVER_NAME'],
            $orderId
        );

        /** @var Sale\Basket */
        $basket = Order::load($orderId)->getBasket();
        /** @var array $basketItems <Sale\BasketItem> */
        $basketItems = $basket->getBasketItems();

        $arOrderList = array_map(function($basketItem) {
            /** @var Sale\BasketItem $basketItem */
            return $basketItem->getField('NAME') . ' - ' . $basketItem->getQuantity();
        }, $basketItems);

        $arMessage = array();
        array_push($arMessage, sprintf(
            'На вашем сайте %s новый заказ №%d на сумму %s %s.',
            $_SERVER['SERVER_NAME'],
            $orderId,
            $orderPrice,
            $currency
        ));
        array_push($arMessage, "Состав заказа:\r\n" . implode("\r\n", $arOrderList));
        array_push($arMessage, "=========================\r\nПросмотреть заказ можно по ссылке:\r\n" . $orderAdminLink);

        $arMailParams = array(
            'CHARSET' => SITE_CHARSET,
            'CONTENT_TYPE' => 'text',
            'TO' => static::getShopAdminAddress($sideId),
            'SUBJECT' => 'На сайте новый заказ',
            'BODY' => implode("\r\n\r\n", $arMessage),
            'HEADER' => array(
                'FROM' => static::getFromAddress(),
            ),
        );

        if(BXMail::send($arMailParams)) {
            return true;
        }

        return false;
    }
}
