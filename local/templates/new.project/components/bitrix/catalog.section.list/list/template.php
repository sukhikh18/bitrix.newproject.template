<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

/** Section: Title */
if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID'])
{
	$this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
	$this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

	printf('<h1 id="%s" class="%s"><a href="%s">%s</a></h1>',
		$this->GetEditAreaId($arResult['SECTION']['ID']),
		$arCurView['TITLE'],
		$arResult['SECTION']['SECTION_PAGE_URL'],
		!empty($arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"])
			? $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
			: $arResult['SECTION']['NAME']
	);
}

/** Section: List */
if( function_exists('recursiveTermsUList') ) {
	recursiveTermsUList( $arResult['SECTIONS'], array(
		'list_class' => $arParams['ROW_CLASS'],
	), $this );
}
