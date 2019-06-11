<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;

require_once (__DIR__ . '/class.php');

new customAuthAjax();
class customAuthAjax extends customAuthComponent
{
    protected $request;

    public $bShowHTMLErrors = true;

    /** @var array Field for ajax request data */
    private $arResponse = array(
        'STATUS' => 'OK',
        'ERRORS' => array(),
        'HTML' => ''
    );

    function __construct()
    {
        $this->onPrepareAjaxParams();
        $this->includeRequiredModules();

        if( !$this->showErrors() ) {
            $this->execute();
        }
    }

    function showErrors()
    {
        if( !empty($this->errors) ) {
            // $bShowHTMLErrors
            return true;
        }

        return false;
    }

    function onPrepareAjaxParams()
    {
        $this->request = Main\Application::getInstance()->getContext()->getRequest();
        $this->request->addFilter(new Main\Web\PostDecodeFilter);

        $this->action = '';
        if ( !empty($this->request['action']) ) {
            $this->action = strval($this->request['action']);
        }
    }

    function executeAjax()
    {
    }
}
