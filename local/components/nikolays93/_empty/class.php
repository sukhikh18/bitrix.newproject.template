<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;

class customAuthComponent extends CBitrixComponent
{
    /** @const array (do not const for php version compatibility) */
    protected $needModules = array();

    /** @var array */
    private $errors = array();

    /** @var array Field for ajax request data */
    private $arResponse = array(
        'errors' => array(),
        'html' => ''
    );

    function __construct($component = null)
    {
        parent::__construct($component);

        foreach ($this->needModules as $module) {
            if( !Loader::includeModule( $module ) ) {
                $this->errors[] = "No {$module} module.";
            }
        }
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

        /**
         * If is IS_AJAX param exists, check the true defined
         */
        if ( isset($arParams['IS_AJAX']) && in_array($arParams['IS_AJAX'], array('Y', 'N')) ) {
            $arParams['IS_AJAX'] = $arParams['IS_AJAX'] == 'Y';
        }
        /**
         * Same as param with request
         */
        elseif( isset($this->request['is_ajax']) && in_array($this->request['is_ajax'], array('Y', 'N')) ) {
            $arParams['IS_AJAX'] = $this->request['is_ajax'] == 'Y';
        }
        else {
            $arParams['IS_AJAX'] = false;
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

        if( !empty($this->arParams['ACTION']) ) {
            if ( is_callable(array($this, $this->arParams['ACTION'] . "Action")) ) {
                try {
                    call_user_func( array($this, $this->arParams['ACTION'] . "Action") );
                } catch (\Exception $e) {
                    $this->errors[] = $e->getMessage();
                }
            }
        }

        if ($this->arParams['IS_AJAX']) {
            $APPLICATION->RestartBuffer();
            // if ($this->getTemplateName() != '') {
            //     ob_start();
            //     $this->includeComponentTemplate();
            //     $this->arResponse['html'] = ob_get_contents();
            //     ob_end_clean();
            // }

            $this->arResponse['errors'] = $this->errors;

            header('Content-Type: application/json');
            echo json_encode($this->arResponse);
            $APPLICATION->FinalActions();
            die();
        }
        else {
            $this->arResult['errors'] = $this->errors;

            $this->includeComponentTemplate();
        }
    }
}