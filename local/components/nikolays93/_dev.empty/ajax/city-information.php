<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>

<div class="loc-pane__shipping">
  <h5>Доставка:</h5>

  <?php

  if( !empty( $_REQUEST['city_id'] ) ) {
    $location_id = intval( $_REQUEST['city_id'] );
  }
  else {
    /**
     * $Locations MyLocations custom class for geolocation
     */
    $Locations = MyLocations::get_instance();

    /**
     * Current user location ID
     */
    $location_id = $Locations->getCurrentLocationId();
  }

  $delivery = new MyDeliveries( $location_id );
  $freePoints = $delivery->getFreePoints();
  $deliveries = $delivery->getOtherDeliveries();

  $size = sizeof($freePoints);
  if( $size ) {
    ?>
    - Самовывоз <span>(<?= $size ?>)</span><br>
    <?php
  }
  ?>

  <?php
  foreach ($deliveries as $delivery) {
    echo '
    - ' . $delivery['NAME'] . "<br>";
  }
  ?>
</div>

<div class="loc-pane__payment">
  <h5>Оплата:</h5>

  <?php
  $pays = array(
    'Наличные',
    'Банковская карта',
    'Электронные деньги',
    'Наложенный платеж',
  );

  if( !$size )
    unset($pays[0]);

  foreach ($pays as $pay) {
    echo "- $pay<br>";
  }
  ?>
</div>