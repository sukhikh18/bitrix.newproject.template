<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ( !function_exists('find_section') ) {
    function find_section($suffix = null, $recursive = true, $type = 'sect') {
        global $APPLICATION;

        $type = ("sect" !== $type) ? "page" : "sect"; // bx required sect | page
        $suffix = strlen($suffix) > 0 ? $suffix : "inc";
        $recursive = in_array($recursive, array("N", false)) ? "N" : "Y";

        $io = CBXVirtualIo::GetInstance();
        $realPath = $_SERVER["REAL_FILE_PATH"];

        // if page is in SEF mode - check real path
        if (strlen($realPath) > 0)
        {
            $slash_pos = strrpos($realPath, "/");
            $sFilePath = substr($realPath, 0, $slash_pos+1);
        }
        // otherwise use current
        else
        {
            $sFilePath = $APPLICATION->GetCurDir();
        }

        if ( "page" == $type ) {
            $sFileName = "index_$suffix.php";
        }
        else //if ("sect" == $type)
        {
            $sFileName = "$type_$suffix.php";
        }

        $path = $sFilePath.$sFileName;

        $bFileFound = $io->FileExists($_SERVER['DOCUMENT_ROOT'].$path);

        // if file not found and is set recursive check - start it
        if (!$bFileFound && $recursive == "Y" && $sFilePath != "/")
        {
            $finish = false;

            do
            {
                // back one level
                if (substr($sFilePath, -1) == "/") $sFilePath = substr($sFilePath, 0, -1);
                $slash_pos = strrpos($sFilePath, "/");
                $sFilePath = substr($sFilePath, 0, $slash_pos+1);

                $path = $sFilePath.$sFileName;
                $bFileFound = $io->FileExists($_SERVER['DOCUMENT_ROOT'].$path);

                // if we are on the root - finish
                $finish = $sFilePath == "/";
            }
            while (!$finish && !$bFileFound);
        }

        return $bFileFound ? $path : false;
    }
}

if ( !function_exists('section_exist') ) {
    function section_exist( $name = null ) {
        $filename = find_section($name);
        if ( $filename && filesize($_SERVER['DOCUMENT_ROOT'].$filename) > 72 )
            return $filename;

        return false;
    }
}
