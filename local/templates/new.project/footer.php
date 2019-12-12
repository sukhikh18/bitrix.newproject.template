<? if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

?>
    </div><!-- #content -->

    <div class="container">
        <div class="slider row justify-content-between mt-5">
            <div><a href="<?= TPL ?>/img/placeholder.png" data-fancybox="gallery"><img src="<?= TPL ?>/img/placeholder.png" width="150" class="ac"></a></div>
            <div><a href="<?= TPL ?>/img/placeholder.png" data-fancybox="gallery"><img src="<?= TPL ?>/img/placeholder.png" width="150" class="ac"></a></div>
            <div><a href="<?= TPL ?>/img/placeholder.png" data-fancybox="gallery"><img src="<?= TPL ?>/img/placeholder.png" width="150" class="ac"></a></div>
            <div><a href="<?= TPL ?>/img/placeholder.png" data-fancybox="gallery"><img src="<?= TPL ?>/img/placeholder.png" width="150" class="ac"></a></div>
            <div><a href="<?= TPL ?>/img/placeholder.png" data-fancybox="gallery"><img src="<?= TPL ?>/img/placeholder.png" width="150" class="ac"></a></div>
        </div>

        <div class="auth-link mt-2 text-center">
            <a href="/auth/" data-fancybox data-type="ajax" data-src="/local/components/nikolays93/custom.auth/ajax.php">Авторизация</a>
            | <a href="/auth/?register=yes" data-fancybox data-type="ajax"
                 data-src="/local/components/nikolays93/custom.auth/ajax.php?register=yes">Регистрация</a>
        </div>
    </div>

    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-12"></div>
            </div>
        </div>
    </footer><!-- .site-footer -->

</div><!-- #page -->

<!-- Scripts and Analitics -->
<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<!-- <script>
    window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto'); ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script> -->
</body>
</html>