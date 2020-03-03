<?php

if( !function_exists('is_front_page') ) {
    function is_front_page() {
        global $APPLICATION;

        $curDir = $APPLICATION->GetCurDir();
        list($request) = explode('?', $_SERVER['REQUEST_URI']);
        $onRequest = empty($request) || in_array($request, array($curDir, '/index.php'));

        return $onRequest && '/' === $curDir;
    }
}

if( !function_exists('is_catalog') ) {
    function is_catalog() {
        global $APPLICATION;

        return PATH_TO_CATALOG === $APPLICATION->GetCurDir();
    }
}

if ( ! function_exists( 'is_local' ) ) {
    /**
     * It's development server
     */
    function is_local() {
        return in_array( $_SERVER['SERVER_ADDR'],
            array( '127.0.0.1', defined( 'DEVELOPMENT_ID' ) ? DEVELOPMENT_IP : '' ) );
    }
}

if( !function_exists('body_class') ) {
    function body_class()
    {
        global $APPLICATION;

        /**
         * @todo
         * $APPLICATION->AddBufferContent('ShowBodyClass');
         */

        echo 'class="';
        $APPLICATION->ShowProperty('body-class');
        echo '"';
    }
}

if( !function_exists('get_column_class') ) {
    /**
     * Получение класса элемента в bootstrap 4 сетке по количеству элементов в строке
     *
     * @param  string|int $columns columns count.
     * @param  bool $responsive use responsive classes.
     * @param  bool wide on small devices.
     *
     * @return string bootstrap class for attribute use.
     */
    function get_column_class( $columns = 0, $responsive = true, $less = true ) {
        if( $responsive ) {
            switch ( strval($columns) ) {
                case '1':   $cl = 'col-12'; break;
                case '2':   $cl = 'col-12 col-lg-6'; break;
                case '3':   $cl = 'col-12 col-md-6 col-lg-4'; break;

                case '5':   $cl = 'col-6 col-sm-6 col-md-2-4'; break;
                case '6':   $cl = 'col-6 col-md-4 col-lg-3 col-xl-2'; break;
                case '12':  $cl = 'col-1'; break; // !@#??

                case '3-9': $cl = 'col-12 col-sm-4 col-md-3'; break;
                case '9-3': $cl = 'col-12 col-sm-8 col-md-9'; break;

                case '4-8': $cl = 'col-12 col-sm-4'; break;
                case '8-4': $cl = 'col-12 col-sm-8'; break;

                case '4':
                default: $cl = 'col-6 col-sm-6 col-md-4 col-lg-3'; break;
            }

            if( $less ) { // && is_int($columns) && $columns > 3
                $cl = str_replace('col-6', 'col-12', $cl);
            }
        }
        else {
            $cl = 'col-' . str_replace('.', '-', strval(12 / $columns));
        }

        return $cl;
    }
}

if( !function_exists('find_section') ) {
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

        if( "page" == $type ) {
            $sFileName = "index_$suffix.php";
        }
        else //if("sect" == $type)
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

if( !function_exists('section_exist') ) {
    function section_exist( $name = null ) {
        $filename = find_section($name);
        if( $filename && filesize($_SERVER['DOCUMENT_ROOT'].$filename) > 72 )
            return $filename;

        return false;
    }
}

if( !function_exists('get_terms_hierarchical') ) {
    /**
     * Получение секций в удобный (иерархичный) массив данных
     *
     * @param  Mixed  $iblock_id ИД информационного блока. Передается в переменную $arFilter[IBLOCK_ID].
     *                           При использовании инфоблоков 1.0 можно передать массив
     * @param  Array  $arFilter  Остальные параметры переменной $arFilter для CIBlockSection::GetList
     * @param  Array  $arOrder   Параметры сортировки элементов
     * @param  Array  $arSelect  Параметры выборки компанентов
     * @return Array
     */
    function get_terms_hierarchical( $iblock_id = null, $arFilter = array(), $arOrder = array(), $arSelect = array() ) {
        $sectionLinc = array();
        $arResult['ROOT'] = array();
        $sectionLinc[0] = &$arResult['ROOT'];

        $arFilter['IBLOCK_ID'] = $iblock_id;
        $arFilter = array_merge(array(
            'ACTIVE' => 'Y',
            'GLOBAL_ACTIVE' => 'Y',
        ), $arFilter);

        $arOrder = array_merge(array(
            'DEPTH_LEVEL' => 'ASC',
            'SORT' => 'ASC',
        ), $arOrder);

        $arSelect = array_merge( (array) $arSelect,
            array('IBLOCK_ID','ID','NAME','DEPTH_LEVEL','IBLOCK_SECTION_ID', 'SECTION_PAGE_URL'));

        $rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);

        while($arSection = $rsSections->GetNext()) {
            $sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']] = $arSection;
            $sectionLinc[$arSection['ID']] = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
        }

        unset($sectionLinc);
        return (array) $arResult['ROOT']['CHILD'];
    }
}
