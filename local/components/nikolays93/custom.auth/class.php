<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;

if( !defined('PATH_TO_REGISTER') )        define('PATH_TO_REGISTER', '/auth/?register=yes');
if( !defined('PATH_TO_FORGOT_PASSWORD') ) define('PATH_TO_FORGOT_PASSWORD', '/auth/?forgot_password=yes');

class customAuthComponent extends CBitrixComponent
{
    static $bConfirmReq = false;

    /** @const array (do not const for php version compatibility) */
    protected $needModules = array();

    /** @var array */
    private $errors = array();

    /** @var array Field for ajax request data */
    private $arResponse = array(
        'STATUS'   => '',
        'MESSAGES' => array(),
        'HTML'     => '',
    );

    private $template = '';

    function includeRequiredModules()
    {
        foreach ($this->needModules as $module) {
            if( !Loader::includeModule( $module ) ) {
                $this->errors[] = "No {$module} module.";
            }
        }
    }

    function __construct($component = null)
    {
        parent::__construct($component);
        $this->includeRequiredModules();
    }

    function onPrepareComponentParams($arParams)
    {
        /**
         * @var $arParams['ACTION'] string
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
         * @var $arParams['IS_AJAX'] boolean
         * If is IS_AJAX param exists, check the true defined
         */
        if ( isset($arParams['IS_AJAX']) && in_array($arParams['IS_AJAX'], array('Y', 'N')) ) {
            $arParams['IS_AJAX'] = $arParams['IS_AJAX'] == 'Y';
        }

        /**
         * Server ajax defined
         */
        // elseif ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 'xmlhttprequest' === strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
        //     $arParams['IS_AJAX'] = true;
        // }

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

    protected function sendResultPostMessage( $arFields )
    {
        if( 'OK' === $this->arResponse['STATUS'] ) {
            /** @var CEvent */
            $event = new CEvent;

            // To send user email with new data
            $event->SendImmediate(static::$bConfirmReq ? "NEW_USER_CONFIRM" : "USER_INFO", SITE_ID, $arFields);

            // To send admin mail about new user
            $event->SendImmediate("NEW_USER", SITE_ID, $arFields);
        }

        /**
         * Attention about fake try register
         */
        else {
        }
    }

    /**
     * @todo
     * @param  [type] &$arFields [description]
     * @return [type]            [description]
     */
    protected function customValidateUserFields( $arFields )
    {
        if( empty($arFields['PERSONAL_PHONE']) ) {
            $this->arResponse['STATUS'] = 'ERROR';
            $this->arResponse['MESSAGES'][] = 'Поле Номер телефона обязательно для заполнения.';
        }
    }

    /**
     * Try insert new user
     * @param  Array  $arFields [description]
     */
    protected function insertUser( $arFields )
    {
        $CUser = new CUser;
        $USER_ID = $CUser->Add($arFields);

        if ( 0 < ($arFields['USER_ID'] = intval($USER_ID)) ) {
            $this->arResponse['STATUS'] = 'OK';
            $this->arResponse['MESSAGES'][] = 'Вы успешно зарегистрированы';

            if( static::$bConfirmReq ) {
                $this->arResponse['MESSAGES'][] = ', на указанный Вами EMail отправлено письмо для потверждения.';
            }

            $arFields["STATUS"] = $arFields["ACTIVE"] == "Y" ? 'Активен' : 'Не активен';
            $arFields["URL_LOGIN"] = urlencode($arFields["LOGIN"]);
        }
        else {
            $this->arResponse['STATUS'] = 'ERROR';

            $errors = explode('<br>', $CUser->LAST_ERROR);
            foreach ($errors as $error) {
                if(!$error) continue;

                $this->arResponse['MESSAGES'][] = $error;
            }
        }
    }

    protected function doRegisterAction()
    {
        define("NO_KEEP_STATISTIC", true);
        define("NOT_CHECK_PERMISSIONS", true);

        global $USER;
        global $DB;

        /** @todo var */
        // $requiredFields = array();

        /** @var bool */
        $useCaptha = false;

        /** @var bool if is the user must be confirm registration at email (from main module settings) */
        static::$bConfirmReq = (COption::GetOptionString("main", "new_user_registration_email_confirmation", "N")) == "Y";

        /** @var array */
        $REGISTER = $_REQUEST['REGISTER'];

        /** @var get user password from request */
        $paswd = !empty($REGISTER['PASSWORD']) ? strip_tags( trim($REGISTER['PASSWORD']) ) : '';

        /** @var array Properties for new user */
        $arFields = Array(
            "LAST_NAME"        => '',
            "EMAIL"            => !empty($REGISTER['EMAIL']) ? strip_tags( trim($REGISTER['EMAIL']) ) : '',
            "LID"              => SITE_ID,
            "ACTIVE"           => static::$bConfirmReq ? "N" : "Y",
            "GROUP_ID"         => array(2),
            "PASSWORD"         => $paswd,
            "CONFIRM_PASSWORD" => $paswd,
            "CHECKWORD"        => md5(CMain::GetServerUniqID().uniqid()),
            "~CHECKWORD_TIME"  => $DB->CurrentTimeFunction(),
            "CONFIRM_CODE"     => static::$bConfirmReq ? randString(8): "",
            "PERSONAL_PHONE"   => !empty($REGISTER['PERSONAL_PHONE']) ? strip_tags( trim($REGISTER['PERSONAL_PHONE']) ) : '',
        );

        list($arFields['NAME']) = explode('@', $arFields['EMAIL']);
        $arFields['LOGIN'] = $arFields['EMAIL'];

        $this->arParams['IS_AJAX'] = true;

        /**
         * @todo check captcha
         * if($APPLICATION->CaptchaCheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_sid"]))
         */
        $this->customValidateUserFields( $arFields );
        $this->insertUser( $arFields );
        $this->sendResultPostMessage( $arFields );
    }

    protected function getPageContent( $pagename = '' )
    {
        global $APPLICATION;

        $ext = explode('.', $pagename);
        $ext = end( $ext );

        if( !in_array($ext, array('html', 'htm', 'php')) ) {
            $pagename .= 'index.php';
        }

        $filename = str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'] . '/' .  $pagename );

        if( file_exists( $filename ) ) {
            $APPLICATION->RestartBuffer();

            define('EXCLUDE_FOOTER', TRUE);
            include $filename;
            die();
        }
        else {
            $this->arResponse['STATUS']   = 'ERROR';
            $this->arResponse['MESSAGES'] = 'К сожалению, на данный момент страница не доступна.';
        }

        return false;
    }

    private function privacyAction()
    {
        $this->getPageContent( $this->arParams['PRIVACY_PAGE'] );
    }

    private function personalAction()
    {
        $this->getPageContent( $this->arParams['PERSONAL_PAGE'] );
    }

    private function getFormAction()
    {
        global $APPLICATION, $USER;

        if( !$USER->isAuthorized() ) $APPLICATION->RestartBuffer();
    }

    function executeComponent()
    {
        global $APPLICATION, $USER;

        if( !empty($this->arParams['ACTION']) && ($this->arParams['IS_AJAX']
            || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ) {
            if ( is_callable(array($this, $this->arParams['ACTION'] . "Action")) ) {
                try {
                    call_user_func( array($this, $this->arParams['ACTION'] . "Action") );
                } catch (\Exception $e) {
                    $this->errors[] = $e->getMessage();
                }
            }
        }

        /**
         * Set browser title
         */
        if( "N" !== $this->arParam['SET_TITLE'] ) {
            if    (!empty( $_REQUEST['forgot_password'] ) && "yes" == $_REQUEST['forgot_password']) {
                $APPLICATION->SetTitle("Запрос пароля на восстановление");
            }
            elseif(!empty( $_REQUEST['change_password'] ) && "yes" == $_REQUEST['change_password']) {
                $APPLICATION->SetTitle("Востановление пароля");
            }
            elseif(!empty( $_REQUEST['register'] ) && "yes" == $_REQUEST['register']) {
                $APPLICATION->SetTitle("Регистрация");
            }
            else {
                $APPLICATION->SetTitle("Авторизация");
            }
        }

        if ($this->arParams['IS_AJAX']) {
            $APPLICATION->RestartBuffer();

            if( !empty( $this->errors ) ) {
                $this->arResponse['STATUS']   = 'ERROR';
                $this->arResponse['MESSAGES'] = $this->errors;
            }

            header('Content-Type: application/json');
            echo \Bitrix\Main\Web\Json::encode($this->arResponse);
            $APPLICATION->FinalActions();
            die();
        }
        else {
            if( !empty( $this->errors ) ) {
                $this->arResult['STATUS']   = 'ERROR';
                $this->arResult['MESSAGES'] = $this->errors;
            }

            if("yes" == $_REQUEST['logout']) {
                $USER->Logout();

                // if (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"]) > 0)
                //     LocalRedirect($backurl);
            }

            if( $USER->isAuthorized() ) {
                // header('HTTP/1.1 301 Moved Permanently');
                // header('Location: //'.$_SERVER['SERVER_NAME'] . PATH_TO_PROFILE);

                echo '<p>Вы зарегистрированы и успешно авторизовались. ';
                echo 'Через некоторое время вы буете перенаправленны на стрианцу профиля</p>';
                echo '<p>';
                echo '  <a href="/">Вернуться на главную страницу</a> ';
                echo '| <a href="'.PATH_TO_PROFILE.'">Просмотреть свой профиль</a> ';
                echo '| <a href="'.PATH_TO_AUTH.'?logout=yes">Выйти</a>';
                echo '</p>';

                if( $USER->IsAdmin() ) {
                    echo '<p><em>Вы авторизированы, поэтому должны быть перенаправленны на страницу '.PATH_TO_PROFILE.', но для удобной настройки страницы администраторы остаются.</em></p>';
                }
                else {
                    echo '<script>setTimeout(function() { window.location.href = "'.PATH_TO_PROFILE.'"; }, 4000);</script>';
                }
            }

            if( ! $this->template ) {
                $templates = array('forgot_password', 'change_password', 'register');
                foreach ($templates as $template) {
                    if( !empty($_GET[ $template ]) && 'yes' === $_REQUEST[ $template ] ) {
                        $this->template = $template;
                    }
                }
            }

            // $this->setTemplateName();
            $this->includeComponentTemplate( $this->template );
            if( 'getForm' == $this->arParams['ACTION'] ) die();
        }
    }
}