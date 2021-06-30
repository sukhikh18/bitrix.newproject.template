<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Context;

if ( !function_exists('isFrontPage') ) {
    function isFrontPage() {
        return '' === Context::getCurrent()->getRequest()->getRequestedPageDirectory();
    }
}

if ( !function_exists('isCatalog') ) {
    function isCatalog() {
        return rtrim(PATH_TO_CATALOG, '/') === Context::getCurrent()->getRequest()->getRequestedPageDirectory();
    }
}