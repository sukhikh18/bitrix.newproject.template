<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

ShowMessage($arParams["~AUTH_RESULT"]);

?>
<div class="login-form">
	<form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
	<?
	if (strlen($arResult["BACKURL"]) > 0)
	{
	?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<?
	}
	?>
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="SEND_PWD">
		<input type="hidden" name="SENT" value="1">
		<?if(!empty($_REQUEST['SENT']) && '1' == $_REQUEST['SENT']): ?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:system.auth.form", 
				"errors", 
				array("SHOW_ERRORS" => "Y"),
				$component->__parent
			);?>
		<?else:?>
		<p>
			Введите Email указанный при регистрации.
			<?//=GetMessage("AUTH_FORGOT_PASSWORD_1")?>
		</p>
		<?endif;?>

		<label>
			<input class="form-control" type="text" name="USER_EMAIL" maxlength="255"  placeholder="e-mail" autocomplete="email" />
		</label>

		<?if($arResult["USE_CAPTCHA"]):?>
		<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
		<?echo GetMessage("system_auth_captcha")?>
		<input type="text" name="captcha_word" maxlength="50" value="" />
		<?endif?>

		<input class="btn btn-primary" type="submit" name="send_account_info" value="Получить код восстановления" />
	</form>
</div>
<!-- <script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
 -->