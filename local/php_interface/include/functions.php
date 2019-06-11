<?php

if( !function_exists('is_front_page') ) {
    function is_front_page() {
        global $APPLICATION;

        return '/' === $APPLICATION->GetCurDir();
    }
}

if( !function_exists('is_catalog') ) {
    function is_catalog() {
        global $APPLICATION;

        return '/catalog/' === $APPLICATION->GetCurDir();
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
     * @param  Str/Int $columns количество элементов в строке
     * @var Константа определенная в constants.php.
     *      Определяет возможность исползования адаптивной верстки
     * @return String
     */
    function get_column_class( $columns = 0, $less = false, $responsive = null ) {
        if( null === $responsive )
            $responsive = (defined( 'TPL_RESPONSIVE' ) && TPL_RESPONSIVE);

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
            $cl = 'col-' . str_replace('.', '-', strval($columns / 12));
        }

        return $cl;
    }
}

if( !function_exists('bx_check_invalid_utf8') ) {
    function bx_check_invalid_utf8( $string, $strip = false ) {
        $string = (string) $string;

        if ( 0 === strlen( $string ) ) {
            return '';
        }

        $is_utf8 = false;
        if ( ! isset( $is_utf8 ) ) {
            $is_utf8 = in_array( LANG_CHARSET, array( 'utf8', 'utf-8', 'UTF8', 'UTF-8' ) );
        }
        if ( ! $is_utf8 ) {
            return $string;
        }

        // Check for support for utf8 in the installed PCRE library once and store the result
        $utf8_pcre = @preg_match( '/^./u', 'a' );

        // We can't demand utf8 in the PCRE installation, so just return the string in those cases
        if ( !$utf8_pcre ) {
            return $string;
        }

        // preg_match fails when it encounters invalid UTF8 in $string
        if ( 1 === @preg_match( '/^./us', $string ) ) {
            return $string;
        }

        // Attempt to strip the bad chars if requested (not recommended)
        if ( $strip && function_exists( 'iconv' ) ) {
            return iconv( 'utf-8', 'utf-8', $string );
        }

        return '';
    }
}

if( !function_exists('find_Section') ) {
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
            $sFileName = "index_".$suffix.".php";
        }
        else //if("sect" == $type)
        {
            $sFileName = $type."_".$suffix.".php";
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

if( !function_exists('sectionExist') ) {
    function sectionExists( $name = null ) {
        $filename = find_section($name);
        if( $filename && filesize($_SERVER['DOCUMENT_ROOT'].$filename) > 72 )
            return $filename;

        return false;
    }
}

if( !function_exists('esc_attr') ) {
    /**
     * @cloned from Worpdress
     */
    function esc_attr( $text ) {
        $safe_text = bx_check_invalid_utf8( $text );
        $safe_text = htmlspecialcharsEx( $safe_text );

        return $safe_text;
    }
}

if( ! function_exists('bx_parse_args') ) {
    /**
     * Аналог WordPress функции @see wp_parse_args()
     * @link https://codex.wordpress.org/Function_Reference/wp_parse_args
     *
     * Добавлено $clear - Использовать ключи только из defaults
     */
    function bx_parse_args( $args, $defaults = array(), $clear = false ) {
        if ( is_object( $args ) ) $r = get_object_vars( $args );
        elseif ( is_array( $args ) ) $r =& $args;

        if ( is_array( $defaults ) ) {
            if( $clear ) {
                foreach ($r as $r_key => $r_val) {
                    if(isset( $defaults[ $r_key ] ))
                        $res[ $r_key ] = $r_val;
                }

                $r = $res;
            }

            $r = array_merge( $defaults, $r );
        }

        return $r;
    }
}

if( !function_exists('getTermsListByID') ) {
    /**
     * Обертка функции GetList для получения секций инфоблока по ID
     * @link https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblockelement/getlist.php
     * @param  Mixed $iblock_id ИД Инфоблока
     * @param  array  $arFilter  @see CIBlockSection::GetList
     * @param  array  $arOrder   @see CIBlockSection::GetList
     * @param  array  $arSelect  @see CIBlockSection::GetList
     * @return array for fetch @see CIBlockSection::GetList()->GetNext()
     */
    function getTermsListByID( $iblock_id = null, $arFilter = array(), $arOrder = array(), $arSelect = array() ) {
        $arFilter = (array) bx_parse_args($arFilter, array(
            'ACTIVE' => 'Y',
            'GLOBAL_ACTIVE' => 'Y',
        ) );

        $arFilter['IBLOCK_ID'] = $iblock_id;

        $arOrder = (array) bx_parse_args($arOrder, array(
            'DEPTH_LEVEL' => 'ASC',
            'SORT' => 'ASC',
        ) );

        $arSelect = array_merge( (array) $arSelect,
            array('IBLOCK_ID','ID','NAME','DEPTH_LEVEL','IBLOCK_SECTION_ID', 'SECTION_PAGE_URL'));

        return CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);
    }
}

if( !function_exists('get_terms_hierarchical') ) {
    /**
     * Получение секций в удобный (иерархичный) массив данных
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

        /**
         * $rsSections = CIBlockSection::GetList()
         */
        $rsSections = getTermsListByID( $iblock_id, $arFilter, $arOrder, $arSelect );

        while($arSection = $rsSections->GetNext()) {
            $sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']] = $arSection;
            $sectionLinc[$arSection['ID']] = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
        }

        unset($sectionLinc);
        return (array) $arResult['ROOT']['CHILD'];
    }
}

if( !function_exists('recursiveTermsUList') ) {
    /**
     * Рекурсивно получить ненумерованный(UL) список секций
     * @param Array  $arSections  Масив обработанный по принципу @see get_terms_hierarchical
     * @param Array   $params     Список параметров
     * @param object  $tpl        Экземпляр шаблона компанента CBitrixComponentTemplate
     *                            В случае, если нужно установить сссылки на редактирование и удаление
     */
    function recursiveTermsUList( $arSections, Array $params, $tpl = false ) {
        if( empty($arSections) || !is_array($arSections) )
            return false;

        $params = bx_parse_args( $params, array(
            'level' => 0,
            'list_class' => 'unstyled',
            'item_class' => 'item',
            'link_class' => 'item__link',
            'count_elements' => false,
        ) );
        $params['level'] = 1;

        printf('<ul class="list-%s%s">',
            $params['list_class'],
            (1 > $params['level']) ? ' sub-list level-' . $params['level'] : '');

        foreach ($arSections as $arSection) {
            if( $tpl ) {
                $tpl->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'],
                    CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
                $tpl->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'],
                    CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"),
                    array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));

                printf('<li class="%s" id="%s">', $params['item_class'], $tpl->GetEditAreaId($arSection['ID']) );
            }
            else {
                printf('<li class="%s">', $params['item_class']);
            }

            printf('<a class="%s" href="%s">%s</a>%s',
                $params['link_class'],
                $arSection['SECTION_PAGE_URL'],
                $arSection['NAME'],
                $params["count_elements"] ?
                    sprintf('<small>(%d)</small>', $arSection['ELEMENT_CNT']) : ''
            );

            if( isset($arSection['CHILD']) && is_array($arSection['CHILD']) )
                recursiveTermsUList($arSection['CHILD'], $params);

            echo "</li>";
        }
        printf('</ul><!-- .list-%s -->', $params['list_class']);
    }
}
