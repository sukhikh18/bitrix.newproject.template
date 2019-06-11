<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

/**
 * $Locations MyLocations custom class for geolocation
 */
$Locations = MyLocations::get_instance();

$city_id = 0;
if( !empty($_REQUEST['city_id']) )
    $city_id = intval($_REQUEST['city_id']);

$Locations->region_select_html($city_id, !empty($_REQUEST['all']) ? false : true );
