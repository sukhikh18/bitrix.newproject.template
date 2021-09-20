<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>
<form method="POST" enctype="multipart/form-data"
    name="<?= $arResult["WEB_FORM_NAME"] ?>"
    action="<?= POST_FORM_ACTION_URI ?>"
    data-form="<?= $arResult['WEB_FORM_AREA_ID'] ?>"
    novalidate>
    <input type="hidden" name="WEB_FORM_ID" value="<?= $arParams["WEB_FORM_ID"] ?>">
    <input type="hidden" name="web_form_apply" value="Y">
    <?=bitrix_sessid_post()?>
</form>
