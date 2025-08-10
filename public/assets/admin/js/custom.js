$(function () {
    'use strict'

    // INIT
    jt_preview_file();

    // Single select
    $('.js-select-primary').each(function(){
        $(this).select2({
            language: {
                noResults: function() {
                    return '검색결과가 없습니다.';
                }
            }
        });
    });

    // Date picker
    $('.js-flatpickr-date').each(function(){
        let dataset = this.dataset;
        let hides = ( dataset.hide || '' ).split(',');

        flatpickr(this, {
            locale    : 'ko',
            wrap      : true,
            altInput  : true,
            dateFormat: ( dataset.format || 'Y-m-d' ),
            altFormat : ( dataset.altFormat || 'Y. m. d' ),
            onOpen    : () => {
                hides.forEach(( hide ) => {
                    switch( hide.trim() ){
                        case 'year' : {
                            let calendar = this._flatpickr.calendarContainer;
                            if( !!calendar ) calendar.querySelector('.numInputWrapper').style.display = 'none';
                            break;
                        }
                    }
                });
            }
        });
    });

    // Datetime picker
    $('.js-flatpickr-datetime').each(function(){
        flatpickr(this, {
            locale    : 'ko',
            wrap      : true,
            enableTime: true,
            altInput  : true,
            dateFormat: 'Y-m-d H:i:s',
            altFormat : 'Y. m. d H:i'
        });
    });

    // Tinymce editor
    if( $('.js-tinymce-editor').length ) {
        tinymce.init({
            selector         : '.js-tinymce-editor',
            placeholder      : '내용을 입력해주세요.',
            plugins          : [ 'link', 'lists', 'image', 'table' ],
            image_caption    : true,
            menubar          : false,
            images_upload_url: '/medongadmin/api/editor/upload',
            convert_urls     : false, // 저장시 절대경로 처리를 위해서 추가
            toolbar1         : 'outdent indent | bold italic underline | forecolor backcolor | alignleft aligncenter alignright',
            toolbar2         : 'h2 h3 h4 h5 h6 | link | bullist numlist | image table',
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

    // Tinymce editor table
    if( $('.js-tinymce-editor-table').length ) {
        tinymce.init({
            selector         : '.js-tinymce-editor-table',
            placeholder      : '내용을 입력해주세요.',
            plugins          : [ 'table' ],
            image_caption    : true,
            menubar          : false,
            images_upload_url: '/medongadmin/api/editor/upload',
            convert_urls     : false, // 저장시 절대경로 처리를 위해서 추가
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

    // File custom
    if( $('.jt-customfile').length ) {
        document.querySelectorAll('.jt-customfile__list').forEach((list) => {
            list.querySelectorAll('.btn').forEach((btn) => {
                btn.addEventListener('click', function(e){
                    e.preventDefault();

                    btn.style.setProperty('display', 'none', 'important');
                    btn.querySelector(':scope > input[type="hidden"]').disabled = false;
                });
            });
        });

        document.querySelectorAll('.js-jt-file').forEach((input) => {
            const extensions = input.getAttribute('data-extensions') ?? 'zip;ppt;pptx;pdf;jpg;jpeg;png;webp;xlsx';
            const length     = input.getAttribute('data-count') ?? 999;
            const size       = input.getAttribute('data-size') ?? 10485760;

            new JtCustomFile(input, {
                itemClass     : 'btn btn-outline-dark btn-icon-text btn-xs',
                fileExtensions: extensions,
                fileMaxLength : Number(length),
                fileMaxSize   : Number(size)
            });
        });
    }

    // Handle sort
    $('.jt-handle-sort').each(function(){
        new Sortable(this, {
            handle    : '.jt-handle-sort__grap',
            animation : 150,
            ghostClass: 'bg-light'
        });
    });

    // File with preview
    function jt_preview_file() {
        if( $('.jt-file-with-preview').length ) {
            $('.jt-file-with-preview').each(function(){
                const $wrap          = $(this);
                const $input         = $wrap.find('input[type="file"]');
                const $preview       = $wrap.find('.jt-image-preview');
                const $previewDelete = $preview.find('button');
                const $previewImg    = $preview.find('img');
                let   previousFile   = null;

                $input.off().on({
                    click: function(e){
                        previousFile = $input[0].files[0];
                    },
                    change: function(e){
                        const fileMaxSize = Number($input.attr('data-size'));
                        const file        = e.target.files[0];

                        if( file ) {
                            if( file.type.startsWith('image/') ) {
                                if( fileMaxSize != '' && file.size > (fileMaxSize * 1024 * 1024) ) {
                                    if( !$input.hasClass('is-invalid') ) {
                                        $input.addClass('is-invalid');
                                        $input.after(`<p class="error invalid-feedback">첨부파일은 각 파일당 최대 ${fileMaxSize}MB까지만 등록합니다.</p>`);

                                        if( $preview.is(':visible') ) {
                                            $preview.removeClass('d-block').addClass('d-none');
                                        }
                                    } else {
                                        $input.next('.invalid-feedback').text(`첨부파일은 각 파일당 최대 ${fileMaxSize}MB까지만 등록합니다.`);
                                    }

                                    $input.val('');
                                    return;
                                } else {
                                    if( $input.hasClass('is-invalid') ) {
                                        $input.removeClass('is-invalid');
                                        $wrap.find('.invalid-feedback').remove();
                                    }
                                }

                                const reader = new FileReader();

                                reader.onload = function (e) {
                                    $previewImg.attr('src', e.target.result);
                                    $preview.removeClass('d-none').addClass('d-block');
                                };

                                reader.readAsDataURL(file);

                            } else {
                                if( !$input.hasClass('is-invalid') ) {
                                    $input.addClass('is-invalid');
                                    $input.after(`<p class="error invalid-feedback">올바르지 않은 파일 유형입니다.</p>`);

                                    if( $preview.is(':visible') ) {
                                        $preview.removeClass('d-block').addClass('d-none');
                                    }
                                } else {
                                    $input.next('.invalid-feedback').text('올바르지 않은 파일 유형입니다.');
                                }

                                $input.val('');
                                return;
                            }
                        } else {
                            beforeImageReload();
                        }
                    }
                });

                $previewDelete.off().on('click', function(e){
                    e.preventDefault();

                    if( $input.val() != '' ) {
                        $input.val('');
                    }

                    $preview.removeClass('d-block').addClass('d-none');
                });

                function beforeImageReload(){
                    if( previousFile ) {
                        const blob = new Blob([previousFile], { type: previousFile.type });
                        const newFile = new File([blob], previousFile.name);

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(newFile);
                        $input[0].files = dataTransfer.files;
                    }
                }
            });
        }
    } window.jt_preview_file = jt_preview_file;

    // Input number maxlength
    if( $('input[type="number"][data-maxlength]').length ) {
        $('input[type="number"][data-maxlength]').on('input', function(e){
            const el    = e.target;
            const value = el.value;
            const max   = Number( $(el).attr('data-maxlength') );

            if( value.length > max ) { el.value = value.slice(0, max); }
        });
    }

    // Table accordion
    $('.jt-table-accordion__item').each(function(){
        $(this).on('click', function(){
            $(this).toggleClass('jt-table-accordion--show');
            $(this).closest('tr').next('tr').find('.jt-table-accordion__content').toggleClass('jt-table-accordion--show').slideToggle(300);
        });
    });

});
