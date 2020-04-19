<?php
$arUrlRewrite=array (
  0 => 
  array (
    'CONDITION' => '#^/auth/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/user/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobileapp/jn.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/news/index.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/shop/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/shop/index.php',
    'SORT' => 100,
  ),
);
