<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="bx-auth">
	<?ShowMessage($arParams["~AUTH_RESULT"]);?>

	<div class="register-form">
		<form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
			<?if (strlen($arResult["BACKURL"]) > 0): ?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			<? endif ?>
			<input type="hidden" name="AUTH_FORM" value="Y">
			<input type="hidden" name="TYPE" value="CHANGE_PWD">
			<input type="hidden" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" class="bx-auth-input" />
			<input type="hidden" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" />

			<?$APPLICATION->IncludeComponent(
				"bitrix:system.auth.form", 
				"errors", 
				array("SHOW_ERRORS" => "Y"),
				$component->__parent
			);?>
			<label>
				<input class="form-control" type="text" name="USER_LOGIN" value="<?=$arResult["LAST_LOGIN"]?>" maxlength="50" /> <!-- placeholder="e-mail" autocomplete="email" -->
			</label>

			<label>
				<input class="form-control" type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" placeholder="Новый пароль" />
			</label>

			<?if($arResult["SECURE_AUTH"]):?>
				<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
				<noscript>
					<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
						<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
					</span>
				</noscript>
				<script type="text/javascript">
					document.getElementById('bx_auth_secure').style.display = 'inline-block';
				</script>
			<?endif?>

			<?if($arResult["USE_CAPTCHA"]):?>
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
				<?echo GetMessage("system_auth_captcha")?>
				<input type="text" name="captcha_word" maxlength="50" value="" />
			<?endif?>

			<input class="btn btn-primary" type="submit" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" />

			<br>
			<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
			<!-- <p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p> -->
		</form>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		var $confirm = $('[name="USER_CONFIRM_PASSWORD"]');
		$('[name="USER_PASSWORD"]').on('keyup', function(event) {
			$confirm.val( $(this).val() );
		});
	});
</script>
