<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;

class emptyComponent extends CBitrixComponent
{
    /** @var array */
    protected $needModules = array( "sale" );

    /** @var array */
    protected $errors = array();

    protected function includeModules()
    {
        $allright = true;
        foreach ($this->needModules as $module) {
            if( !Loader::includeModule( $module ) ) {
                $this->errors[] = sprintf('No <strong>$s</strong> module.', $module);
                $allright = false;
            }
        }

        return $allright;
    }

    function __construct($component = null)
    {
        parent::__construct($component);
        $this->includeModules();
    }

    function onPrepareComponentParams($arParams)
    {
        /**
         * If is ACTION param exists, strval to define
         */
        if ( isset($arParams['ACTION']) && strlen($arParams['ACTION']) > 0 ) {
            $arParams['ACTION'] = strval($arParams['ACTION']);
        }
        elseif ( !empty($this->request['action']) ) {
            $arParams['ACTION'] = strval($this->request['action']);
        }
        else {
            $arParams['ACTION'] = '';
        }

        return $arParams;
    }

    protected function registerAction()
    {
        // global $USER;
    }

    function executeComponent()
    {
        global $APPLICATION;

        // if( !empty($this->arParams['ACTION']) ) {
        //     if ( is_callable(array($this, $this->arParams['ACTION'] . "Action")) ) {
        //         try {
        //             call_user_func( array($this, $this->arParams['ACTION'] . "Action") );
        //         } catch (\Exception $e) {
        //             $this->errors[] = $e->getMessage();
        //         }
        //     }
        // }

        $this->arResult['errors'] = $this->errors;

        $this->includeComponentTemplate();
    }
}