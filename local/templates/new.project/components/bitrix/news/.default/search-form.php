<?

// echo GetMessage("SEARCH_LABEL");
$APPLICATION->IncludeComponent(
    "bitrix:search.form",
    "flat",
    Array(
        "PAGE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["search"]
    ),
    $component
);