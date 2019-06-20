<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;
use \Bitrix\Main\LoaderException;
use \Bitrix\Main;

if( !defined('BS_PANE_FILE_SUFFIX') ) define('BS_PANE_FILE_SUFFIX', 'pane');

class customEmptyComponent extends CBitrixComponent
{
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
    }

    function onPrepareComponentParams($arParams)
    {
        if( 'iblock' == $arParams['TYPE'] ) {
            try
            {
                if( Loader::includeModule('iblock') ) {
                    throw new LoaderException("Not exists IBlock module");
                }
            }
            catch (LoaderException $exception)
            {
                $this->errors[] = '<p style="color: #f00">' . $exception->getMessage() . '</p>';
            }
        }

        if( !isset($arParams['BLOCKS']) || !is_array($arParams['BLOCKS']) ) $arParams['BLOCKS'] = array();
        $arParams['SHOW'] = intval($arParams['SHOW']);

        return $arParams;
    }

    /**
     * [getFile description]
     * @param  string $id slug filename
     * @return Bitrix\Main\IO\File
     */
    private function getFile($id)
    {
        global $APPLICATION;

        $sRealFilePath = $_SERVER["REAL_FILE_PATH"];

        // if page in SEF mode check real path
        if (strlen($sRealFilePath) > 0)
        {
            $slash_pos = strrpos($sRealFilePath, "/");
            $sFilePath = substr($sRealFilePath, 0, $slash_pos+1);
            $sFileName = substr($sRealFilePath, $slash_pos+1);
            $sFileName = substr($sFileName, 0, strlen($sFileName)-4)."_".$id.".php";
        }
        // otherwise use current
        else
        {
            $sFilePath = $APPLICATION->GetCurDir();
            $sFileName = substr($APPLICATION->GetCurPage(true), 0, strlen($APPLICATION->GetCurPage(true))-4)."_".$id.".php";
            $sFileName = substr($sFileName, strlen($sFilePath));
        }

        return new Main\IO\File(Main\Application::getDocumentRoot() . $sFilePath . $sFileName);
    }

    private function getEditElementLink($bFile, $template = '.empty')
    {
        global $APPLICATION, $USER;

        if( !$APPLICATION->GetShowIncludeAreas() ) return '';

        $sFileName = $bFile->getName();
        $sFilePath = str_replace(Main\Application::getDocumentRoot(), '', $bFile->getDirectoryName()) . '/';

        //need fm_lpa for every .php file, even with no php code inside
        $bPhpFile = (!$GLOBALS["USER"]->CanDoOperation('edit_php') && in_array(GetFileExtension($sFileName), GetScriptFileExt()));

        $bCanEdit = $USER->CanDoFileOperation('fm_edit_existent_file', array(SITE_ID, $sFilePath.$sFileName)) && (!$bPhpFile || $GLOBALS["USER"]->CanDoFileOperation('fm_lpa', array(SITE_ID, $sFilePath.$sFileName)));
        $bCanAdd = $USER->CanDoFileOperation('fm_create_new_file', array(SITE_ID, $sFilePath.$sFileName)) && (!$bPhpFile || $GLOBALS["USER"]->CanDoFileOperation('fm_lpa', array(SITE_ID, $sFilePath.$sFileName)));

        $editURL = '';
        $edit = '/bitrix/admin/public_file_edit.php?';

        $arGetString = array(
            'from=bx.bootstrap',
            'lang='       . LANGUAGE_ID,
            'site='       . SITE_ID,
            'template='   . urlencode($template),
            "path="       . urlencode($sFilePath . $sFileName),
            'back_url='   . urlencode($_SERVER['REQUEST_URI']),
            'templateID=' . urlencode(SITE_TEMPLATE_ID),
        );

        if( $bCanAdd && !$bFile->isExists() ) {
            $arGetString[] = 'new=Y';

            $editURL = $edit . implode('&', $arGetString);
        }

        if( $bCanEdit && $bFile->isExists() ) {
            $editURL = $edit . implode('&', $arGetString);
        }

        return $editURL;
    }

    function executeComponent()
    {
        global $APPLICATION;

        $areas = array();
        $this->arResult['BLOCKS'] = array();

        if( 'file' == $this->arParams['TYPE'] ) {
            foreach ($this->arParams['BLOCKS'] as $i => $blockName)
            {
                if( empty($blockName) ) continue;
                $i++;

                $id = BS_PANE_FILE_SUFFIX . $i;
                $bFile = $this->getFile($id);

                $content = '';
                if( $bFile->isExists() ) {
                    ob_start();
                    include $bFile->getPath();
                    $content = ob_get_clean();
                }

                $this->arResult['BLOCKS'][] = array(
                    'ID'   => $id,
                    'NAME' => $blockName,
                    'CONTENT' => $content,
                    'EXPANDED' => $this->arParams['SHOW'] == $i ? 'true' : 'false',
                    'CLASS' => $this->arParams['SHOW'] == $i ? 'multi-collapse collapse show' : 'multi-collapse collapse',
                    'EDIT_LINK' => $this->getEditElementLink($bFile),
                );
            }
        }
        else {
            $args = array(
                'select' => array('ID', 'CODE', 'NAME', 'PREVIEW_TEXT', 'PREVIEW_TEXT_TYPE'),
                'filter' => array(
                    '=IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
                    '=ACTIVE' => 'Y',
                )
            );

            if( !empty($this->arParams['IBLOCK_SECTION']) ) {
                $args['filter']['=IBLOCK_SECTION_ID'] = $this->arParams['IBLOCK_SECTION'];
            }

            $iblockElements = Bitrix\Iblock\ElementTable::getList( $args )->FetchAll();

            foreach ($iblockElements as $i => $iblockElement)
            {
                $this->arResult['BLOCKS'][] = array(
                    'ID'   => $iblockElement['ID'],
                    'NAME' => $iblockElement['NAME'],
                    'CONTENT' => 'text' === $iblockElement['PREVIEW_TEXT_TYPE'] ?
                        txtToHTML($iblockElement['PREVIEW_TEXT']) : $iblockElement['PREVIEW_TEXT'],
                    'EXPANDED' => $this->arParams['SHOW'] == $i ? 'true' : 'false',
                    'CLASS' => $this->arParams['SHOW'] == $i ? 'multi-collapse collapse show' : 'multi-collapse collapse',
                    'EDIT_LINK' => '#',
                );
            }
        }

        // $this->arResult['errors'] = $this->errors;
        $this->includeComponentTemplate();
        $this->AddIncludeAreaIcons($areas);
    }
}