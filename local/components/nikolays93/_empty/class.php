<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;

class CustomBitrixComponent extends CBitrixComponent
{
    /**
     * @var array
     */
    private $errors = array();

    function __construct($component = null)
    {
    }

    private function addError( $message = null )
    {
        if( !$message ) return;
        if( !is_array($this->arResult['ERRORS']) ) $this->arResult['ERRORS'] = array();

        if( $message instanceof \Exception ) {
            $this->arResult['ERRORS'][] = $message->getMessage();
        }
        else {
            $this->arResult['ERRORS'][] = $message;
        }
    }

    private function getErrors()
    {
        return $this->arResult['ERRORS'];
    }

    /**
     * @note Default bitrix method
     */
    function executeComponent($component = null)
    {
        global $APPLICATION;

        parent::__construct($component);

        // Load required modules
        if( !Loader::includeModule('iblock') ) {
            $this->addError('IBlock module required.');
        };

        // Do action ( %sAction() )
        if(!empty($this->request['action']) && ($methodAction = strval($this->request['action']))) {
            if ( is_callable(array($this, $methodAction . "Action")) ) {
                try {
                    call_user_func( array($this, $methodAction . "Action") );
                } catch (\Exception $e) {
                    $this->addError( $e );
                }
            }
        }

        $this->includeComponentTemplate();
    }

    /**
     * @note Default bitrix method
     */
    function onPrepareComponentParams($arParams)
    {
        return $arParams;
    }

    function customAction()
    {
    }
}
