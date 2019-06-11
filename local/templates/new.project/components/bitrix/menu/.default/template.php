<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if( !empty( $arResult ) ) {
    $previousLevel = 0;
    printf('<ul class="list-%s menu root">', $arParams["LIST_CLASS"]);

    foreach($arResult as $arItem) {
        $arItem["CLASS"] = 'menu__item';
        $arItem["LINK_TITLE_ATTR"] = '';
        if( "D" > $arItem["PERMISSION"] ) {
            $arItem["LINK"] = '#';
            $arItem["LINK_TITLE_ATTR"] = ' title="' .GetMessage("MENU_ITEM_ACCESS_DENIED"). '"';
            $arItem["CLASS"] .= ' denied';
        }

        if( $arItem["IS_PARENT"] )
            $arItem["CLASS"] .= ' has-child';

        if( $arItem["SELECTED"] )
            $arItem["CLASS"] .= ' active selected';

        if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) {
            echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
        }

        printf('<li class="%s"><a href="%s"%s>%s</a>',
            $arItem["CLASS"],
            $arItem["LINK"],
            $arItem["LINK_TITLE_ATTR"],
            $arItem["TEXT"] );

        if ($arItem["IS_PARENT"])
            printf('<ul class="list-%s menu child">', $arParams["LIST_CLASS"]);
        else
            echo '</li>';

        $previousLevel = $arItem["DEPTH_LEVEL"];
    }

    if ($previousLevel > 1) {
        echo str_repeat("</ul></li>", ($previousLevel-1) ); //close last item tags
    }

    echo '</ul>';
}
?>
