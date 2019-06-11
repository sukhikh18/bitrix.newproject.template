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
use Bitrix\Main;
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);

Conditions::set_location('catalog', true);

$documentRoot = Main\Application::getDocumentRoot();
$folder = $this->GetFolder();

// Sidebar
$isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y"
	&& isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));

$file = new Main\IO\File( $documentRoot . $folder . "/filter.php" );
if ($file->isExists()) include($file->getPath());
?>
<section class="shop">
	<div class="row">
		<div class="sidebar col-2">
			<? $file = new Main\IO\File( $documentRoot . $folder . "/sidebar.php" );
			if ($file->isExists()) include($file->getPath());?>
		</div>
		<div class="catalog col-10">
			<? $file = new Main\IO\File( $documentRoot . $folder . "/catalog.php" );
			if ($file->isExists()) include($file->getPath());?>
		</div>
	</div>
</section>
