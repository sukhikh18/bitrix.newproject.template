<!-- Список категорий товаров -->
<div class="shop__component-section-list">
    <?$APPLICATION->IncludeComponent(
        "bitrix:menu",
        "hierarchical",
        Array(
            "ALLOW_MULTI_SELECT" => "N",
            "CHILD_MENU_TYPE" => "left",
            "COMPONENT_TEMPLATE" => "hierarchical",
            "DELAY" => "N",
            "LIST_CLASS" => "default",
            "MAX_LEVEL" => "2",
            "MENU_CACHE_GET_VARS" => "",
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "ROOT_MENU_TYPE" => "left",
            "USE_EXT" => "Y"
        )
    );?>
</div>