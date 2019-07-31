<? if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<? if ( ! empty($arResult)): ?>
<ul class="navbar-nav mr-auto">
    <?
    $previousLevel = 0;
    foreach ($arResult

    as $arItem):
    $itemClass = 'nav-item';
    $linkClass = 'nav-link';

    if ($arItem["SELECTED"]) {
        $itemClass .= ' active';
    }

    if ("D" > $arItem["PERMISSION"]) {
        $arItem["LINK"] = '#';
        $itemClass      .= ' denied';
        $linkClass      .= ' disabled';
    }

    if ($arItem["IS_PARENT"]) {
        $itemClass .= ' dropdown';
        $linkClass .= ' dropdown-toggle';
    }

    if (1 < $arItem["DEPTH_LEVEL"]) {
        $itemClass .= ' dropdown-item';
    }

    if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) {
        echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
    }
    ?>
    <? if ($arItem["IS_PARENT"]): ?>
    <li class="<?= $itemClass; ?>">
        <a href="<?= $arItem["LINK"] ?>" class="<?= $linkClass; ?>" role="button"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $arItem["TEXT"] ?></a>
        <ul class="dropdown-menu">
            <? else: ?>
                <li class="<?= $itemClass; ?>">
                    <a href="<?= $arItem["LINK"] ?>" class="<?= $linkClass; ?>"<? if ("D" > $arItem["PERMISSION"]) {
                        echo ' title="' . GetMessage("MENU_ITEM_ACCESS_DENIED") . '"';
                    } ?>><?= $arItem["TEXT"] ?></a>
                </li>
            <? endif ?>
            <? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>
            <? endforeach ?>

            <? if ($previousLevel > 1)://close last item tags?>
                <?= str_repeat("</ul></li>", ($previousLevel - 1)); ?>
            <? endif ?>
        </ul>
        <? endif ?>
