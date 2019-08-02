<?php

namespace local\handlers;

/**
 *
 */
class Page
{
    public function includeFunctions()
    {
        $path = $_SERVER["DOCUMENT_ROOT"] . '/local/templates/' . SITE_TEMPLATE_ID . '/functions.php';
        if (file_exists($path)) {
            include_once $path;
        }
    }

    public function includeModules()
    {
        // Loader::includeModule('local.lib');
    }
}
