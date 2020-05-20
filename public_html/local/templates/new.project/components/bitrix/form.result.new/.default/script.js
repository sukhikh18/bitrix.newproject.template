jQuery(document).ready(function($) {
    /**
     * Serialize form data with files
     *
     * @param  [jQueryObject] $form form for serialize.
     * @return [FormData]
     */
    var serializeForm = function( $form ) {
        var formData = new FormData();

        // Append form data.
        var params = $form.serializeArray();
        $.each(params, function (i, val) {
            formData.append(val.name, val.value);
        });

        // Append files.
        $.each($form.find("input[type='file']"), function(i, tag) {
            $.each($(tag)[0].files, function(i, file) {
                formData.append(tag.name, file);
            });
        });

        // Append is ajax mark.
        formData.append('is_ajax', 'Y');
        // Append from submit button value.
        formData.append('web_form_submit', $form.find('[type="submit"]').val());

        return formData;
    };

    var showPreloader = function() { return false; },
        hidePreloader = function() { return false; };

    if( window.preloader ) {
        showPreloader = window.preloader.show;
        hidePreloader = window.preloader.hide;
    }

    var $form = $('form.form-result-new'),
        $messages = $form.find('.messages');

    $form.on('submit', function (event) {
        event.preventDefault();
        showPreloader();

        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            dataType: 'HTML',
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            data: serializeForm($form)
        })
            .done(function(response) {
                hidePreloader();
                $messages.html( response );
            })
            .fail(function(response) {
                hidePreloader();
                console.log( response );
            })
    });
});