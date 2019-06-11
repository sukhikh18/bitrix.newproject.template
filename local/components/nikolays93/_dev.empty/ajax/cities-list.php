<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

/**
 * $Locations MyLocations custom class for geolocation
 */
$Locations = MyLocations::get_instance();

$region_id = 0;
if( !empty($_REQUEST['region_id']) )
    $region_id = intval($_REQUEST['region_id']);

$city_id = 0;
if( !empty($_REQUEST['city_id']) )
    $city_id = intval($_REQUEST['city_id']);

$Locations->city_select_html($region_id, $city_id, !empty($_REQUEST['all']) ? false : true);