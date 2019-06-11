<?php
if( defined('TPL_RESPONSIVE') && TPL_RESPONSIVE ) {
    if( in_array($arParams['SLICK_slidesToShow'], [3,4])) {
        $arParams['SLICK_responsive'] = array(
            (object) array(
                'breakpoint' => 1200,
                'settings' => (object) array(
                    'slidesToShow' => 3,
                )
            ),
            (object) array(
                'breakpoint' => 992,
                'settings' => (object) array(
                    'slidesToShow' => 2,
                )
            ),
            (object) array(
                'breakpoint' => 768,
                'settings' => (object) array(
                    'slidesToShow' => 1,
                )
            ),
        );
    }
}
