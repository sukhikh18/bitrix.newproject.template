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
		/** @var string [description] */
		$root = Application::getDocumentRoot();
		/** @var $Asset \Bitrix\Main\Page\Asset */
		$Asset = Asset::getInstance();

		$is_compressed = ! defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG === false;
		$min           = $is_compressed ? '.min' : '';

		$currentFolder = '';
		$dirParts      = explode('/', $APPLICATION->GetCurDir());
		if(!empty($dirParts[1])) $currentFolder = '/' . $dirParts[1];
		$currentFolder .= '/assets';

		$scripts = array("$currentFolder/script.js");
		$styles = array("$currentFolder/style.css");

		if($is_compressed) {
			array_unshift($scripts, "$currentFolder/script.min.js");
			array_unshift($styles, "$currentFolder/style.min.css");
		}

		foreach ($scripts as $script) {
			if (file_exists($root . $script)) {
				$Asset->addJs($script);
				break;
			}
		}

		foreach ($styles as $style) {
			if (file_exists($root . $style)) {
				$Asset->addCss($style);
				break;
			}
		}
	}
}
