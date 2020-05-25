jQuery(document).ready(function($) {
    var $wrap = $('.custom-auth');

    $wrap.on('submit', '[name="custom-auth-form"]', function(event) {
        event.preventDefault();
        var $errors = $('.custom-auth__errors', $(this));
        // Hide previous errors.
        $errors.hide();

        $.ajax({
            url: '/bitrix/services/main/ajax.php?' + $.param({
                c: 'seo18:custom.auth',
                action: 'formResult',
                mode: 'ajax'
            }, true),
            type: 'POST',
            data: $(this).serialize()
        }).done(function (result) {
            if("success" == result.status) {
                if(result.data.errors) {
                    $errors
                        .html(result.data.errors)
                        .fadeIn();
                }
                else {
                    $wrap.html(result.data.response);
                }
            }
        });
    });
});