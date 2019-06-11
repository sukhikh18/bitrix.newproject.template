<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $USER;

if (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"])>0) 
    LocalRedirect($backurl);

$APPLICATION->SetTitle("Авторизация");
?>
<?$APPLICATION->IncludeComponent(
	"nikolays93:custom.auth",
	".default",
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"PRIVACY_PAGE" => "/docs/privacy/",
        "PERSONAL_PAGE" => "/docs/personal/",
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>