<? if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

if(!$arResult['NavShowAlways']) {
    if ($arResult['NavRecordCount'] == 0 || ($arResult['NavPageCount'] == 1 && $arResult['NavShowAll'] == false)) {
        return;
    }
}

$strNavQueryString = ($arResult['NavQueryString'] != '' ? $arResult['NavQueryString'].'&amp;' : '');
$strNavQueryStringFull = ($arResult['NavQueryString'] != '' ? '?'.$arResult['NavQueryString'] : '');
ob_start();
?>
<div class="pagenav">
    <?if ($arResult["NavPageNomer"] > 1) {?>
        <!-- <a class="pagenav__item" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">Начало</a> -->
        <?if ($arResult["NavPageNomer"] > 2) {?>
            <a class="pagenav__item pagenav__prev" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">Предыдущая</a>
        <?} else {?>
            <a class="pagenav__item pagenav__prev" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">Предыдущая</a>
        <?}?>
    <?} else { // Если страница первая?>
        <!-- <span class="pagenav__item">Начало</span> -->
        <span class="pagenav__item pagenav__prev">Предыдущая</span>
    <?}?>
    <?$page = $arResult["nStartPage"]?>
    <?$i = 0;
    while($page <= $arResult["nEndPage"]) {?>
        <?php
        ?>
        <?if ($page == $arResult["NavPageNomer"]) {?>
            <span class="pagenav__item pagenav__item_num pagenav__item_current"><?=$page?></span>
        <?} else {?>
            <a class="pagenav__item pagenav__item_num" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$page?>"><?=$page?></a>
            <?if($page == $arResult["NavPageCount"] - 1):?>
            <a class="pagenav__item pagenav__item_num" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$page+1?>"><?=$page+1?></a>
            <?endif;?>
        <?}?>
        <?$page++?>
    <?}?>
    <?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]) {?>
        <?if( $arResult["nEndPage"] + 1 < $arResult["NavPageCount"] ): ?>
        <span class="pagenav__item pagenav__item_empty">...</span>
        <a class="pagenav__item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"];?></a>
        <?endif;?>
        <a class="pagenav__item pagenav__next" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">Следующая</a>
        <!--  -->
    <?} else { // Если страница последняя ?>
        <span class="pagenav__item pagenav__next">Следующая</span>
        <!-- <span class="pagenav__item">Конец</span> -->
    <?}?>
</div>
<?php
$paging = ob_get_contents();
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
                /**
                 * @link https://dev.1c-bitrix.ru/community/webdev/user/11948/blog/7428/
                 */
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
echo $paging;
