<?php if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arTemplateParameters = array(
    'SHOW_PARENT_NAME' => array(
        'PARENT'  => 'VISUAL',
        'NAME'    => GetMessage('CPT_BCSL_SHOW_PARENT_NAME'),
        'TYPE'    => 'CHECKBOX',
        'DEFAULT' => 'Y'
    ),
);

$arTemplateParameters['HIDE_SECTION_NAME'] = array(
    'PARENT'  => 'VISUAL',
    'NAME'    => GetMessage('CPT_BCSL_HIDE_SECTION_NAME'),
    'TYPE'    => 'CHECKBOX',
    'DEFAULT' => 'N'
);
