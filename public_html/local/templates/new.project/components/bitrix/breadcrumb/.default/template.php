<?php
if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
if ( ! defined("BREADCRUMBS_SPACER")) {
    define('BREADCRUMBS_SPACER', ' / ');
}

/**
 * @global CMain $APPLICATION
 */

// global $APPLICATION;

//delayed function must return a string
if (empty($arResult)) {
    return "";
}

$strReturn = '';

if (0 !== preg_match('/<[^>]*class=["\'][^"]*\bfa\b[^"]*["\'][^>]*>/i', BREADCRUMBS_SPACER)) {
    /**
     * we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
     * @todo check this
     */
    $css = $APPLICATION->GetCSSArray();
    if ( ! is_array($css) || ! in_array("/bitrix/css/main/font-awesome.css", $css)) {
        $strReturn .= '<link href="' . CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css") . '" type="text/css" rel="stylesheet" />' . "\n";
    }
}

$strReturn .= '<div class="breadcrumb--list" itemprop="http://schema.org/breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

$itemSize = count($arResult);
for ($index = 0; $index < $itemSize; $index++) {
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
    $arrow = ($index > 0 ? BREADCRUMBS_SPACER : '');

    if ($arResult[$index]["LINK"] <> "" && $index != $itemSize - 1) {
        $strReturn .= '
			<div class="breadcrumb__item" id="bx_breadcrumb_' . $index . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				' . $arrow . '
				<a href="' . $arResult[$index]["LINK"] . '" title="' . $title . '" itemprop="url">
					<span itemprop="name">' . $title . '</span>
				</a>
				<meta itemprop="position" content="' . ($index + 1) . '" />
			</div>';
    } else {
        $strReturn .= '
			<div class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				' . $arrow . '
				<span itemprop="name">' . $title . '</span>
				<meta itemprop="position" content="' . ($index + 1) . '" />
			</div>';
    }
}

$strReturn .= '</div>';

return $strReturn;
