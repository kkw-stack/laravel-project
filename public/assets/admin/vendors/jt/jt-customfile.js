/**
 * 첨부파일 커스텀 플러그인
 *
 * @version 1.0.0 (메덩골 맞춤 커스텀)
 * @since 2024-05-01
 * @author STUDIO-JT (KMS)
 */
class JtCustomFile {

    /**
     * JtCustomFile 생성
     *
     * @constructor
     * @param {HTMLElement} element - Input File Element
     * @param {Object} [args] - 옵션
     * @param {string} [args.prefix='jt-customfile'] - 커스텀 파일 UI에 추가되는 class를 설정합니다.
     * @param {string} [args.inputClass='jt-customfile__input'] - Input 요소에 추가되는 class를 설정합니다.
     * @param {string} [args.buttonClass='jt-customfile__button'] - 파일 업로드 버튼에 추가되는 class를 설정합니다.
     * @param {string} [args.listClass='jt-customfile__list'] - 파일 목록에 추가되는 class를 설정합니다.
     * @param {string} [args.itemClass='jt-customfile__button'] - 파일 아이템 요소에 추가되는 class를 설정합니다.
     * @param {string} [args.fileExtensions='tiff;tif;jpg;jpeg;png;gif;bmp;webp;avif;heif;heic'] - 업로드 허용 확장자를 설정합니다.
     * @param {number} [args.fileMaxLength=10] - 등록가능 갯수를 설정합니다.
     * @param {number} [args.fileMaxSize=2097152] - 등록가능 파일 크기를 설정합니다. (단위 : 바이트 , 0 = 제한 없음)
     */
    constructor( element, args ) {

        if( typeof element == 'undefined' ) return; // Required

        const _this = this;

        _this.input   = element; // Input 필드
        _this.fileData = new DataTransfer(); // FileList

        _this.options = {
            prefix         : 'jt-customfile',
            inputClass     : 'jt-customfile__input',
            buttonClass    : 'jt-customfile__button',
            listClass      : 'jt-customfile__list',
            itemClass      : 'jt-customfile__item',
			fileExtensions : 'tiff;tif;jpg;jpeg;png;gif;bmp;webp;avif;heif;heic',
			fileMaxLength  : 10,
			fileMaxSize    : 2097152 // 10485760 (10MB)
        };

        // 파라미터 확인
        if( typeof args != 'undefined' ) {
            for( const [key, value] of Object.entries(args) ) {
                _this.options[key] = value;
            }
        }

        // Input 셋팅
        _this.input.classList.add(_this.options.inputClass);

        // Outer 컨테이너
        _this.container = _this.input.closest(`.${_this.options.prefix}`);

        // Inner 컨테이너
        _this.inner = _this.container.querySelector(`.${_this.options.prefix}__field`);

        // 버튼
        _this.button = _this.container.querySelector(`.${_this.options.buttonClass}`);

        // 리스트 컨테이너
        _this.list = _this.container.querySelector(`.${_this.options.listClass}`);

        // 리스너 할당
        _this.input.addEventListener('click', _this.onClick.bind(_this), false);
        _this.input.addEventListener('change', _this.onChange.bind(_this), false);

    }



    /**
     * Click 이벤트
     */
    onClick( event ) {

        var _this = this;

        if( !_this.isCount( _this.getCount() ) ) event.preventDefault();

    }



    /**
     * Change 이벤트
     */
    onChange() {

        const _this = this;

        // 신규 파일 데이터
        const newFilesList = _this.input.files;
        const newFilesCount = newFilesList.length;
        
        // 기존 파일 데이터
        const oldFilesList = _this.list;
        const oldFilesCount = Array.from(oldFilesList.querySelectorAll('button')).filter(( item ) => ( !!item.querySelector('[type="hidden"]:disabled') )).length;

        // 유효성 체크
        if( !_this.isCount( _this.getCount() + newFilesCount + oldFilesCount ) ) return false;

        for( let i = 0 ; i < newFilesCount ; i++ ){
            if( !_this.isExts(newFilesList[i].name) ) return false;
            if( !_this.isSize(newFilesList[i].size) ) return false;
        }

        _this.clearInvalid();

        // 파일 추가
        for( let i = 0 ; i < newFilesCount ; i++ ) {
            _this.addFile(newFilesList[i]);
        }

        // Input 데이터 동기화
        _this.setData();

    }



    /**
     * 리스트에 추가된 파일항목 추가
     * @param {} file
	 */
    addFile( file ) {

        const _this = this;

        const fileName = file.name.substring(0, file.name.lastIndexOf('.'));
        const fileExt = _this.getExts(file.name);

        // 첨부파일 UI 생성
        let item = document.createElement('button');
            item.setAttribute('type', 'button');
            item.setAttribute('class', _this.options.itemClass);
            item.innerHTML = `<span>${( fileName.length > 12) ? fileName.substring(0,12) + '...' : fileName}.${fileExt}</span>
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x btn-icon-append"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`;
            item.addEventListener('click', function(e){
                _this.removeFile(e);
            });

        _this.list.appendChild(item);

        // FileList 추가
        _this.fileData.items.add(file);

    }



    /**
     * 파일삭제
	 */
    removeFile( event ){

        var _this = this;

        const items   = Array.from(event.target.closest('.' + _this.options.listClass.split(' ')[0]).children).filter(( item ) => ( !item.querySelector('[type="hidden"]') ));
        const current = event.target.closest('.' + _this.options.itemClass.split(' ')[0]);
        const index   = items.indexOf(current);

        // UI 삭제
        current.remove();

        // FileList 삭제
        _this.fileData.items.remove(index);

        // Input 데이터 동기화
        _this.setData();

    }



    /**
     * Input 데이터 동기화
     */
    setData() {
        
        var _this = this;

        _this.input.files = _this.fileData.files;

    }



    /**
     * 첨부파일 갯수 반환
     * @return {number}
     */
    getCount() {
        
        var _this = this;

        return _this.fileData.items.length;

    }



    /**
     * 첨부파일 확장자 반환
     * @param {string} name
     * @return {string}
     */
    getExts( name ) {

        return name.substr( 2 + ( ~-name.lastIndexOf('.') >>> 0 ) ).toLowerCase();

    }



    /**
     * 최대 등록갯수 체크
     * @param {number} total
     * @return {boolean}
     */
    isCount( total ) {

        var _this = this;

        if( total > _this.options.fileMaxLength ) {

            _this.callInvalid( '최대 ' + _this.options.fileMaxLength + '개까지 첨부가능합니다.' );
            _this.setData();

            return false;

        }

        return true;

    }



    /**
     * 확장자 유효성 체크
     * @param {string} val
     * @return {boolean}
     */
    isExts( val ) {

        const _this = this;
        
        const fileExt = _this.getExts(val);

        if( _this.options.fileExtensions.toLowerCase().indexOf(fileExt) < 0 ){

            _this.callInvalid( '올바르지 않은 파일 유형입니다.' );
            _this.setData();

            return false;

        }

        return true;

    }



    /**
     * File 크기 체크
     * @param {number} size
     * @return {boolean}
     */
    isSize( size ) {

        const _this = this;

        if( _this.options.fileMaxSize > 0 && _this.options.fileMaxSize < size ) {

            _this.callInvalid( '첨부파일은 각 파일당 최대 ' + (_this.options.fileMaxSize / 1024 / 1024) + 'MB까지만 등록합니다.' );
            _this.setData();

            return false;
            
        }

        return true;

    }



    /**
     * 안내 메세지 추가
     * @param {string} msg
     */
    callInvalid( msg ) {

        const _this = this;

        if( ! _this.input.classList.contains('is-invalid') ) {
            // Input error class
            _this.input.classList.add('is-invalid');

            // Message
            const newFeedback = document.createElement('p');
            newFeedback.classList.add('error', 'invalid-feedback');
            newFeedback.textContent = msg;

            _this.inner.appendChild( newFeedback );
        } else {
            _this.inner.querySelector('.invalid-feedback').textContent = msg;
        }

    }



    /**
     * 안내 메세지 제거
     */
    clearInvalid() {

        const _this = this;

        if( _this.input.classList.contains('is-invalid') ) {
            _this.input.classList.remove('is-invalid');
            _this.inner.querySelector('.invalid-feedback').remove();
        }

    }

}