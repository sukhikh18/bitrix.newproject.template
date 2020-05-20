<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

if (!defined("ERROR_404")) define("ERROR_404", "Y");
\CHTTP::setStatus("404 Not Found");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");

?>
<div class="container">
    <main id="main" class="404 content" role="main">
        <article class="error-404 not-found">
            <h1><?$APPLICATION->ShowTitle(false);?></h1>
            <div class="error-content entry-content">
                <p>К сожалению эта страница не найдена или не доступна. Попробуйте зайти позднее или воспользуйтесь главным меню для перехода по основным страницам.</p>
            </div><!-- .entry-content -->
        </article><!-- .error-404 -->
    </main><!-- #main -->
</div><!-- .container -->
<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>