<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $USER;

?>

<?if(!$USER->IsAuthorized()): ?>
<div class="row">
	<div class="col-lg-6">
	<?$APPLICATION->IncludeComponent(
		"seo18:custom.auth",
		"",
		Array(
			"PERSONAL_PAGE" => "",
			"PRIVACY_PAGE" => ""
		)
	);?>
	</div>
</div>

<?else:?>
<?$APPLICATION->SetTitle("Мои заказы");?>
<div class="row">
	<div class="col-md-8">
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.personal.order",
			"",
			Array(
				"ALLOW_INNER" => "N",
				"NAV_TEMPLATE" => "arrows",
				"ONLY_INNER_FULL" => "N",
				"ORDERS_PER_PAGE" => "10",
				"PATH_TO_BASKET" => PATH_TO_CART,
				"PATH_TO_PAYMENT" => PATH_TO_PAYMENT,
				"SAVE_IN_SESSION" => "N",
				"SEF_FOLDER" => "/user/order/",
				"SEF_MODE" => "Y",
				"SEF_URL_TEMPLATES" => array("list"=>"index.php","detail"=>"detail/#ID#/","cancel"=>"cancel/#ID#/",),
				"SET_TITLE" => "Y",
				"SHOW_ACCOUNT_NUMBER" => "Y"
			)
		);?>
	</div>
	<div class="col-md-4">
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.profile",
			"",
			Array(
				"CHECK_RIGHTS" => "Y",
				"SEND_INFO" => "N",
				"SET_TITLE" => "N",
				"USER_PROPERTY" => array()
			)
		);?>
	</div>
</div>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>