$(function () {
    'use strict'

    // 삭제
    $(document).on('click', '[data-repeater-remove]', function(e){
        const $repeater = $(this).closest('.jt-repeater');
        const $content  = $repeater.find( `[${$repeater.attr('data-repeater-content')}]` );
        const minRow    = ( typeof $repeater.attr('data-repeater-min') != 'undefined') ? Number($repeater.attr('data-repeater-min')) : false;
        const rowCount  = $content.children().length;
    
        if( ( !!minRow && minRow < rowCount ) || !!!minRow ) {
            $(this).closest('tr').remove();

            // 추가 버튼
            $repeater.find( '[data-repeater-add]' ).not( $content.find( '[data-repeater-add]' ) ).attr('disabled', false);

            // 삭제 버튼
            if( (rowCount-1) == minRow ) {
                $content.find( '[data-repeater-remove]' ).not( $content.find( '.jt-repeater [data-repeater-remove]' ) ).attr('disabled', true);
            }
        }
    });

    // 추가
    $(document).on('click', '[data-repeater-add]', function(e){
        const $repeater = $(this).closest('.jt-repeater');
        const $content  = $repeater.find( `[${$repeater.attr('data-repeater-content')}]` );
        const maxRow    = ( typeof $repeater.attr('data-repeater-max') != 'undefined') ? Number($repeater.attr('data-repeater-max')) : false;
        const minRow    = ( typeof $repeater.attr('data-repeater-min') != 'undefined') ? Number($repeater.attr('data-repeater-min')) : false;
        const rowCount  = $content.children().length;

        if( ( !!maxRow && maxRow > rowCount ) || !!!maxRow ) {
            const template = $( $(`[${$repeater.attr('data-repeater-template')}]`).html() );

            // UI 추가
            $content.append(template);

            // Feather icon repace
            feather.replace();

            // UI reinit
            $(template).find('.js-select-primary').select2({
                language: {
                    noResults: function() {
                        return '검색결과가 없습니다.';
                    }
                }
            });
            
            $(template).find('.jt-handle-sort').each(function(){
                new Sortable(this, {
                    handle    : '.jt-handle-sort__grap',
                    animation : 150,
                    ghostClass: 'bg-light'
                });
            });

            if( $(template).find('.js-tinymce-editor-table').length ) {
                // Remove tinymce instance
                tinymce.remove($(template).find('.js-tinymce-editor-table'));

                // Reset tinymce instance
                tinymce.init({
                    selector         : '.js-tinymce-editor-table',
                    placeholder      : '내용을 입력해주세요.',
                    plugins          : [ 'table' ],
                    image_caption    : true,
                    menubar          : false,
                    images_upload_url: '/medongadmin/api/editor/upload',
                    toolbar1         : 'table',
                    content_css      : '/assets/admin/css/editor.css',
                    color_map        : [
                        '000000', 'Black',
                        '666666', 'Light Grey',
                        'D03F3F', 'Red',
                        '13B752', 'Green',
                        'F26D0D', 'Yellow',
                        '006BF9', 'Blue'
                    ]
                });
            }

            // Date picker
            $(template).find('.js-flatpickr-date').each(function(){
                flatpickr(this, {
                    locale    : 'ko',
                    wrap      : true,
                    altInput  : true,
                    dateFormat: 'Y-m-d',
                    altFormat : 'Y. m. d'
                });
            });

            // Datetime picker
            $(template).find('.js-flatpickr-datetime').each(function(){
                flatpickr(this, {
                    locale    : 'ko',
                    wrap      : true,
                    enableTime: true,
                    altInput  : true,
                    dateFormat: 'Y-m-d H:i:s',
                    altFormat : 'Y. m. d H:i'
                });
            });

            if( $(template).find('.jt-file-with-preview').length ) jt_preview_file();

            // 추가 버튼
            if( (rowCount+1) == maxRow ) $(this).attr('disabled', true);

            // 삭제 버튼
            if( (rowCount+1) > minRow ) $content.find('[data-repeater-remove]').attr('disabled', false);

            // 자식 repeater의 삭제 버튼 비활성화
            $repeater.find('.jt-repeater').each(function() {
                const $childRepeater = $(this);
                const $childContent  = $childRepeater.find(`[${$childRepeater.attr('data-repeater-content')}]`);
                const childMinRow    = (typeof $childRepeater.attr('data-repeater-min') != 'undefined') ? Number($childRepeater.attr('data-repeater-min')) : false;
                const childRowCount  = $childContent.children().length;

                if ( childMinRow && childRowCount <= childMinRow ) {
                    $childContent.find('[data-repeater-remove]').attr('disabled', true);
                }
            });
        }
    });

});