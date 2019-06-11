<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $USER;

$APPLICATION->SetTitle("Мои заказы");

?>
<?if(!$USER->IsAuthorized()): ?>
	<?$APPLICATION->IncludeComponent(
	"nikolays93:custom.auth", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"PRIVACY_PAGE" => "",
		"PERSONAL_PAGE" => ""
	),
	false
);?>
<?else:?>
<?$APPLICATION->IncludeComponent("bitrix:sale.personal.order", "", array(
	"SEF_MODE" => "Y",
	"SEF_FOLDER" => "/user/order/",
	"ORDERS_PER_PAGE" => "10",
	"PATH_TO_PAYMENT" => PATH_TO_PAYMENT,
	"PATH_TO_BASKET" => PATH_TO_CART,
	"SET_TITLE" => "Y",
	"SAVE_IN_SESSION" => "N",
	"NAV_TEMPLATE" => "arrows",
	"SEF_URL_TEMPLATES" => array(
		"list" => "index.php",
		"detail" => "detail/#ID#/",
		"cancel" => "cancel/#ID#/",
	),
	"SHOW_ACCOUNT_NUMBER" => "Y",
	"ALLOW_INNER" => "N",
	"ONLY_INNER_FULL" => "N"
	),
	false
);?>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>