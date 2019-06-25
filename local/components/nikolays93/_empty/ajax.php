<?

use \Bitrix\Main;

/** @global \CMain $APPLICATION */
define('STOP_STATISTICS', true);

$siteId = isset($_REQUEST['siteId']) && is_string($_REQUEST['siteId']) ? $_REQUEST['siteId'] : '';
$siteId = substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);
if (!empty($siteId) && is_string($siteId)) {
    define('SITE_ID', $siteId);
}

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

// $request = Main\Application::getInstance()->getContext()->getRequest();
// $request->addFilter(new Main\Web\PostDecodeFilter);

// $signer = new \Bitrix\Main\Security\Sign\Signer;
// try
// {
//     $paramString = $signer->unsign($request->get('parameters'), 'location.form');
// }
// catch (\Bitrix\Main\Security\Sign\BadSignatureException $e)
// {
//     die();
// }

require_once (__DIR__ . '/class.php');

class ajaxEmptyComponent extends emptyComponent
{
    public $bShowHTMLErrors = true;

    /** @var array Field for ajax request data */
    private $arResponse = array(
        'STATUS' => 'OK',
        'ERRORS' => array(),
        'HTML' => ''
    );

    private $action;

    function __construct()
    {
        // $this->needModules[] = 'test';
        if( !$this->includeModules() ) {
            $this->execute();
        }
    }

    function prepare()
    {
        $request = Main\Application::getInstance()->getContext()->getRequest();
        $request->addFilter(new Main\Web\PostDecodeFilter);

        $this->action = '';
        if ( !empty($request['action']) ) {
            $this->action = strval($request['action']);
        }
    }

    function execute()
    {
        /** @global \CMain $APPLICATION */
        global $APPLICATION;

        $this->arResponse['ERRORS'] = $this->errors;

        if( !empty($this->arResponse['ERRORS']) ) {
            $this->arResponse['STATUS'] = 'FAIL';

            if( $this->bShowHTMLErrors ) {
                $htmlErrs = array();
                foreach ($this->arResponse['ERRORS'] as $err) {
                    $htmlErrs[] = sprintf('<p>%s</p>', $err);
                }

                $this->arResponse['ERRORS'] = array();
                $this->arResponse['HTML'] = implode("\r\n", $htmlErrs);
            }
        }

        header('Content-Type: application/json');
        echo Main\Web\Json::encode( $this->arResponse );
        $APPLICATION->FinalActions();
        die();
    }
}

// $component = new CBitrixComponent();
// $component->InitComponent( 'nikolays93:' . basename( __DIR__ ) ); // $parameters['TEMPLATE_NAME']
// $component->InitComponentTemplate($parameters['TEMPLATE_PAGE']);

$ajax = new ajaxEmptyComponent( true );
$ajax->execute();
