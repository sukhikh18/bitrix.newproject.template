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
$value = isset($_REQUEST['q']) ? htmlspecialcharsEx($_REQUEST['q']) : false;
?>
<div class="search-form">
<form action="<?=$arResult["FORM_ACTION"]?>">
	<?if($arParams["USE_SUGGEST"] === "Y"):?><?$APPLICATION->IncludeComponent(
				"bitrix:search.suggest.input",
				"",
				array(
					"NAME" => "q",
					"VALUE" => $value,
					"INPUT_SIZE" => 15,
					"DROPDOWN_SIZE" => 10,
				),
				$component, array("HIDE_ICONS" => "Y")
	);?><?else:?><input type="text" name="q" value="<?=$value;?>" size="15" maxlength="50" placeholder="Поиск по разделу" /><?endif;?>&nbsp;<input name="s" type="submit" value="<?=GetMessage("BSF_T_SEARCH_BUTTON");?>" />
</form>
</div>