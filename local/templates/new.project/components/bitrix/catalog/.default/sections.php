<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

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

$this->setFrameMode(true);

$documentRoot = Main\Application::getDocumentRoot();
$folder = $this->GetFolder();

// $this->addExternalCss("/bitrix/css/main/bootstrap.css");
Conditions::set_location('catalog', true);
Conditions::set_location('shop', true); // as shop front page
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
