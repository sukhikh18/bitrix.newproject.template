function OnHideBuiltin(arParams) {
    setTimeout(function() {
        var arElements = arParams.getElements();
        var wasteBuiltins = {
            'SET_TITLE': 'N',
            'SET_BROWSER_TITLE': 'N',
            'SET_META_KEYWORDS': 'N',
            'SET_META_DESCRIPTION': 'N',
            'SET_LAST_MODIFIED': 'N',
            'INCLUDE_IBLOCK_INTO_CHAIN': 'N',
            'ADD_SECTIONS_CHAIN': 'N',
            'AJAX_MODE': 'N',
            'AJAX_OPTION_ADDITIONAL': 'AJAX_OPTION_ADDITIONAL',
            'AJAX_OPTION_HISTORY': 'N',
            'AJAX_OPTION_JUMP': 'N',
            'AJAX_OPTION_STYLE': 'Y',
            'PAGER_BASE_LINK_ENABLE': 'N',
            'PAGER_DESC_NUMBERING': 'N',
            'PAGER_DESC_NUMBERING_CACHE_TIME': 'PAGER_DESC_NUMBERING_CACHE_TIME',
            'PAGER_SHOW_ALL': 'N',
            'PAGER_SHOW_ALWAYS': 'N',
            'PAGER_TEMPLATE': 'PAGER_TEMPLATE',
            'PAGER_TITLE': 'PAGER_TITLE',
            'DISPLAY_BOTTOM_PAGER': 'N',
            'DISPLAY_TOP_PAGER': 'N',
        };

        var $input = $( arParams.oInput );
        var $title = $input.closest('.bxcompprop-content').prev('.bxcompprop-title');

        $title.find('.bxcompprop-title-text-lbl').text('Слайдер');
        $title.find('.bxcompprop-title-info-btn').attr('title', 'Слайдер из одного информационного блока.');
        $input.closest('tr').hide();

        $.each(wasteBuiltins, function(index, val) {
            if( arElements[ index ] ) {
                $(arElements[ index ]).val( index ).closest('tr').hide();
            }
        });

    }, 100);
}
