<?php

namespace handlers\admin;

class IBlockVisualEditorComponents
{
    function beforeHTMLEditorScriptRuns()
    {
        // Получаем список компонентов
        \Bitrix\Main\Loader::includeModule('fileman');
        $arComponents = \CHTMLEditor::GetComponents([]);

        /**
         * @todo
         */
        // $allowedItems  = array('bitrix:main.include');
        // $allowedGroups = array('include_area');

        // $allowedComponents = array(
        //     'items'  => array(),
        //     'groups' => array(),
        // );

        // foreach ($arComponents['items'] as $item) {
        //     if (in_array($item['name'], $allowedItems)) {
        //         $allowedComponents['items'][] = $item;
        //     }
        // }

        // foreach ($arComponents['groups'] as $group) {
        //     if (in_array($group['name'], $allowedGroups)) {
        //         $allowedComponents['groups'][] = $group;
        //     }
        // }

        $js_ob = \CUtil::PhpToJSObject($arComponents); // $allowedComponents
        \CComponentParamsManager::Init(); // инициализирует oBXComponentParamsManager
        ?>
        <script>
            BX.ready(function () {
                BX.addCustomEvent('OnEditorInitedBefore', function (toolbar) {

                    this.config.components = <?= $js_ob ?>; <?php // Список компонентов ?>
                    this.showComponents = true; <?php // показ компонентов ?>
                    this.allowPhp = true; <?php // разрешаем PHP код в редакторе ?>

                });
            });
        </script>
        <?
    }

    function endBufferContent(&$buffer)
    {
        $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

        if ($request->getQuery('bxsender') == 'core_window_cdialog') {
            return false;
        }

        $requestedDir = $request->getRequestedPageDirectory();
        $arr_path     = ['/bitrix/', '/local/'];
        foreach ($arr_path as $path) {
            if ($request->isAdminSection() && strripos($requestedDir, $path) !== false) {
                return false;
            }
        }

        $new_string = preg_replace_callback(
            '/<\?(php)?[\s+?\n?\s+]*(\$APPLICATION->IncludeComponent\(.*)\?>/Us', function ($matches) {

            global $APPLICATION;

            ob_start();
            eval($matches[2]);

            return ob_get_clean();
        }, $buffer
        );
        $buffer     = $new_string;
    }
}
