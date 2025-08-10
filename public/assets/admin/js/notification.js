$(function () {
    'use strict';

    let formChanged = false;

    $('form').on('input', function () {
        formChanged = true;
    });

    // TinyMCE
    const editor = tinymce.get('boardContent');

    if( editor != null ) {
        editor.on('input', function() {
            formChanged = true;
        });
    }

    $('form').on('submit', function () {
        formChanged = false;
    });

    $(window).on('beforeunload', function (event) {
        if (formChanged) {
            return 'sure?';
        }
    });
});