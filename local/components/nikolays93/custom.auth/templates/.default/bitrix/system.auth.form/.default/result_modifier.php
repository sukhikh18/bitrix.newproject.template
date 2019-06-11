<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

global $APPLICATION;

if( !empty($_REQUEST['ajax_action']) && 'auth' == $_REQUEST['ajax_action'] ) {
    $APPLICATION->RestartBuffer();

    header('Content-type: application/json');

    /** @var bool */
    $isError = isset($arResult['ERROR']) && true === $arResult['ERROR'];

    /** @var bool */
    $isErrorMessage = !empty($arResult['ERROR_MESSAGE']) && isset($arResult['ERROR_MESSAGE']['TYPE'])
        && 'ERROR' == $arResult['ERROR_MESSAGE']['TYPE'];

    /** @var array */
    $response = array(
        'STATUS' => 'OK',
    );

    if( $isError || $isErrorMessage )
    {
        $response = array(
            'STATUS' => 'ERROR',
            'MESSAGES' => array(),
        );

        if( $isErrorMessage ) {
            $response['MESSAGES'][] = $arResult['ERROR_MESSAGE']['MESSAGE'];
        }
    }

    echo \Bitrix\Main\Web\Json::encode($response);

    die();
}
