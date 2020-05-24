<?php

use \Bitrix\Main\Page\Asset;

if ( ! function_exists('enqueue_template_assets')) {
	function enqueue_template_assets() {
		$is_compressed = ! defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG === false;
		$min           = $is_compressed ? '.min' : '';

		/** @var $Asset \Bitrix\Main\Page\Asset */
		$Asset = Asset::getInstance();

		$Asset->addJs(TPL . '/assets/main' . $min . '.js');
		$Asset->addCss(TPL . '/assets/template' . $min . '.css');
	}
}

if( ! function_exists('enqueue_page_assets')) {
	function enqueue_page_assets() {
		/** @var $APPLICATION CMain */
		global $APPLICATION;

		/** @var $Asset \Bitrix\Main\Page\Asset */
		$Asset = Asset::getInstance();

		$is_compressed = ! defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG === false;
		$min           = $is_compressed ? '.min' : '';

		$curDir = '/pages/';
		// Add custom page style
		if( is_front_page() ) {
			$curDir .= 'index';
		} else {
			list(, $current) = explode( '/', $APPLICATION->GetCurDir() );
			$curDir .= $current;
		}

		$scriptPath = "$curDir/script{$min}.js";
		if (file_exists(THEME . $scriptPath)) $Asset->addJs(TPL . $scriptPath);

		$stylePath = "$curDir/style{$min}.css";
		if (file_exists(THEME . $stylePath)) $Asset->addCss(TPL . $stylePath);
	}
}
