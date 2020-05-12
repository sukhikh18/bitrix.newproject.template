<? if ( ! defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Localization\Loc;

if ( ! $arResult['NavShowAlways']) {
    if ($arResult['NavRecordCount'] == 0 || ($arResult['NavPageCount'] == 1 && $arResult['NavShowAll'] == false)) {
        return;
    }
}

$strNavQueryString     = ($arResult['NavQueryString'] != '' ? $arResult['NavQueryString'] . '&amp;' : '');
$strNavQueryStringFull = ($arResult['NavQueryString'] != '' ? '?' . $arResult['NavQueryString'] : '');

$NavRecordCount = intval($arResult['NavRecordCount']);
if(($to = intval($arResult['NavPageSize']) * intval($arResult['NavPageNomer'])) > $NavRecordCount) $to = $NavRecordCount;
if(($from = $to - intval($arResult['NavPageSize'])) < 1) $from = 1;

ob_start();
?>
    <div class="pagenav">
        <div class="pagenav-summary">
            <div class="pagenav-summary-label"><?= Loc::getMessage('SYSTEM_PAGENAVIGATION_LABEL') ?>&nbsp;</div>
            <div class="page-summary-body">
                <span class="pagenav-summary-diff"><?= $from ?> - <?= $to ?></span>
                <span class="pagenav-summary-full"> из <?= $NavRecordCount ?></span>
            </div>
        </div>

        <div class="pagenav-items">
            <?
            if ($arResult["NavPageNomer"] > 1) { ?>
                <!-- <a class="pagenav-item" href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">Начало</a> -->
                <? if ($arResult["NavPageNomer"] > 2) { ?>
                    <a class="pagenav-item pagenav-item_prev"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"><?= Loc::getMessage('SYSTEM_PAGENAVIGATION_PREV') ?></a>
                <? } else { ?>
                    <a class="pagenav-item pagenav-item_prev"
                       href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= Loc::getMessage('SYSTEM_PAGENAVIGATION_PREV') ?></a>
                <? } ?>
            <? } else { // Если страница первая?>
                <!-- <span class="pagenav-item">Начало</span> -->
                <span class="pagenav-item pagenav-item_prev"><?= Loc::getMessage('SYSTEM_PAGENAVIGATION_PREV') ?></span>
                <?
            } ?>
            <?
            $page = $arResult["nStartPage"] ?>
            <?
            while ($page <= $arResult["nEndPage"]) { ?>
                <?php
                ?>
                <?
                if ($page == $arResult["NavPageNomer"]) { ?>
                    <span class="pagenav-item pagenav-item_num pagenav-item_current"><?= $page ?></span>
                <? } else { ?>
                    <a class="pagenav-item pagenav-item_num"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $page ?>"><?= $page ?></a>
                    <? /*if($page == $arResult["NavPageCount"] - 1):?>
            <a class="pagenav-item pagenav-item_num" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$page+1?>"><?=$page+1?></a>
            <?endif;*/ ?>
                    <?
                } ?>
                <?
                $page++ ?>
                <?
            } ?>
            <?
            if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) { ?>
                <? if ($arResult["nEndPage"] + 1 < $arResult["NavPageCount"]): ?>
                    <span class="pagenav-item pagenav-item_empty">...</span>
                    <a class="pagenav-item"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>"><?= $arResult["NavPageCount"]; ?></a>
                <? endif; ?>
                <a class="pagenav-item pagenav-item_next"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"><?= Loc::getMessage('SYSTEM_PAGENAVIGATION_NEXT') ?></a>
                <!--  -->
            <? } else { // Если страница последняя ?>
                <span class="pagenav-item pagenav-item_next"><?= Loc::getMessage('SYSTEM_PAGENAVIGATION_NEXT') ?></span>
                <!-- <span class="pagenav-item">Конец</span> -->
                <?
            } ?>
        </div>
    </div>
<?php
/*$paging = ob_get_contents();
$paging = preg_replace_callback('/href="([^"]+)"/is', function($matches) {
    $url = $matches[1];
    $newUrl = '';
    if ($arUrl = parse_url($url)) {
        $newUrl .= $arUrl['path'];
        if (substr($newUrl, -1) != '/') {
            $newUrl .= '/';
        }
        $newUrl = preg_replace('#(pagen[\d]+/)#is', '', $newUrl);
        parse_str(htmlspecialcharsback($arUrl['query']), $arQuery);
        foreach ($arQuery as $k => $v) {
            if (in_array($k, array('SECTION_CODE'))) {
                unset($arQuery[$k]);
            } elseif (substr($k, 0, 5)=='PAGEN') {
                // @link https://dev.1c-bitrix.ru/community/webdev/user/11948/blog/7428/
                // $newUrl .= 'pagen'.intval($v).'/';
                $arQuery['page'] = intval($v);
                unset($arQuery[$k]);
            }
        }
        $buildQuery = http_build_query($arQuery, '', '&amp;');
        if (strlen($buildQuery)) {
            $newUrl .= '?'.$buildQuery;
        }
    }
    return 'href="'.$newUrl.'"';
}, $paging);
ob_end_clean();
echo $paging;*/
