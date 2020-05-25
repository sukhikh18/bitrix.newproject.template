jQuery(document).ready(function($) {
    $('[name="privacy_accept"]').on('change', function(event) {
        var $submit = $(this).closest('form').find('[type="submit"]');

        if (!$(this).is(':checked')) {
            $submit.addClass('disabled').attr('disabled', 'disabled');
        } else {
            $submit.removeClass('disabled').removeAttr('disabled');
        }
    }).trigger('change');
});
