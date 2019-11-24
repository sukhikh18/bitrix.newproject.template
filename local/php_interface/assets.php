<?php

use \Bitrix\Main\Page\Asset;

if ( ! function_exists('enqueue_assets')) {
	/**
	 * Import dependences (include css/js vendor files to site)
	 *
	 * @return void
	 */
	function enqueue_assets() {
		$is_compressed = ! defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG === false;
		$min           = $is_compressed ? '.min' : '';

		/** @var $Asset \Bitrix\Main\Page\Asset */
		$Asset = Asset::getInstance();

		// Place favicon.ico in the root directory
		$Asset->addString('<link rel="shortcut icon" href="/favicon.ico" />');
		// $Asset->addString('<link rel="apple-touch-icon" href="/favicon.png" />');
		// $Asset->addString('<link rel="manifest" href="site.webmanifest">');

		// \CJSCore::Init( array('jquery') );
		$Asset->addString(sprintf(
			'<script>window.jQuery || document.write(\'<script src="%s"><\/script>\')</script>',
			str_replace('/', '\/', TPL . '/assets/vendor/jquery/jquery.min.js')
		));

		$Asset->addJs('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js');
		$Asset->addJs('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js');

		/**
		 * Bootstrap framework
		 */
		$Asset->addCss(TPL . '/assets/vendor/bootstrap' . $min . '.css');
		$Asset->addJs(TPL . '/assets/vendor/bootstrap' . $min . '.js');

		/**
		 * Responsive mobile menu with animation
		 */
		$Asset->addCss(TPL . '/assets/vendor/hamburgers' . $min . '.css');

		/**
		 * Slick slider
		 */
		$Asset->addCss(TPL . '/assets/vendor/slick/slick.css');
		$Asset->addJs(TPL . '/assets/vendor/slick/slick' . $min . '.js');

		/**
		 * Fancybox modal
		 */
		$Asset->addCss(TPL . '/assets/vendor/fancybox/jquery.fancybox' . $min . '.css');
		$Asset->addJs(TPL . '/assets/vendor/fancybox/jquery.fancybox' . $min . '.js');

		// Masked input
		// $Asset->addJs('https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.3/cleave.min.js');

		// VK Api
		// $Asset->addJs('https://vk.com/js/api/openapi.js?152');

		// Font Awesome (Icons)
		// $Asset->addCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css');

		// Animate
		// $Asset->addCss(TPL . '/assets/vendor/animate'.$min.'.css');
	}
}

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
