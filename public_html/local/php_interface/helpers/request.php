<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Context;

if ( !function_exists('is_front_page') ) {
    function is_front_page() {
        return '' === Context::getCurrent()->getRequest()->getRequestedPageDirectory();
    }
}

if ( !function_exists('is_catalog') ) {
    function is_catalog() {
        return rtrim(PATH_TO_CATALOG, '/') === Context::getCurrent()->getRequest()->getRequestedPageDirectory();
    }
}