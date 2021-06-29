<?php

if (!function_exists('getSectionsHierarchical')):
	/**
	 * Получение секций в удобный (иерархичный) массив данных
	 *
	 * @param  Mixed  $iblockId ИД информационного блока. Передается в переменную $arFilter[IBLOCK_ID].
	 *                           При использовании инфоблоков 1.0 можно передать массив
	 * @param  Array  $arFilter  Остальные параметры переменной $arFilter для CIBlockSection::GetList
	 * @param  Array  $arOrder   Параметры сортировки элементов
	 * @param  Array  $arSelect  Параметры выборки компанентов
	 * @return Array
	 */
	function getSectionsHierarchical(int $iblockId, array $arFilter = array(), array $arOrder = array(), array $arSelect = array()) {
		\Bitrix\Main\Loader::includeModule('iblock');

		$rsSections = \Bitrix\Iblock\SectionTable::getList([
			'order' => [
				'DEPTH_LEVEL' => 'ASC',
				'SORT' => 'ASC',
			],
			'filter' => array_merge($arFilter, [
				"IBLOCK_ID" => $iblockId,
				'ACTIVE' => 'Y',
				'GLOBAL_ACTIVE' => 'Y',
			]),
			'select' => array_merge($arSelect, [
				'IBLOCK_ID',
				'IBLOCK_SECTION_ID',
				'ID',
				'CODE',
				'NAME',
				'DEPTH_LEVEL',
				// Присоединить таблицу инфоблоков Iblock\IblockTable и выбрать SECTION_PAGE_URL
				'IBLOCK_SECTION_PAGE_URL' => 'IBLOCK.SECTION_PAGE_URL',
			]),
		]);

		$arResult = ['ROOT' => []];
		$sectionLink = [0 => &$arResult['ROOT']];

		while ($arSection = $rsSections->fetch()) {
			$arSection['SECTION_PAGE_URL'] = \CIBlock::ReplaceDetailUrl(
				$arSection['IBLOCK_SECTION_PAGE_URL'], $arSection, true, 'S');

			$iblockSectId = intval($arSection['IBLOCK_SECTION_ID']);
			$sectId = intval($arSection['ID']);

			$sectionLink[ $iblockSectId ]['CHILD'][ $sectId ] = $arSection;
			$sectionLink[ $sectId ] = &$sectionLink[ $iblockSectId ]['CHILD'][ $sectId ];
		}

		unset($sectionLink);
		return (array) $arResult['ROOT']['CHILD'];
	}
endif;