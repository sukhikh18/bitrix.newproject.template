<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Bitrix\Main;
global $USER;

/**
 * @param  string $param [description]
 * @return bool
 */
$isRequest = function(string $param) {
	/** @var Main\Context [description] */
	$context = Main\Context::getCurrent();
	/** @var Main\Request [description] */
	$request = $context->getRequest();

	return in_array($request->get($param), array('yes', 'Y'), true);
};

?>

<?php if(!$USER->IsAuthorized()): ?>
<div class="row">
	<div class="col-lg-6">
	<?php

	if($isRequest('register')):
		$APPLICATION->SetTitle("Регистрация");
		$APPLICATION->AddChainItem("Регистрация");

		$APPLICATION->IncludeComponent(
			"bitrix:main.register",
			".default",
			Array(
			    "SHOW_FIELDS" => array( // Поля, которые показывать в форме
			        "LOGIN",
			        "NAME",
			        "USER_PROPERTIES",
			        "EMAIL",
			        "PERSONAL_PHONE",
			        "PASSWORD",
			        "CONFIRM_PASSWORD",
			    ),
			    "REQUIRED_FIELDS" => "", // Поля, обязательные для заполнения
			    "AUTH" => "Y",  // Автоматически авторизовать пользователей
			    "USE_BACKURL" => "Y", // Отправлять пользователя по обратной ссылке, если она есть
			    "SUCCESS_PAGE" => "?register=success", // Страница окончания регистрации
			    "SET_TITLE" => "N", // Устанавливать заголовок страницы
			    "USER_PROPERTY" => ["UF_INN", "UF_CITY"], // Показывать доп. свойства
			    "USER_PROPERTY_NAME" => "", // Название блока пользовательских свойств
			)
		);

	elseif($isRequest('forgot_password')):
		$APPLICATION->SetTitle("Восстановление пароля");
		$APPLICATION->AddChainItem("Восстановление пароля");

		$APPLICATION->IncludeComponent(
			"bitrix:system.auth.forgotpasswd",
			".default",
			Array()
		);

	elseif($isRequest('change_password')):
		$APPLICATION->SetTitle("Восстановление пароля");
		$APPLICATION->AddChainItem("Восстановление пароля");

		$APPLICATION->IncludeComponent(
			"bitrix:system.auth.changepasswd",
			".default",
			Array()
		);

	else:
		$APPLICATION->SetTitle("Авторизация");
		$APPLICATION->AddChainItem("Авторизация");

		$APPLICATION->IncludeComponent(
		    "bitrix:system.auth.form",
		    "",
		    Array(
		        "FORGOT_PASSWORD_URL" => $APPLICATION->GetCurPage() . '?forgot_password=yes',
		        "PROFILE_URL" => '/user/',
		        "REGISTER_URL" => $APPLICATION->GetCurPage() . '?register=yes',
		        "SHOW_ERRORS" => "Y",
		    )
		);
	endif;

	?>
	</div>
</div>
<?php else: ?>
<div class="row">
	<div class="col-md-8">
		<?php $APPLICATION->SetTitle("Мои заказы") ?>
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
				"PATH_TO_CATALOG" => '/katalog/',
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"SET_TITLE" => "Y",
				"SHOW_ACCOUNT_NUMBER" => "Y"
			)
		);?>
	</div>
	<div class="col-md-4">
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.profile",
			".default",
			array(
				"CHECK_RIGHTS" => "Y",
				"SEND_INFO" => "N",
				"SET_TITLE" => "N",
				"USER_PROPERTY" => array()
			),
			false
		);?>
	</div>
</div>
<?php endif ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>