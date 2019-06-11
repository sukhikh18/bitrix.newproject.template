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

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");

if( empty($arParams['COLUMNS']) ) $arParams['COLUMNS'] = 3;
$columnClass = function_exists('get_column_class') ?
    get_column_class( $arParams['COLUMNS'] ) : 'columns-' . $arParams['COLUMNS'];
$rowClass = !empty($arParams['ROW_CLASS']) ? $arParams['ROW_CLASS'] : 'row';

$boolFirst = true;
echo '
<!-- Nav tabs -->
<ul class="nav nav-tabs" id="'.$arParams['IBLOCK_CODE'].'_tabs" role="tablist">';
foreach ($arResult['SECTIONS'] as $arSection) {
	$link_attrs = array(
		'class' => $boolFirst ? 'nav-link active' : 'nav-link',
		'aria-selected' => $boolFirst ? 'true' : 'false',
		'id'    => 'section_' . $arSection['ID'] . '_tab',
		'aria-controls' => $arSection['ID'],
		'href' => "#section_" . $arSection['ID'],
	);

	echo '<li class="nav-item"><a';
	foreach ($link_attrs as $key => $attr) {
		echo " $key=\"$attr\"";
	}
	echo ' data-toggle="tab" role="tab">' . $arSection['NAME'] . '</a></li>';
	$boolFirst = false;
}
echo "</ul>";

$boolFirst = true;
echo '
<!-- Tab panes -->
<div class="tab-content">';
foreach ($arResult['SECTIONS'] as $arSection) {

	printf('<div class="%1$s" id="section_%2$s" role="tabpanel" aria-labelledby="%2$s-tab">',
		$boolFirst ? 'tab-pane active' : 'tab-pane',
		$arSection['ID']);

	if( isset($arSection['CHILD']) && is_array($arSection['CHILD']) ) {
		printf('<div class="%s">', $rowClass);
		foreach ($arSection['CHILD'] as $arSectionChild) {
			$this->AddEditAction($arSectionChild['ID'], $arSectionChild['EDIT_LINK'], $strSectionEdit);
			$this->AddDeleteAction($arSectionChild['ID'], $arSectionChild['DELETE_LINK'], $strSectionDelete,
				array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));

			printf('<div class="section-item %s mb20" id="%s"><div class="inner">',
				$columnClass,
				$this->GetEditAreaId($arSectionChild['ID'])
			);

			if( "Y" != $arParams["HIDE_PICTURE"] ) {
	            // bitrix method
	            // printf('<a href="%s" class="%s" title="%s" style="background-image:url(\'%s\')"></a>',
	            //     $arSectionChild['SECTION_PAGE_URL'],
	            //     $arSectionChild['PICTURE']['SRC'],
	            //     $arSectionChild['PICTURE']['TITLE']
	            // );
				if( false !== $arSectionChild['PICTURE'] ) {
					printf('<div class="article-element__picture"><a href="%s">%s</a></div>',
						$arSectionChild['SECTION_PAGE_URL'],
						bx_get_image( $arSectionChild["PICTURE"], $args, true )
					);
				}
				else {
					echo '<div class="article-element__picture article-element_empty"></div>';
				}
			}

			if ('Y' != $arParams['HIDE_SECTION_NAME'] && $arSectionChild['NAME']) {
				if( ! $arParams["NAME_TAG"] ) $arParams["NAME_TAG"] = 'h3';

				printf('<%1$s><a href="%2$s">%3$s</a></%1$s>',
					$arParams["NAME_TAG"],
					$arSectionChild['SECTION_PAGE_URL'],
					$arSectionChild['NAME'],
					$arParams["COUNT_ELEMENTS"] ?
					sprintf('<small>(%d)</small>', $arSectionChild['ELEMENT_CNT']) : ''
				);
			}

			echo "</div></div><!-- .section-item -->";
		}
		printf('</div><!-- .%s -->', $rowClass);
	}
	else {
		echo "Нет данных";
	}

	echo '</div>';
	$boolFirst = false;
}
echo '</div>';