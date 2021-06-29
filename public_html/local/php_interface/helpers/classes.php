<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ( !function_exists('body_class') ) {
    function body_class()
    {
        /** @var CMain $APPLICATION */
        global $APPLICATION;

        /**
         * @todo
         * $APPLICATION->AddBufferContent('ShowBodyClass');
         */
        echo 'class="';
        $APPLICATION->ShowProperty('body-class');
        echo '"';
    }
}