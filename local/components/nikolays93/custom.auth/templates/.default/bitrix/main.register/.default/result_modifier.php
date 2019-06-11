<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

global $APPLICATION, $USER;

$arResult["AUTH_SERVICES"] = false;
$arResult["CURRENT_SERVICE"] = false;

if(!$USER->IsAuthorized() && CModule::IncludeModule("socialservices"))
{
    $oAuthManager = new CSocServAuthManager();
    $arServices = $oAuthManager->GetActiveAuthServices($arResult);

    if(!empty($arServices))
    {
        $arResult["AUTH_SERVICES"] = $arServices;
        if(isset($_REQUEST["auth_service_id"]) && $_REQUEST["auth_service_id"] <> '' && isset($arResult["AUTH_SERVICES"][$_REQUEST["auth_service_id"]]))
        {
            $arResult["CURRENT_SERVICE"] = $_REQUEST["auth_service_id"];
            if(isset($_REQUEST["auth_service_error"]) && $_REQUEST["auth_service_error"] <> '')
            {
                $arResult['ERROR_MESSAGE'] = $oAuthManager->GetError($arResult["CURRENT_SERVICE"], $_REQUEST["auth_service_error"]);
            }
            elseif(!$oAuthManager->Authorize($_REQUEST["auth_service_id"]))
            {
                $ex = $APPLICATION->GetException();
                if ($ex)
                    $arResult['ERROR_MESSAGE'] = $ex->GetString();
            }
        }
    }
}

// $component = $this->getComponent();
// $arParams = $component->applyTemplateModifications();