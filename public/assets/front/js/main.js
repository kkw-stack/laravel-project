/*
 * File    : main.js
 * Author  : STUDIO-JT
 *
 * SUMMARY :
 * GLOBAL VARIABLE
 * RUN
 * INIT
 * ON LOAD
 * ON RESIZE
 * JT DEFAULT FUNCTIONS
 * OTHER FUNCTIONS
 * HELPER
 */



(function(){



/* **************************************** *
 * GLOBAL VARIABLE
 * **************************************** */
// Slider autoplay progress timeline
let sliderProgress = null;

// Slider observer list
let globalObserver = [];

// Marquee list
let marqueeList = [];

// Sound variable
let globalSound = null;
let globalSoundVol = 0;

// Global gsap clear style list ( prevent lost background image )
JT.globals.clearPropsList = ['transform', 'visibility', 'clip-path', 'opacity', 'width', 'height', 'max-width', 'max-height', 'padding', 'margin', 'top', 'left', 'display', 'position'];

// Global resize func list
JT.globals.resizes = {};

// Global visibility change func list
JT.globals.visibilityChanges = {};

// JT Popup global function
JT.globals.popup = jt_popup;

// Window open popup function
JT.globals.popupWin = jt_popup_win;

// Reservation result scroll function ( use react page )
JT.ui.add(reservation_result_scroll);



/* **************************************** *
 * RUN
 * **************************************** */
init( true );



/* **************************************** *
 * INIT
 * **************************************** */
function init( loadonce ){

    const body = document.body;

    if( is_orientation('portrait') ){
        body.classList.add('jt-orientation--portrait');
    } else {
        body.classList.add('jt-orientation--landscape');
    }

    if( typeof loadonce !== 'undefined' && loadonce === true ) {
        scroll_disable_helper();
    }

    if( !JT.smoothscroll.enabled ){
        JT.smoothscroll.init();
    }

    // Main functions
    if( body.classList.contains('home') ){

        main_visual_header();
        main_visual_slider();
        main_visual_resize();
        main_visual_motion();
        main_connect_motion();
        main_preview_popup();
        main_garden_motion();
        main_construct_motion();
        main_director_motion();
        main_scenery_slider();

    } else { // Sub functions

        sub_visual_slider();

        garden_korea_scroll_motion();
        garden_korea_gallery_tab();

        introduce_about_visual();
        introduce_about_identity();

        introduce_people_gallery_tab();
        introduce_people_popup();
        introduce_people_appeal();

        introduce_history_scroll();
        introduce_history_hover();

        construct_visual_scroll();

        construct_seongok_seowon_intro();
        construct_seongok_seowon_director();

        google_map_init();

        manual_location_traffic_tab();
        manual_service_gallery();

        jt_category();
        jt_accordion();
        jt_anchor();
        jt_search_filter();
        jt_single_select();
        jt_single_scale();

        jt_agreement();
        jt_agreement_popup();

        reservation_result_scroll();
        reservation_useable_popup();
        reservation_qrcode();

        jt_scenery_popup();

    }

    autoplay_inview();
    footer_float_motion();
    footer_active();

    // First load
    if( typeof loadonce !== 'undefined' && loadonce === true ) {

        // Default functions
        gsap_config();
        minimize_header();
        header_nav();
        skip_nav();
        global_sound_init();
        jt_embed_video();
        reservation_comingsoon_popup();
        footer_float_sticky();
        full_height();
        disable_contextmenu();

        // Barba
        barba_init();

        // Intro set session
        sessionStorage.setItem('intro', 1);

    // >=2nd load
    } else {

        // Init UI
        JT.ui.init();

        // Init onload
        init_onload();

        // Init resize on reisize
        if( JT.browser('mobile') ) {
            screen.orientation.addEventListener('change', init_resize);
        } else {
            window.addEventListener('resize', init_resize);
        }

    }

    // Visibility change event mount
    Object.keys( JT.globals.visibilityChanges ).map(( key ) => {
        document.addEventListener('visibilitychange', JT.globals.visibilityChanges[ key ]);
    });

}



/* **************************************** *
 * ON LOAD
 * **************************************** */
// INITIALIZE ONLOAD
function init_onload(){

    document.body.classList.add('jt-loaded');

}

window.addEventListener('load', init_onload);



/* **************************************** *
 * ON RESIZE
 * **************************************** */
// INITIALIZE RESIZE
function init_resize(){

    // setTimeout to fix IOS animation on rotate issue
    setTimeout(() => {

        if( is_orientation('portrait') ){
            document.body.classList.remove('jt-orientation--landscape');
            document.body.classList.add('jt-orientation--portrait');
        } else {
            document.body.classList.remove('jt-orientation--portrait');
            document.body.classList.add('jt-orientation--landscape');
        }

        // Resize event
        Promise.all(Object.keys( JT.globals.resizes ).map(( key ) => { return JT.globals.resizes[ key ].call() })).then(() => {
            ScrollTrigger.refresh();
        })

    }, 100);

}

// Init resize on reisize
if( JT.browser('mobile') ) {
    screen.orientation.addEventListener('change', init_resize);
} else {
    window.addEventListener('resize', init_resize);
}



/* **************************************** *
 * BARBA
 * **************************************** */
function barba_init(){

    // https://developers.google.com/web/updates/2015/09/history-api-scroll-restoration
	if( 'scrollRestoration' in history ) {
		history.scrollRestoration = 'manual';
	}

	if( 'history' in window && 'pushState' in history ){

		if( typeof barba === 'undefined' ) return;

		// Prevent current url to reload page
        document.body.addEventListener('click', ( e ) => {

            if( !e.target.closest('a') ) return;

            if( ( e.target.closest('a').href.split('#')[0] === ( location.origin + location.pathname ) ) && !e.target.closest('#logo') && !( 'barbaPrevent' in e.target.closest('a').dataset ) ){
                e.preventDefault();
                e.stopPropagation();
            }

            if( document.body.classList.contains('home') && e.target.closest('#logo') ){
                e.preventDefault();
                e.stopPropagation();

                location.href = e.target.closest('a').href.split('#')[0];
            }

        });

		// track bodyclass to update them a the right time
		let bodyClassesTracker = '';

		// barba init
		barba.init({
            prevent: () => {
                let list = ['reservation-form'];
                let isPrevent = false;

                list.forEach(( bodyClass ) => {
                    if( document.body.classList.contains( bodyClass ) ){
                        isPrevent = true;
                    }
                });

                if( document.querySelector('form.jt-form') ){
                    isPrevent = true;
                }

                return isPrevent;
            },
            transitions: [
                {
                    name: 'default-transition',
                    leave( data ) {

                        // start Promise
                        return new Promise(( resolve ) => {
                            if( String( data.trigger ).split(' ')[0] !== 'filter' ){
                                gsap.to('#barba-wrapper', { duration: .2, autoAlpha: 0, onComplete: () => resolve() });
                            } else {
                                resolve();
                            }
                        });
                    },
                    enter( data ) {

                        const newDom = data.next.container;

                        if( String( data.trigger ).split(' ')[0] !== 'filter' ){

                            gsap.set(newDom, { autoAlpha: 0 });

                            const parser = new DOMParser();

                            // Update menu (refresh current class)
                            const response = parser.parseFromString( data.next.html, 'text/html' );

                            // Update canonical
                            document.querySelector('link[rel="canonical"').setAttribute('href', data.next.url.href.split('?')[0]);

                            // Update seo
                            document.querySelector('meta[name="description"]').content = response.querySelector('meta[name="description"]').content;
                            document.querySelector('meta[name="keywords"]').content = response.querySelector('meta[name="keywords"]').content;

                            // Update og
                            document.querySelector('meta[property="og:title"]').content = response.querySelector('meta[property="og:title"]').content;
                            document.querySelector('meta[property="og:description"]').content = response.querySelector('meta[property="og:description"]').content;
                            document.querySelector('meta[property="og:url"]').content = response.querySelector('meta[property="og:url"]').content;
                            document.querySelector('meta[property="og:image"]').content = response.querySelector('meta[property="og:image"]').content;

                            // Update body class
                            bodyClassesTracker = response.querySelector('body').getAttribute('class');
                            document.body.setAttribute('class', bodyClassesTracker);

                            // Update logo tag
                            document.querySelector('#logo').replaceWith( response.querySelector('#logo') );

                            // Update menu
                            document.querySelector('#menu').replaceWith( response.querySelector('#menu') );

                            // Update popup
                            document.querySelectorAll('.jt-popup').forEach(( popup ) => { popup.remove(); });
                            response.querySelectorAll('.jt-popup').forEach(( popup ) => { document.body.appendChild( popup ); });

                            if( data.trigger === 'back' ){
                                // History back
                            } else {
                                gsap.set(window, { scrollTo: 0 });
                            }

                            // Prevent memory leak
                            clean_memory( data.current.container );

                        }

                        // After images are full loaded process the transition
                        imagesLoaded(newDom, () => {
                            gsap.set(newDom, { clearProps: 'all' });
                            gsap.to('#barba-wrapper', { duration: .3, autoAlpha: 1 });

                            init();

                            if( String( data.trigger ).split(' ')[0] === 'filter' ){

                                if( !!document.querySelector('.article__body') || !!document.querySelector('.jt-single__inner') ){
                                    JT.scroll.destroy( true );
                                    gsap.to(window, { duration: .4, scrollTo: ( window.scrollY + ( document.querySelector('.article__body') || document.querySelector('.jt-single__inner') ).getBoundingClientRect().top - document.querySelector('#header').offsetHeight ), onComplete: () => {
                                        JT.scroll.restore( true );
                                        JT.globals.minimizeHeader( true );
                                    } });
                                }

                            }
                        });
                    }
                },
                {
                    name: 'self',
                    enter( data ) { // Query string back/forward not working fix (https://barba.js.org/docs/advanced/transitions/#Self)
                        const newDom = data.next.container;

                        imagesLoaded(newDom, () => {
                            gsap.set(newDom, { clearProps: 'all' });
                            gsap.to('#barba-wrapper', { duration: .3, autoAlpha: 1 });

                            init();
                        });
                    }
                }
            ]
        });

    }
}



// CLEAN THE MEMORY
function clean_memory( old ){

	if(typeof gsap.killTweensOf !== "undefined"){
        // killtween
	    JT.killChildTweensOf( gsap.utils.toArray('#barba-wrapper *')[0] );
	}

    if( ScrollTrigger.getAll().length > 0 ) {
		// kill scrolltrigger
        ScrollTrigger.getAll().forEach(( st ) => {
            st.kill();
        });
	}

    // Slider autoplay timeline kill
    sliderProgress?.kill();

    // Disconnect observer
    globalObserver.forEach(( observer ) => { observer.disconnect(); });
    marqueeList.forEach(( marquee ) => { marquee.observer.disconnect(); });

    globalObserver = [];
    marqueeList = [];

	// Clean video memory (http://stackoverflow.com/a/28060352/4780961)
    old.querySelectorAll('video').forEach(( vid ) => {
        if( !vid.paused ) vid.pause();
        vid.src = '';
        vid.querySelector('source').src = '';
        vid.remove();
    });

    // kill all swiper instance
    document.querySelectorAll('.swiper').forEach(( slider ) => { slider.swiper?.destroy() } );

    // Clean body style
    document.body.classList.remove('jt-minimize-layout');
    document.body.removeAttribute('style');

    // Ally : focus clear
    document.querySelector('#skip').tabIndex = 0;
    document.querySelector('#skip').focus();
    document.querySelector('#skip').removeAttribute('tabIndex');

    // Header reset
    document.querySelector('#header').classList.remove('minimize', 'noborder');
    document.querySelector('#header').removeAttribute('style');

    // Footer reset
    document.querySelector('#footer').classList.remove('footer--active');

    // Float sticky style reset
    document.querySelector('.footer__float-sticky')?.classList.remove('footer__float-sticky--fixed', 'footer__float-sticky--show');

    // Sound state reset
    if( !globalSound.playing() && globalSoundVol > 0 ){
        globalSound.volume( globalSoundVol );
        globalSound.play();
    }

    // Close menu close
    JT.globals.close_menu( true );

    // Scroll restore
    JT.scroll.restore( true );

    // Resize func reset
    JT.globals.resizes = {}

    // Visibility change func reset
    Object.keys( JT.globals.visibilityChanges ).map(( key ) => {
        document.removeEventListener('visibilitychange', JT.globals.visibilityChanges[ key ]);
        delete JT.globals.visibilityChanges[ key ];
    });

    // Resize event reset
    if( JT.browser('mobile') ){
        screen.orientation.removeEventListener('change', init_resize);
    } else {
        window.removeEventListener('resize', init_resize);
    }

}



/* **************************************** *
 * JT DEFAULT FUNCTIONS
 * **************************************** */
/**
 * CUSTOM GSAP CONFIG ( Remove gsap warning from console )
 *
 * @version 1.0.0
 * @author STUDIO-JT (Nico)
 * @requires gsap.min.js
 */
function gsap_config(){

    gsap.config({
        nullTargetWarn: false,
        trialWarn: false
    });

    // Mobile scroll layout shift fix
    if( typeof ScrollTrigger !== 'undefined' ){

        ScrollTrigger.config({
            autoRefreshEvents: 'visibilitychange, DOMContentloaded, load'
        });

    }

}



/**
 * FIX HEADER ANIMATION
 *
 * @version 1.0.0
 * @author STUDIO-JT (KMS, Nico)
 * @requires gsap.min.js
 */
function minimize_header(){

    const header      = document.getElementById('header');
    const body        = document.body;
    let currentScroll = 0
    let lastScroll    = 0
    let moveScroll    = 10
    let didScroll     = null;

    if( !header ) return;

    window.addEventListener('scroll', () => {

        didScroll = true;

    });

    setInterval(() => {

        if( didScroll && !body.classList.contains('scroll-fixed') ) {
            has_scrolled();
            didScroll = false;
        }

    }, 50);

    function has_scrolled(){

        currentScroll = window.scrollY;

        // Make sure they scroll more than move scroll
        if( ( Math.abs(lastScroll - currentScroll) <= moveScroll ) || document.body.classList.contains('.main-visual--running') ) return;

        if( currentScroll > lastScroll ){ // ScrollDown or Minimize fixed
            if( currentScroll > header.offsetHeight ){
                set_minimize( true );
            }
        }
        else { // ScrollUp
            set_minimize( false );
        }

        lastScroll = currentScroll;

    }

    function set_minimize( enable = true ){

        if( enable ){
            gsap.to(header, { duration: .4, autoAlpha: 0, y: -header.offsetHeight, ease: 'power3.out', onStart: () => {
                body.classList.add('jt-minimize-layout');
                header.classList.add('minimize');
            }});
        } else {
            gsap.to(header, {duration: .4, autoAlpha: 1, y: 0, ease: 'power3.out', onComplete: () => {
                body.classList.remove('jt-minimize-layout');
                header.classList.remove('minimize');
            }});
        }

    }

    JT.globals.minimizeHeader = set_minimize;

}



/**
 * small screen navigation
 *
 * @version 1.0.0
 * @author STUDIO-JT (KMS)
 * @requires gsap.min.js
 * @requires jt.js
 */
function header_nav(){

    const body          = document.body,
          menuBtn       = document.querySelector('.menu-controller'),
          menuBtnLine01 = document.querySelector('.menu-controller__line--01'),
          menuBtnLine02 = document.querySelector('.menu-controller__line--02'),
          menuContainer = document.querySelector('#menu-container'),
          menuOverlay   = document.querySelector('.menu-container__overlay');
    let   isLoading     = false;
          isRun         = false;

    if( !menuContainer ) return;

    // 2댑스 메뉴 아코디언 기능 추가
    menuContainer.addEventListener('click', ( e ) => {

        if( !!e.target.closest('#menu > li.menu-item-has-children > a') && JT.isScreen(1023) ){
            e.preventDefault();
            e.stopPropagation();

            if( isRun ) return;
            isRun = true;

            const item = e.target;
            const currList = item.closest('li');
            const currChild = currList.querySelector(':scope > ul');

            if( window.getComputedStyle(currChild).display === 'none' ) {

                menuContainer.querySelectorAll('#menu > li').forEach( ( item ) => item.classList.remove('menu-item--open') );
                currList.classList.add('menu-item--open');

                menuContainer.querySelectorAll('#menu > li:not(.menu-item--open) ul.sub-menu').forEach( ( item ) => JT.slide.up(item) );
                JT.slide.down(currChild, 500, () => { isRun = false });

            } else {

                currList.classList.remove('menu-item--open');
                JT.slide.up(currChild, 500, () => { isRun = false });

            }
        }

    });

    menuBtn.addEventListener('click', ( e ) => {
        e.preventDefault();
        e.stopPropagation();

        if( isLoading ) return;
        isLoading = true;

        if( !body.classList.contains('open-menu') ){
            open_menu();
        } else {
            close_menu();
        }
    });

    menuOverlay.addEventListener('click', () => {

        if( isLoading ) return;
        isLoading = true;

        close_menu();

    });

    // 메뉴 열기
    function open_menu(){

        body.classList.add('open-menu');

        // Active menu check
        menuContainer.querySelectorAll('#menu > li').forEach(( item ) => {
			if( item.classList.contains('current-menu-ancestor') || item.classList.contains('current-menu-item') ){
                item.classList.add('menu-item--open');

				if( !!item.querySelector(':scope > ul') ) {
                    item.querySelector(':scope > ul').style.display = 'block';
				}

				return false;
			}
        });

        // Show
		gsap.fromTo(menuContainer, {
		    autoAlpha: 0,
		}, {
		    autoAlpha: 1,
		    duration: .3,
		    ease: 'power3.out',
		    onStart: () => {
                // Scroll
                scroll_fixed( false );
		        menuContainer.style.display = 'block';
                gsap.to('.menu-controller__text-track', { duration: .3, y: -( document.querySelector('.menu-controller__text').offsetHeight ), ease: 'none' });
                gsap.set('#menu', { scrollTo: menuContainer.querySelector('#menu > li.current-menu-ancestor')?.offsetTop || 0 })
		    },
            onComplete: () => {
                isLoading = false;
            }
		});

        const positionY = menuBtn.querySelector('.menu-controller__box').getBoundingClientRect().width / 5.3; // Rem fix
		gsap.to(menuBtnLine01, { y: positionY, rotation: 45, duration: .3, ease: 'power4.inOut' });
		gsap.to(menuBtnLine02, { y: -positionY, rotation: -45, duration: .3, ease: 'power4.inOut' });

    }

    // 메뉴 닫기
    function close_menu( reset ){

		gsap.to(menuContainer, {
			autoAlpha: 0,
            duration: .3,
			ease: 'power3.out',
            onStart: () => {
                gsap.to('.menu-controller__text-track', { duration: .3, y: 0, ease: 'none' });
                if( !reset ) scroll_fixed( true );
            },
            onComplete: () => {
                menuContainer.style.display = 'none';

				menuContainer.querySelectorAll('#menu > li').forEach( ( item ) => item.classList.remove('menu-item--open') );
                menuContainer.querySelectorAll('#menu > li > ul').forEach( ( item ) => gsap.set(item, { clearProps: 'display' }) );

                body.classList.remove('open-menu');

                isLoading = false;
            }
        });
		gsap.to(menuBtnLine01, { y: 0, rotation: 0, duration: .3, ease: 'power4.inOut' });
		gsap.to(menuBtnLine02, { y: 0, rotation: 0, duration: .3, ease: 'power4.inOut' });

    }

	// Device rotation fix
    function header_nav_resize(){

        menuContainer.querySelectorAll('li.menu-item--open').forEach(( li ) => { li.classList.remove('menu-item--open'); });
        menuContainer.querySelectorAll('#menu > li > ul').forEach(( ul ) => { ul.removeAttribute('style'); });

        if( body.classList.contains('open-menu') ){
            menuContainer.style.display = 'none';
            close_menu();
        }

    }

    if( JT.browser('mobile') ) {
        screen.orientation.addEventListener('change', header_nav_resize);
    } else {
        window.addEventListener('resize', header_nav_resize);
    }

    JT.globals.close_menu = close_menu;

}



/* **************************************** *
 * OTHER FUNCTIONS
 * **************************************** */
// Skip nav event
function skip_nav(){

    const skip = document.querySelector('#skip a');

    if( !skip ) return;

    skip.addEventListener('click', ( e ) => {

        e.preventDefault();
        e.stopPropagation();

        const container = document.querySelector( skip.getAttribute('href') );

        if( !container ) return;

        gsap.set(window, { scrollTo: ( container.getBoundingClientRect().top + window.scrollY ), onComplete: () => {
            container.setAttribute('tabIndex', '0');
            container.focus();
            container.removeAttribute('tabIndex');
        } });

    });

}



// Global sound init
function global_sound_init(){

    const sound     = document.querySelector('.header__utils-sound');
    const equalizer = document.querySelector('.header__utils-sound-equalizer path');

    if( !sound ) return;

    globalSound = new Howl({
        src: [ sound.dataset.sound ],
        volume: 0,
        loop: true,
        preload: false,
        html5: true
    });

    globalSound.once('load', () => {
        globalSound.play();
    });

    let soundLinear = gsap.to('.header__utils-sound .jt-icon svg', { duration: 5, repeat: -1, x: -( document.querySelector('.header__utils-sound .jt-icon svg').getBoundingClientRect().width - document.querySelector('.header__utils-sound-equalizer .jt-icon').offsetWidth ), ease: 'none' });

    sound.addEventListener('click', ( e ) => {

        e.preventDefault();
        e.stopPropagation();

        if( sound.classList.contains('header__utils-sound--running') ) return;
        sound.classList.add('header__utils-sound--running');

        if( sound.classList.contains('header__utils-sound--played') ){ // Off

            let volume = { val: 1 };

            globalSoundVol = 0;

            gsap.to(volume, {
                duration: 1,
                val: globalSoundVol,
                ease: 'circ.out',
                onUpdate: () => {
                    globalSound.volume( volume.val.toFixed(2) );
                },
                onStart: () => {
                    sound.classList.add('header__utils-sound--paused');
                    sound.classList.remove('header__utils-sound--played');
                    sound_pause();
                },
                onComplete: () => {
                    globalSound.pause();
                    sound.classList.remove('header__utils-sound--running');
                }
            });

        } else { // On

            let volume = { val: 0 };

            globalSoundVol = 1;

            gsap.to(volume, {
                duration: 1,
                val: globalSoundVol,
                ease: 'circ.out',
                onUpdate: () => {
                    globalSound.volume( volume.val.toFixed(2) );
                },
                onStart: () => {
                    sound.classList.add('header__utils-sound--played');
                    sound.classList.remove('header__utils-sound--paused');
                    sound_play();
                },
                onComplete: () => {
                    sound.classList.remove('header__utils-sound--running');
                }
            });

        }

    });

    function sound_play(){
        if( globalSound._state !== 'loaded' ){
            globalSound.load();
        } else {
            globalSound.play();
        }
        gsap.to(equalizer, { duration: .3, ease: 'none', morphSVG: 'M0,5c5,0,5,11,10,11S15,5,20,5s5,11,10,11S35,5,40,5s5,11,10,11S55,5,60,5s5,11,10,11S75,5,80,5c5,0,5,11,10,11c5,0,5-11,10-11s5,11,10,11c5,0,5-11,10-11' });
    }

    function sound_pause( now ){
        gsap.to(equalizer, { duration: .3, ease: 'none', morphSVG: equalizer.dataset.original });
        if( now ) {
            globalSound.pause();
        }
    }

    function global_sound_resize(){
        soundLinear?.kill();
        gsap.set('.header__utils-sound *', { clearProps: 'all' });
        soundLinear = gsap.to('.header__utils-sound .jt-icon svg', { duration: 5, repeat: -1, x: -( document.querySelector('.header__utils-sound .jt-icon svg').getBoundingClientRect().width - document.querySelector('.header__utils-sound-equalizer .jt-icon').offsetWidth ), ease: 'none' });
    }

    document.addEventListener('visibilitychange', () => {
        if( document.visibilityState === 'visible' ){
            if( sound.classList.contains('header__utils-sound--played') ) sound_play();
        } else {
            if( sound.classList.contains('header__utils-sound--played') ) sound_pause( true );
        }
    });

    if( JT.browser('mobile') ){
        screen.orientation.addEventListener('chnage', global_sound_resize);
    } else {
        window.addEventListener('resize', global_sound_resize);
    }

}



// Footer float motion
function footer_float_motion(){

    const float = document.querySelector('.footer__float');

    if( !float ) return;

    footer_float_motion_init();

    function footer_float_motion_init(){

        if( !JT.isScreen(540) ){
            const floatTimeline = gsap.timeline({
                scrollTrigger: {
                    id: 'st-footer-float',
                    trigger: '#footer',
                    scrub: true,
                    start: 'center bottom',
                    end: 'bottom bottom',
                }
            });

            floatTimeline.fromTo('.footer__float-images', { scale: .3, opacity: 0 }, { scale: 1, opacity: 1 });
            floatTimeline.fromTo('.footer__float-btn > a', { autoAlpha: 0 }, { autoAlpha: 1 }, '<=');
        }
    }

    JT.globals.resizes['footer_float_resize'] = () => {
        ScrollTrigger.getById('st-footer-float')?.kill();
        gsap.set('#footer, #footer *', { clearProps: JT.globals.clearPropsList.join(',') });

        footer_float_motion_init();
    }

}



// Footer float sticky scrolltrigger
function footer_float_sticky(){

    const footer = document.querySelector('#footer');
    const sticky = document.querySelector('.footer__float-sticky');

    if( !sticky ) return;

    window.addEventListener('scroll', () => {
        if( JT.isScreen(1023) ){
            let scrollPoint =  window.innerHeight;

            if( window.scrollY < ( document.documentElement.scrollHeight - window.innerHeight - footer.offsetHeight ) ){
                sticky.classList.add('footer__float-sticky--fixed');
            } else {
                sticky.classList.remove('footer__float-sticky--fixed');
                sticky.classList.remove('footer__float-sticky--show');
            }

            if( document.body.classList.contains('introduce-about') ) scrollPoint = ( document.querySelector('.introduce-about__visual').scrollHeight - window.innerHeight );

            if( window.scrollY < ( scrollPoint || window.innerHeight ) ){
                sticky.classList.remove('footer__float-sticky--show');
            } else {
                if( sticky.classList.contains('footer__float-sticky--fixed') ){
                    sticky.classList.add('footer__float-sticky--show');
                }
            }

        }
    });

}



// Footer pull up background fix
function footer_active(){

    footer_active_init();

    function footer_active_init(){

        if( JT.browser('ios') ){
            gsap.timeline({
                scrollTrigger: {
                    id: 'st-footer-active',
                    trigger: '#footer',
                    start:'center bottom',
                    toggleClass: 'footer--active'
                }
            });
        }

    }

    JT.globals.resizes['footer_active_resize'] = () => {
        ScrollTrigger.getById('st-footer-active')?.kill();
        footer_active_init();
    }

}



// Embed video poster click event
function jt_embed_video(){

    document.body.addEventListener('click', ( e ) => {

        const poster = e.target.closest('.jt-embed-video__poster');

        if( !poster ) return;

        const iframe = poster.closest('.jt-embed-video').querySelector('iframe');
        poster.closest('.jt-embed-video').classList.add('jt-embed-video--loading');

        JT.globals.jt_vimeo_ready(() => {
            const video = new Vimeo.Player( iframe );

            video.on('play', () => {
                gsap.to(poster, { duration: .2, autoAlpha: 0, onComplete: () => {
                    poster.closest('.jt-embed-video').classList.remove('jt-embed-video--loading');
                }});
            });

            video.play().catch(() => {
                poster.closest('.jt-embed-video').classList.remove('jt-embed-video--loading');
            });
        });

    });

}



// Tab global event
function jt_tab( target, args ){

    const tab = ( target instanceof HTMLElement ) ? target : document.querySelector( target );

    if( !tab ) return;

    const btns = tab.querySelectorAll('.jt-tab__btn');
    const { scrollTarget = '.jt-tab__btn', speed = 0, callback } = args || {};

    btns.forEach(( btn ) => {

        btn.addEventListener('click', ( e ) => {

            e.preventDefault();
            e.stopPropagation();

            const current = tab.querySelector( btn.getAttribute('href') );

            if( !current || btn.classList.contains('jt-tab--active') ) return;

            tab.querySelector('.jt-tab__btn.jt-tab--active')?.classList.remove('jt-tab--active');

            btn.classList.add('jt-tab--active');

            gsap.to(window, { duration: .4, scrollTo: ( window.scrollY + (( scrollTarget instanceof HTMLElement ) ? scrollTarget : document.querySelector( scrollTarget )).getBoundingClientRect().top - document.querySelector('#header').offsetHeight ), onStart: () => {
                JT.scroll.destroy( true );
            }, onComplete: () => {
                JT.scroll.restore( true );
                JT.globals.minimizeHeader( true );
            } });
            gsap.to(tab.querySelector('.jt-tab__content.jt-tab--active'), { duration: speed, opacity: 0, onComplete: () => {

                tab.querySelector('.jt-tab__content.jt-tab--active .swiper')?.swiper?.destroy();
                tab.querySelector('.jt-tab__content.jt-tab--active').classList.remove('jt-tab--active');

                gsap.set(current, { opacity: 0 });
                current.classList.add('jt-tab--active');

                current.querySelectorAll('[data-unveil]').forEach(( unveil ) => {
                    if( !( unveil instanceof HTMLImageElement ) ){
                        unveil.setAttribute('style', `background-image:url(${ unveil.dataset.unveil });`);
                        unveil.classList.add('jt-lazyload--loaded');
                    } else {
                        unveil.setAttribute('src', unveil.dataset.unveil);
                        unveil.closest('.jt-lazyload').classList.add('jt-lazyload--loaded');
                    }
                });

                imagesLoaded(current, () => {

                    gsap.to(current, { duration: speed, opacity: 1, ease: 'power3.out' });

                    ScrollTrigger.refresh();

                    if( typeof callback === 'function' ) callback.call();

                });

            } });

        });

    });

}



// Popup single/multiple and today close
function jt_popup( target, args ){

    const popup = ( target instanceof HTMLElement ) ? target : document.querySelector( target );

    let isOpen = false;

    if( !popup || isOpen ) return;
    isOpen = true;

    const { openCallback, closeCallback, isMultiple, isMobile } = args || {};

    let popupLength = popup.querySelectorAll('.jt-popup__container').length;
    let closeCount = 0;

    popup.addEventListener('click', close);

    if( isMultiple && !isMobile ){

        popup.querySelectorAll('.jt-popup__container').forEach(( el ) => {
            let x = el.dataset.left || 20;
            let y = el.dataset.top || 20;

            el.style.left = `${ x }rem`;
            el.style.top = `${ y }rem`;

            if( popup.classList.contains('jt-popup--today') && JT.cookies.read(`${ el.id }-today-hide`) ) {
                gsap.set(el, { autoAlpha: 0, display: 'none' });
                closeCount++;
                popup.dataset.popupLength = ( popupLength - closeCount );
            }
        });

        if( closeCount < popupLength ) {
            show();
        } else {
            if( document.body.classList.contains('scroll-fixed') ) scroll_fixed( true );
        }

    } else if( isMobile ){

        popup.classList.add('jt-popup--mobile');

        if( popup.classList.contains('jt-popup--today') ) {
            if( !JT.cookies.read(`${ popup.id }-today-hide`) ){
                init_slider();
            } else {
                if( document.body.classList.contains('scroll-fixed') ) scroll_fixed( true );
            }
        } else {
            init_slider();
        }

    } else {
        show();
    }

    function show(){

        popup.querySelectorAll('[data-unveil]').forEach(( unveil ) => {
            if( !( unveil instanceof HTMLImageElement ) ){
                unveil.setAttribute('style', `background-image:url(${ unveil.dataset.unveil });`);
                unveil.classList.add('jt-lazyload--loaded');
            } else {
                unveil.setAttribute('src', unveil.dataset.unveil);
                unveil.closest('.jt-lazyload').classList.add('jt-lazyload--loaded');
            }
        });

        imagesLoaded(popup, () => {
            gsap.to(popup, { autoAlpha: 1, duration: .3, ease: 'power3.out', onStart: () => {
                scroll_fixed( false );
    
                if( isMobile ) gsap.fromTo(popup.querySelector('.jt-popup__container'), { y: popup.querySelector('.jt-popup__container').offsetHeight }, { y: 0, ease: 'power3.out' });
    
                if( typeof openCallback === 'function' ) openCallback( popup );
            }});
        });

    }

    function close( e ){

        if( e.target.classList.contains('jt-popup') || ( !!e.target.closest('.jt-popup__close') || !!e.target.closest('.jt-popup__today') ) ){

            closeCount++;

            const target = ( isMultiple && !isMobile ) ? e.target.closest('.jt-popup__container') : popup;

            if( !!e.target.closest('.jt-popup__today') && !!target.id ){
                JT.cookies.create(`${ target.id }-today-hide`, 'Y', 1);
            }

            gsap.to(target, { autoAlpha: 0, duration: .2, ease: 'power3.out', onStart: () => {
                if( !isMultiple || isMobile ) {
                    if( !document.body.classList.contains('open-menu') ) scroll_fixed( true );
                }
            }, onComplete: () => {
                if( !isMultiple && !isMobile ) complete();
            }});

            if( isMobile ) gsap.to(popup.querySelector('.jt-popup__container'), { duration: .2, y: popup.querySelector('.jt-popup__container').offsetHeight, ease: 'power3.out', onComplete: complete });

            if( ( isMultiple && !isMobile ) && ( ( closeCount === popupLength ) || e.target.classList.contains('jt-popup') ) ){
                if( !document.body.classList.contains('open-menu') ) scroll_fixed( true );
                 gsap.to(popup, { autoAlpha: 0, duration: .2, ease: 'power3.out', onComplete: complete });
            }

        }
    }

    function complete(){

        popup.classList.remove('jt-popup--mobile');
        gsap.set([ popup, popup.querySelectorAll('*') ], { clearProps: JT.globals.clearPropsList.join(',') });

        popup.querySelectorAll('*').forEach(( child ) => {
            child.scrollTop = 0;
        });

        if( !globalSound.playing() && ( globalSoundVol > 0 ) ) globalSound.play();

        popup.querySelector('.jt-popup__slider')?.swiper?.destroy();

        popup.removeEventListener('click', close);

        if( typeof closeCallback === 'function' ) closeCallback( popup );

        isOpen = false;

    }

    function init_slider(){

        const slider = popup.querySelector('.jt-popup__slider');

        if( ( slider?.querySelectorAll('.swiper-slide').length || 0 ) <= 1 ){
            show();
            return;
        }

        const swiper = new Swiper(slider, {
            init: false,
            loop: true,
            speed: 500,
            preventInteractionOnTransition: true,
            preloadImages: false,
            allowTouchMove: true,
            lazy: {
                loadPrevNext: true,
                loadOnTransitionStart: true
            },
            pagination: {
                el: slider.querySelector('.swiper-pagination'),
                clickable: true,
                renderBullet: ( index, className ) => {
                    return `<span class="${ className }"><i class="sr-only">${ index + 1 }</i></span>`;
                }
            },
            on: {
                init: () => {
                    show();
                }
            }
        });

        swiper.init();

    }
}



// Main visual header class
function main_visual_header(){

    const visual = document.querySelector('.main-visual');
    const header = document.querySelector('#header');

    if( !visual ) return;

    ScrollTrigger.create({
        id: 'st-main-visual-header',
        trigger: visual,
        start: '-1rem top',
        end: 'bottom top',
        onToggle: ( self ) => {
            if( self.isActive ){
                header.classList.add('noborder');
            } else {
                header.classList.remove('noborder');
            }
        }
    });

}



// Main visual intro motion
function main_visual_motion(){

    const visual = document.querySelector('.main-visual__slider');
    const header = document.querySelector('#header');

    if( !visual ) return;

    if( !!sessionStorage.getItem('intro') ){

        gsap.set(header, { y: 0, autoAlpha: 1 });

        slider_first_play();

        if( !!document.querySelector('.main-popup') ){
            JT.isScreen(860) ? jt_popup('.main-popup-mobile', { isMultiple: true, isMobile: true }) : jt_popup('.main-popup', { isMultiple: true });
        }

        return;

    }

    document.body.classList.add('main-visual--running');

    scroll_fixed( false );

    const visualTimeline = gsap.timeline();

    visualTimeline.set(header, { y: -header.offsetHeight, autoAlpha: 0 });
    visualTimeline.fromTo('.main-visual__identity', { autoAlpha: 1 }, { delay: 2, autoAlpha: 0, duration: 1, scale: 0.9, ease: 'power3.out' });
    if( !JT.isScreen(540) ) visualTimeline.fromTo(visual, { borderWidth: '0rem' }, { duration: 1, borderWidth: '20rem', ease: 'power3.out', onComplete: () => { gsap.set('.main-visual__slider', { clearProps: 'borderWidth' }); } }, '<=');
    visualTimeline.fromTo('.main-visual .swiper-controls, .main-visual__overlay, .main-visual__weather', { autoAlpha: 0 }, { duration: 1, autoAlpha: 1, ease: 'power3.out' }, '<=');
    visualTimeline.fromTo(header, { y: -header.offsetHeight, autoAlpha: 0 },{ duration: 1, y: 0, autoAlpha: 1, ease: 'power3.out', onStart: () => {

        document.body.classList.remove('main-visual--running');

        slider_first_play();
        scroll_fixed( true );

        if( !!document.querySelector('.main-popup') ){
            JT.isScreen(860) ? jt_popup('.main-popup-mobile', { isMultiple: true, isMobile: true }) : jt_popup('.main-popup', { isMultiple: true });
        }

    }}, '<=');

    function slider_first_play(){

        if( !visual.swiper || visual.classList.contains('main-visual__slider--single') ){
            slider_video_play( visual );
        } else {
            main_visual_transition( visual );
        }

    }

}



// Main visual slider
function main_visual_slider(){

    const slider = document.querySelector('.main-visual__slider');

    if( !slider ) return;

    if( slider.querySelectorAll('.swiper-slide').length <= 1 ){
        slider.querySelectorAll('.swiper-lazy').forEach(( el ) => { el.style.backgroundImage = 'url(' + el.getAttribute('data-background') + ')'; });

        slider_visibility_observer(slider, 'main-visual-slider');

        slider.querySelectorAll('.jt-background-video__error').forEach(( error ) => {
            error.addEventListener('click', () => {
                slider_video_play( slider );
            });
        });

        slider.classList.add('main-visual__slider--single');

        return;
    }

    let options = {
        init: false,
        loop: false,
        rewind: true, // Video sync fix, only fade mode and disabled loop options required
        speed: 1500,
        preventInteractionOnTransition: true,
        preloadImages: false,
        allowTouchMove: true,
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        lazy: {
            loadPrevNext: true,
            loadOnTransitionStart: true
        },
        navigation: {
            nextEl: slider.querySelector('.swiper-button-next'),
            prevEl: slider.querySelector('.swiper-button-prev')
        },
        pagination: {
            el: slider.querySelector('.swiper-pagination'),
            type: 'fraction',
            renderFraction: ( currentClass, totalClass ) => {
                return `<span class="${ currentClass } jt-typo--16"></span>
                            <i class="swiper-pagination-slug jt-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 12">
                                    <path d="M4.54.81l-4,10a.5.5,0,1,0,.92.38l4-10A.5.5,0,1,0,4.54.81"/>
                                </svg>
                            </i>
                        <span class="${ totalClass } jt-typo--16"></span>`;
            }
        },
        on: {
            init: () => {

                slider_visibility_observer(slider, 'main-visual-slider');

                slider.querySelectorAll('.jt-background-video__error').forEach(( error ) => {
                    error.addEventListener('click', () => { main_visual_transition( slider ); });
                });

            },
            realIndexChange: () => {

                main_visual_transition( slider );

            }
        }
    }

    let swiper = new Swiper(slider, options);

    swiper.init();

}



// Main visual resize
function main_visual_resize(){

    const slider = document.querySelector('.main-visual__slider');

    if( !slider ) return;

    let resizePoint = JT.isScreen(540) ? 540 : JT.isScreen(860) ? 860 : 0;
    let canResize = false;

    JT.globals.resizes['main_visual_resize'] = () => {

        if( JT.isScreen(540) && ( resizePoint !== 540 ) ){
            resizePoint = 540;
            canResize = true;
        }

        if( JT.isScreen(860) && ( resizePoint !== 860 ) ){
            resizePoint = 860;
            canResize = true;
        }

        if( !JT.isScreen(860) && ( resizePoint !== 0 ) ){
            resizePoint = 0;
            canResize = true;
        }

        if( canResize ){
            if( slider?.swiper ){
                main_visual_transition( slider );
            } else {
                slider_video_play( slider );
            }

            canResize = false;
        }

    }

}



// Main visual transition
function main_visual_transition( slider ){

    slider_video_play(slider, {
        isAutoplay: true,
        changeSpeed: 1500,
        changeDelay: 5000
    });

}



// Main connect motion
function main_connect_motion(){

    const connect = document.querySelector('.main-connect');

    if( !connect ) return;

    let items = gsap.utils.toArray('.main-connect .main-section__title, .main-connect .main-section__desc > *, .main-connect .main-section__more');

    // Init
    main_connect_init();

    function main_connect_init(){

        items.map(( item, idx ) => {
            gsap.set(item, { opacity: 0, rotation: 0.1, y: ( JT.isScreen(860) ? 20 : 40 ) });
            ScrollTrigger.create({
                id: `st-main-connect-${ idx }`,
                trigger: item,
                start: 'top 80%',
                once: true,
                onEnter: () => {
                    gsap.to(item, { duration: 1, opacity: 1, rotation: 0, y: 0, force3D: true, ease: 'power1.out' });
                },
            });
        });

    }

    JT.globals.resizes['main_connect_resize'] = () => {
        items.map(( _, idx ) => {
            ScrollTrigger.getById(`st-main-connect-${ idx }`)?.kill();
        });
        gsap.set('.main-connect *', { clearProps: 'all' });
        main_connect_init();
    }

}



// Gallery preview popup init
function main_preview_popup(){
    
    const trigger = document.querySelector('.main-garden__preview');

    if( !trigger ) return;

    trigger.addEventListener('click', ( e ) => {
        e.preventDefault();
        e.stopPropagation();

        jt_popup('.main-korea-preview-popup', {
            openCallback: ( popup ) => {
                const src = popup.querySelector('.jt-popup__embed').dataset.src;
                const iframe = document.createElement('iframe');
        
                iframe.setAttribute('src', src);
                iframe.setAttribute('title', '');
                iframe.setAttribute('allowFullscreen', true);
                iframe.setAttribute('allow', 'autoplay; fullscreen; picture-in-picture');
        
                popup.querySelector('.jt-embed-video__inner').append( iframe );
        
                sound_with_iframe( iframe );
        
                JT.globals.jt_vimeo_ready(() => {
                    const video = new Vimeo.Player( iframe );
                    const poster = popup.querySelector('.jt-embed-video__poster');
        
                    poster.closest('.jt-embed-video').classList.add('jt-embed-video--loading');
        
                    video.on('play', () => {
                        gsap.to(poster, { duration: .2, autoAlpha: 0, onComplete: () => {
                            popup.querySelector('.jt-embed-video').classList.remove('jt-embed-video--loading');
                        }});
                    });
        
                    video.play().catch(() => {
                        popup.querySelector('.jt-embed-video').classList.remove('jt-embed-video--loading');
                    });
                });
            },
            closeCallback: ( popup ) => {
                popup.querySelector('.jt-embed-video__inner').innerHTML = '';
            }
        });
    });
    
}



// Main garden motion
function main_garden_motion(){

    const garden = document.querySelector('.main-garden');

    if( !garden || JT.browser('mobile') ) return;

    garden_scroll_motion_init();

    function garden_scroll_motion_init(){

        garden.querySelectorAll('.main-garden__section').forEach(( section, idx ) => {
            let gardenTimeline = gsap.timeline({
                scrollTrigger: {
                    id: `st-main-garden-${ idx }`,
                    trigger: section,
                    pin: true,
                    scrub: true,
                    start: 'top top',
                    end: '50%',
                }
            });
            gardenTimeline.to({}, { duration: .5 });
        });

    }

    JT.globals.resizes['main_garden_resize'] = () => {
        garden.querySelectorAll('.main-garden__section').forEach(( _, idx ) => ScrollTrigger.getById(`st-main-garden-${ idx }`)?.kill());
        gsap.set('.main-garden, .main-garden *', { clearProps: JT.globals.clearPropsList.join(',') });

        garden_scroll_motion_init();
    }

}



// Main construct motion
function main_construct_motion(){

    const construct = document.querySelector('.main-construct');

    if( !construct ) return;

    document.querySelectorAll('.main-construct__anchor').forEach(( anchor ) => {

        anchor.addEventListener('click', ( e ) => {

            e.preventDefault();
            e.stopPropagation();

        });

        anchor.addEventListener('mouseenter', () => {

            const image = document.querySelector( anchor.getAttribute('href') );

            if( !image ) return;

            document.querySelector('.main-construct__anchor--active')?.classList.remove('main-construct__anchor--active');
            anchor.classList.add('main-construct__anchor--active');

            document.querySelector('.main-construct__image--active')?.classList.remove('main-construct__image--active');
            image.classList.add('main-construct__image--active');

        });

    });

}



// Main director motion
function main_director_motion(){

    const director = document.querySelector('.main-director');
    const container = document.querySelector('.main-director__container');

    if( !director ) return;

    director_scroll_motion_init();

    function director_scroll_motion_init(){

        gsap.set(container, { height: container.scrollHeight });

        gsap.timeline({
            scrollTrigger: {
                id: 'st-main-director',
                trigger: director,
                pin: '.main-director__sticky',
                start: 'top top',
                end: 'bottom bottom',
                onLeave: () => {
                    if( !JT.isScreen(860) ) gsap.to('.main-director__sticky', { duration: .3, autoAlpha: 0 });
                },
                onEnterBack: () => {
                    if( !JT.isScreen(860) ) gsap.to('.main-director__sticky', { duration: .3, autoAlpha: 1 });
                },
                onUpdate: ( self ) => {
                    if( JT.isScreen(860) ){
                        if( self.progress < 1 ){
                            gsap.to(director.querySelector('.main-section__more'), { duration: .3, autoAlpha: 0 });
                        } else {
                            gsap.to(director.querySelector('.main-section__more'), { duration: .3, autoAlpha: 1 });
                        }
                    }
                }
            }
        });

    }

    JT.globals.resizes['main_director_resize'] = () => {
        ScrollTrigger.getById('st-main-director')?.kill();
        gsap.set('.main-director, .main-director *', { clearProps: JT.globals.clearPropsList.join(',') });

        director_scroll_motion_init();
    }

}



// Sub visual slider
function sub_visual_slider(){

    const slider = document.querySelector('.jt-sub-visual');

    if( !slider ) return;

    if( slider.querySelectorAll('.swiper-slide').length <= 1 ){
        slider.querySelectorAll('.swiper-lazy').forEach((el) => { el.style.backgroundImage = 'url(' + el.getAttribute('data-background') + ')'; });
        return;
    }

    const swiper = new Swiper(slider, {
        init: false,
        loop: true,
        speed: 1500,
        preloadImages: false,
        centeredSlides: true,
        allowTouchMove: false,
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        lazy: {
            loadPrevNext: true,
            loadOnTransitionStart: true
        },
        autoplay: {
            delay: 3000,
        },
        on: {
            init: () => {

            },
        }
    });

    swiper.init();


}



// Garden korea scroll motion
function garden_korea_scroll_motion(){

    const section = document.querySelector('.garden-korea-motion');

    if( !section ) return;

    garden_korea_scroll_init();

    function garden_korea_scroll_init(){
        gsap.timeline({
            scrollTrigger: {
                id: 'st-garden-korea-scroll',
                trigger: section,
                pin: '.garden-korea-motion__sticky',
                scrub: true,
                start: 'top top',
            }
        });
    }

    JT.globals.resizes['garden_korea_scroll_resize'] = () => {
        ScrollTrigger.getById('st-garden-korea-scroll')?.kill();
        gsap.set('.garden-korea-motion, .garden-korea-motion *', { clearProps: JT.globals.clearPropsList.join(',') });

       garden_korea_scroll_init();
    }

}



// Gallery tab event
function garden_korea_gallery_tab(){

    const gallery = document.querySelector('.garden-korea-gallery');

    if( !gallery ) return;

    let slider = gallery.querySelector('.jt-tab__content.jt-tab--active .garden-korea-gallery__slider');
    let resizePoint = JT.isScreen(540) ? 540 : 0;
    let canResize = false;

    garden_korea_gallery_slider( slider );

    jt_tab(gallery, {
        callback: () => {
            const tab = gallery.querySelector('.garden-korea-gallery__tab');
            const currentTab = gallery.querySelector('.jt-tab__btn.jt-tab--active');
            const currentContent = gallery.querySelector('.jt-tab__content.jt-tab--active');

            let moveX = ( currentTab.getBoundingClientRect().left + ( currentTab.offsetWidth / 2 ) + tab.scrollLeft - ( window.innerWidth / 2 ) );

            gsap.to(tab, { duration: .4, scrollTo: { x: ( moveX || 0 ) }, ease: 'power3.out' });

            gallery.querySelectorAll('video').forEach(( video ) => {

                if( !video.paused ){
                    video.pause();
                    video.currentTime = 0;
                }

            });

            slider = currentContent.querySelector('.garden-korea-gallery__slider');

            garden_korea_gallery_slider( slider );
        }
    });

    JT.globals.resizes['garden_korea_gallery_resize'] = () => {

        if( JT.isScreen(540) && ( resizePoint !== 540 ) ){
            resizePoint = 540;
            canResize = true;
        }

        if( !JT.isScreen(540) && ( resizePoint !== 0 ) ){
            resizePoint = 0;
            canResize = true;
        }

        if( canResize ){
            slider = gallery.querySelector('.jt-tab__content.jt-tab--active .garden-korea-gallery__slider');
            slider?.swiper?.destroy();

            garden_korea_gallery_slider( slider );

            canResize = false;
        }
    }

}



// Gallery slider
function garden_korea_gallery_slider( slider ){

    if( !slider || slider?.swiper ) return;

    let changeSpeed = JT.isScreen(540) ? 1000 : 1500;

    gsap.set(slider, { opacity: 0 });

    if( slider.querySelectorAll('.swiper-slide').length <= 1 ){

        slider.querySelectorAll('.swiper-lazy').forEach(( el ) => { el.style.backgroundImage = 'url(' + el.getAttribute('data-background') + ')'; });

        slider_visibility_observer(slider, 'garden-korea-gallery-slider');
        slider_video_play( slider );

        slider.querySelectorAll('.jt-background-video__error').forEach(( error ) => {
            error.addEventListener('click', () => {
                slider_video_play( slider );
            });
        });

        gsap.set(slider, { duration: .3, opacity: 1 });

        return;
    }

    const swiper = new Swiper(slider, {
        init: false,
        loop: true,
        speed: changeSpeed,
        preventInteractionOnTransition: true,
        slidesPerView: 'auto',
        centeredSlides: true,
        preloadImages: false,
        lazy: {
            loadPrevNext: true,
            loadOnTransitionStart: true
        },
        navigation: {
            nextEl: slider.querySelector('.swiper-button-next'),
            prevEl: slider.querySelector('.swiper-button-prev')
        },
        on: {
            init: () => {

                slider_visibility_observer(slider, 'garden-korea-gallery-slider');
                slider_video_play(slider);

                slider.querySelectorAll('.jt-background-video__error').forEach(( error ) => {
                    error.addEventListener('click', () => {
                        slider_video_play(slider);
                    });
                });

                gsap.to(slider, { duration: .3, opacity: 1 });
            },
            realIndexChange: () => {
                slider_video_play(slider, { changeSpeed: changeSpeed });
            },
        }
    });

    swiper.init();

}



// Introduce about visual scroll motion
function introduce_about_visual(){

    const visual = document.querySelector('.introduce-about__visual');

    if( !visual ) return;

    introduce_about_visual_init();

    function introduce_about_visual_init(){

        let visualTimeline = gsap.timeline({
            scrollTrigger: {
                id: 'st-introduce-about-visual',
                trigger: '.introduce-about__visual-sticky',
                pin: true,
                scrub: true,
                start: 'top top',
                end: `+=500%`,
                onUpdate: ( self ) => {
                    const backgrounds = Array.from( document.querySelectorAll('.introduce-about__visual-bg') ).filter(( background ) => {
                        return is_visible( background );
                    });
                    gsap.set(backgrounds[0], { y: -( ( backgrounds[0]?.scrollHeight - window.innerHeight ) * self.progress ) });
                }
            }
        });

        visualTimeline.addLabel('step1');
        visualTimeline.to('.introduce-about__visual-section--01', { opacity: 0, y: '-100%', ease: 'none' }, 'step1');
        visualTimeline.to('.introduce-about__visual-scrolldown', { duration: .2, opacity: 0, ease: 'none' }, 'step1');
        visualTimeline.fromTo('.introduce-about__visual-section--02', { opacity: 0 }, { opacity: 1, y: '-100%', ease: 'none' }, 'step1');

        visualTimeline.addLabel('step2');
        visualTimeline.to('.introduce-about__visual-section--02', { opacity: 0, y: '-200%', ease: 'none' }, 'step2');
        visualTimeline.fromTo('.introduce-about__visual-section--03', { opacity: 0 }, { opacity: 1, y: '-100%', ease: 'none' }, 'step2');

        visualTimeline.addLabel('step3');
        visualTimeline.to('.introduce-about__visual-section--03', { opacity: 0, y: '-200%', ease: 'none' }, 'step3');
        visualTimeline.fromTo('.introduce-about__visual-epilogue', { opacity: 0 }, { opacity: 1, duration: .2, ease: 'none' }, 'step3');

        visualTimeline.addLabel('step4');
        visualTimeline.fromTo('.introduce-about__visual-title', { opacity: 0, y: 40 }, { opacity: 1, y: 0, duration: .2, ease: 'none' }, 'step4');
        visualTimeline.fromTo('.introduce-about__visual-epilogue-backdrop', { opacity: 0 }, { opacity: 1, duration: .2, ease: 'none' }, 'step4');
        visualTimeline.to('.introduce-about__visual-epilogue', { delay: .1 }, 'step4');

    }

    JT.globals.resizes['introduce_about_visual_resize'] = () => {
        ScrollTrigger.getById('st-introduce-about-visual')?.kill();
        gsap.set('.introduce-about__visual, .introduce-about__visual *', { clearProps: JT.globals.clearPropsList.join(',') });

        introduce_about_visual_init();
    }

}



// Introduce about identity scroll motion
function introduce_about_identity(){

    const identity = document.querySelector('.introduce-about__identity');

    if( !identity ) return;

    introduce_about_identity_init();

    function introduce_about_identity_init(){

        const backgrounds = Array.from( document.querySelectorAll('.introduce-about__identity-bg') ).filter(( background ) => {
            return is_visible( background );
        });

        let identityTimeline = gsap.timeline({
            scrollTrigger: {
                id: 'st-introduce-about-indentity',
                trigger: identity,
                start: 'top 25%',
                toggleActions: 'play none none reverse'
            }
        });

        identityTimeline.fromTo('.introduce-about__identity-backdrop', { opacity: 0 }, { duration: .7, opacity: 1, ease: 'power3.out' });
        identityTimeline.fromTo('.introduce-about__identity-inner', { opacity: 0, y: 40 }, { duration: .7, opacity: 1, y: 0, ease: 'power3.out' }, '<=');

        gsap.to(backgrounds[0], {
            y: -( ( backgrounds[0]?.scrollHeight - identity.offsetHeight ) > 0 ? ( backgrounds[0]?.scrollHeight - identity.offsetHeight ) : 0 ),
            scrollTrigger: {
                id: 'st-introduce-about-indentity-bg',
                trigger: backgrounds[0],
                scrub: true,
                start: 'top bottom',
                ease: 'none',
                end: `bottom+=${ identity.offsetHeight }`
            }
        });

    }

    JT.globals.resizes['introduce_about_identity_resize'] = () => {
        ScrollTrigger.getById('st-introduce-about-indentity')?.kill();
        ScrollTrigger.getById('st-introduce-about-indentity-bg')?.kill();
        gsap.set('.introduce-about__identity, .introduce-about__identity *', { clearProps: JT.globals.clearPropsList.join(',') });

        introduce_about_identity_init();
    }

}



// Introduce people gallery tab event
function introduce_people_gallery_tab(){

    const gallery = document.querySelector('.introduce-people-gallery');

    if( !gallery ) return;

    jt_tab(gallery, {
        callback: () => {
            const tab = gallery.querySelector('.introduce-people-gallery__tab');
            const currentTab = gallery.querySelector('.jt-tab__btn.jt-tab--active');

            let moveX = ( currentTab.getBoundingClientRect().left + ( currentTab.offsetWidth / 2 ) + tab.scrollLeft - ( window.innerWidth / 2 ) );

            gsap.to(tab, { duration: .4, scrollTo: { x: ( moveX || 0 ) }, ease: 'power3.out' });
        }
    });

}



// Introduce people appeal motion
function introduce_people_appeal(){

    const appeal = document.querySelector('.introduce-people-appeal');

    if( !appeal ) return;

    let appealTimeline = gsap.timeline({
        scrollTrigger: {
            id: 'st-introduce-people-appeal',
            trigger: appeal,
            start: 'top 30%',
            toggleActions: 'play none none reverse'
        }
    });

    appealTimeline.fromTo('.introduce-people-appeal__content', { opacity: 0 }, { opacity: 1, duration: .7 });
    appealTimeline.fromTo('.introduce-people-appeal__content > *', { y: 40 }, { y: 0, duration: .7 }, '<=');

}



// Introduce people popup
function introduce_people_popup(){

    const gallery = document.querySelector('.introduce-people-gallery');
    const inner   = document.querySelector('.introduce-people-popup .jt-popup__container-inner');

    if( !gallery ) return;

    gallery.addEventListener('click', async ( e ) => {

        if( e.target.closest('.introduce-people-gallery__item') ){
            e.preventDefault();
            e.stopPropagation();

            const res = await fetch( e.target.closest('.introduce-people-gallery__item > a').href );

            if( res.status === 200 ){

                const html = await res.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const content = doc.querySelector('.introduce-people-popup__data');

                inner.innerHTML = content.innerHTML;

                jt_popup('.introduce-people-popup', {
                    openCallback: ( popup ) => {
                        const iframe = popup.querySelector('iframe');
                        sound_with_iframe( iframe );
                    },
                    closeCallback: () => {
                        inner.innerHTML = '';
                    }
                });

                return;

            }
        }

    });

}



// Introduce history scroll motion
function introduce_history_scroll(){

    const history = document.querySelector('.introduce-history-lounge');
    const stickys = document.querySelectorAll('.introduce-history-lounge__sticky-item');
    const lists   = document.querySelectorAll('.introduce-history-lounge__list');

    if( !history ) return;

    introduce_history_scroll_init();

    function introduce_history_scroll_init(){

        if( !JT.isScreen(860) ){
            stickys.forEach(( sticky, idx ) => {
                gsap.to(sticky, { duration: .01, autoAlpha: ( idx > 0 ) ? 1 : 0, scrollTrigger: {
                    st: `st-introduce-history-lounge-${ idx }`,
                    trigger: ( idx > 0 ) ? lists[ idx ] : lists[ idx + 1 ],
                    start: 'top 30%',
                    end: ( idx > 0 && idx < ( stickys.length - 1 ) ) ? 'top 30%' : 'bottom top',
                    endTrigger: ( idx > 0 && idx < ( stickys.length - 1 ) ) ? lists[ idx + 1 ] : lists[ idx ],
                    toggleActions: `play ${ ( idx > 0 && idx < ( stickys.length - 1 ) ) ? 'reverse play' : 'none none' } reverse`,
                }});
            });
        }

    }

    JT.globals.resizes['introduce_history_scroll_resize'] = () => {
        stickys.forEach(( _, idx ) => {
            ScrollTrigger.getById(`st-introduce-history-lounge-${ idx }`)?.kill();
        });

        gsap.set('.introduce-history-lounge, .introduce-history-lounge *', { clearProps: JT.globals.clearPropsList.join(',') });

        introduce_history_scroll_init();
    }

}



// Introduce history hover effect
function introduce_history_hover(){

    const items = document.querySelectorAll('.introduce-history-lounge__sublist > li');
    const image =  document.querySelector('.introduce-history-lounge__sticky-image-inner');

    let clone = null;

    items.forEach(( item ) => {

        item.addEventListener('mouseenter', () => {
            if( !JT.isScreen(860) ){
                if( item.querySelector('img') ){

                    clone = item.querySelector('img').cloneNode();
                    clone.src = clone.dataset.unveil;

                    image.innerHTML = '';
                    image.appendChild( clone );

                    clone.onload = () => {
                        gsap.set(image, { top: `calc(50% - ${ clone.height / 2 }rem)`, onComplete: () => {
                            gsap.to(clone, { opacity: 1, duration: .3, ease: 'power3.out' });
                        }});
                    }
                }
            }
        });

        item.addEventListener('mouseleave', () => {
            if( !JT.isScreen(860) ){
                if( clone ){
                    gsap.to(clone, { opacity: 0, duration: .3, ease: 'power3.out' });
                }
            }
        });

    });

}



// Construct visual scroll motion
function construct_visual_scroll(){

    const visual = document.querySelector('.construct-visual');

    if( !visual ) return;

    const sections = visual.querySelectorAll('.construct-visual__section');

    if( sections.length <= 1 ) return;

    construct_visual_init();

    function construct_visual_init(){

        let visualTimeline = gsap.timeline({
            scrollTrigger: {
                id: 'st-construct-visual',
                trigger: visual,
                pin: true,
                scrub: true,
                start: 'top top',
                end: `${ 100 * sections.length * 1.2 }%`,
            }
        });

        sections.forEach(( section, idx ) => {

            // Iphone 15 pro Safari address bar top position issue fix
            gsap.set(section, { height: section.getBoundingClientRect().height });

            if( idx > 0 ){
                visualTimeline.to(sections, { delay: .5 });
                visualTimeline.to(sections[ idx - 1 ], { y: `-=${ section.getBoundingClientRect().height / 2 }`, duration: 1 });
                visualTimeline.to(section, { y: -( section.getBoundingClientRect().height ), duration: 1 }, '<=');
                visualTimeline.fromTo(section.querySelector('.construct-visual__content'), { opacity: 0 }, { opacity: 1 });
            }

        });

    }

    JT.globals.resizes['construct_visual_resize'] = () => {
        ScrollTrigger.getById('st-construct-visual')?.kill();
        gsap.set('.construct-visual, .construct-visual *', { clearProps: JT.globals.clearPropsList.join(',') });

        construct_visual_init();
    }

}



// Construct seongok seowon intro scroll motion
function construct_seongok_seowon_intro(){

    const intro = document.querySelector('.construct-seongok-seowon__intro');

    if( !intro ) return;

    construct_seongok_seowon_intro_init();

    function construct_seongok_seowon_intro_init(){

        gsap.fromTo('.construct-seongok-seowon__intro-bg', { clipPath: 'inset(0% 36.83%)' }, {
            clipPath: 'inset(0% 0%)',
            ease: 'none',
            scrollTrigger: {
                id: 'st-construct-seongok-seowon-intro',
                trigger: '.construct-seongok-seowon__intro-bg',
                scrub: true,
                start: 'top bottom',
                end: 'center center',
            }
        });

    }

    JT.globals.resizes['construct_seongok_seowon_intro_resize'] = () => {
        ScrollTrigger.getById('st-construct-seongok-seowon-intro')?.kill();
        gsap.set('.construct-seongok-seowon__intro, .construct-seongok-seowon__intro *', { clearProps: JT.globals.clearPropsList.join(',') });

        construct_seongok_seowon_intro_init();
    }

}



// Contruct seongok seowon director image loaded and marquee init
function construct_seongok_seowon_director(){

    const gallery = document.querySelector('.construct-seongok-seowon__director-gallery');

    if( !gallery ) return;

    jt_marquee('.construct-seongok-seowon__director-marquee');

    JT.globals.resizes['construct_seongok_seowon_director_resize'] = () => {
        jt_marquee_destroy('.construct-seongok-seowon__director-marquee');
        jt_marquee('.construct-seongok-seowon__director-marquee');
    }

}



// Google map init
function google_map_init(){

    const mapEl = document.querySelector('.jt-map');

    if( !mapEl ) return;

    if( !( 'google' in window ) ){
        // Load google map api
        (g=>{var h,a,k,p='The Google Maps JavaScript API',c='google',l='importLibrary',q='__ib__',m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement('script'));e.set('libraries',[...r]+'');for(k in g)e.set(k.replace(/[A-Z]/g,t=>'_'+t[0].toLowerCase()),g[k]);e.set('callback',c+'.maps.'+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+' could not load.'));a.nonce=m.querySelector('script[nonce]')?.nonce||'';m.head.append(a)}));d[l]?console.warn(p+' only loads once. Ignoring:',g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
            key: 'AIzaSyBuDRd36AhxkT5fn_q0I2lYDfqkXAdylcM', // Medongaule key
            region: 'KR',
            language: document.documentElement.lang || 'ko',
            // Add other bootstrap parameters as needed, using camel case.
            // Use the 'v' parameter to indicate the version to load (alpha, beta, weekly, etc.)
        });
    }

    async function init_map(){

        try {

            const { Map } = await google.maps.importLibrary('maps');
            const mapPosition = new google.maps.LatLng(mapEl.dataset.lat, mapEl.dataset.lng);
            const mapZoom = parseInt( mapEl.dataset.zoom || 10 );

            let map = new Map(mapEl, {
                center: mapPosition,
                zoom: mapZoom,
                zoomControl: JT.browser('desktop'),
                scrollWheel: false,
                mapTypeControl: false,
                streetViewControl: false,
                gestureHandling: 'none',
                mapId: 'af5e039d7824172c' // Medongaule mapId
            });

            // Marker
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
            const markerEl = document.createElement('div');

            markerEl.className = 'jt-custom-marker';
            markerEl.innerHTML = `<span class="jt-custom-marker__identity">
                                      <i class="jt-icon">
                                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25">
                                              <title>메덩골</title>
                                              <path d="M20.8,12.5a6.25,6.25,0,1,0-8.3-8.28A6.25,6.25,0,1,0,4.21,12.5a6.25,6.25,0,1,0,8.29,8.29,6.25,6.25,0,1,0,8.3-8.29ZM13.09,6.83a5.08,5.08,0,1,1,5.08,5.08H13.09Zm5.08,16.42a5.09,5.09,0,0,1-5.08-5.08V13.09h5.08a5.08,5.08,0,0,1,0,10.16Zm-6.26-5.08a5.08,5.08,0,1,1-5.08-5.08h5.08ZM6.83,1.75a5.09,5.09,0,0,1,5.08,5.08v5.08H6.83a5.08,5.08,0,0,1,0-10.16Z"/>
                                          </svg>
                                      </i>
                                  </span>
                                  <i class="jt-custom-marker__chevron"></i>`;

            let marker = new AdvancedMarkerElement({
                map: map,
                position: mapPosition,
                content: markerEl,
            });

            imagesLoaded(mapEl, () => {
                setTimeout(() => {
                    mapEl.classList.add('jt-map--init');
                }, 700);
            });

        } catch( err ) {
            // Error
        }


    }

    init_map();

}



// Manual location traffig tab init
function manual_location_traffic_tab(){

    const traffic = document.querySelector('.menual-location-traffic');

    if( !traffic ) return;

    jt_tab(traffic, {
        scrollTarget: '.menual-location-traffic__container',
        callback: () => {
            const tab = traffic.querySelector('.menual-location-traffic__tab');
            const currentTab = traffic.querySelector('.jt-tab__btn.jt-tab--active');

            let moveX = ( currentTab.getBoundingClientRect().left + ( currentTab.offsetWidth / 2 ) + tab.scrollLeft - ( window.innerWidth / 2 ) );

            gsap.to(tab, { duration: .4, scrollTo: { x: ( moveX || 0 ) }, ease: 'power3.out' });
        }
    });

}



// Manual service gallery mobile marquee
function manual_service_gallery(){

    const gallery = document.querySelector('.maunal-service-gallery') ;

    if( !gallery ) return;

    if( JT.isScreen(860) ){
        jt_marquee('.maunal-service-gallery__list');
    }

    JT.globals.resizes['manual_service_gallery_resize'] = () => {
        jt_marquee_destroy('.maunal-service-gallery__list');

        if( JT.isScreen(860) ){
            jt_marquee('.maunal-service-gallery__list');
        }
    }

}



// Category event init
function jt_category(){

    const category = document.querySelector('.jt-category');

    if( !category ) return;

    const current = category.querySelector('.jt-category--current');
    let moveX = ( current.getBoundingClientRect().left + ( current.offsetWidth / 2 ) + current.scrollLeft - ( window.innerWidth / 2 ) );
    gsap.set(category, { opacity: 0, scrollTo: { x: ( moveX || 0 ) }, ease: 'power3.out', onComplete: () => {
        gsap.set(category, { opacity: 1 });
    }});

    category.querySelectorAll('a').forEach(( category ) => {

        category.addEventListener('click', ( e ) => {
            e.preventDefault();
            e.stopPropagation();

            try {
                barba.go( e.currentTarget.href, `filter ${ document.body.classList[0] || '' }` );
            } catch ( e ) {
                location.href = e.currentTarget.href;
            }
        });

    });

}



// Reservation comingsoon popup
function reservation_comingsoon_popup(){

    const triggers = document.querySelectorAll('.header__utils-reserve, .footer__float-btn a, .footer__float-sticky');

    triggers.forEach(( trigger ) => {
        trigger.addEventListener('click', ( e ) => {
            if( trigger.getAttribute('href').startsWith('#') ){
                e.preventDefault();
                e.stopPropagation();

                jt_popup('.reservation-comingsoon-popup');
            }
        });
    });

}



// Accordion init
function jt_accordion() {

    const accordion = document.querySelector('.jt-accordion');
    let isRun = false;

    if( !accordion ) return;

    accordion.addEventListener('click', ( e ) => {

        if( e.target.closest('.jt-accordion__head') ) {

            e.preventDefault();
            e.stopPropagation();

            const item = e.target.closest('.jt-accordion__item');

            if( isRun ) return;
            isRun = true;

            if( !e.target.closest('.jt-accordion--active') && accordion.querySelector('.jt-accordion--active') ){
                JT.slide.up(accordion.querySelector('.jt-accordion--active .jt-accordion__content-inner'), 500, () => { isRun = false; });
                accordion.querySelector('.jt-accordion--active').classList.remove('jt-accordion--active');
            }

            item.classList.toggle('jt-accordion--active');

            JT.slide.toggle( item.querySelector('.jt-accordion__content-inner'), 500, () => { isRun = false; });

        }

    });

}



// Anchor scroll move
function jt_anchor(){

    const anchor = document.querySelector('.jt-anchor');

    if( !anchor ) return;

    const btns  = document.querySelectorAll('.jt-anchor__btn');
    const items = document.querySelectorAll('.jt-anchor__item');

    let currentClass = 'jt-anchor--current';
    let isRun = false;

    items.forEach(( item, idx ) => {

        gsap.timeline({
            scrollTrigger: {
                id: `st-sub-anchor-${ idx + 1 }`,
                trigger: item,
                start: 'top 5rem',
                end: 'bottom 5rem',
                onToggle: ( self ) => {

                    if( isRun ) return;

                    if( self.isActive ){
                        const curr = Array.from( btns ).find(( btn ) => {
                            return btn.getAttribute('href') === `#${ self.trigger.id }`;
                        });
                        curr.classList.add( currentClass );
                    } else {
                        if( ( ( idx === 0 ) && ( self.direction < 0 ) ) || ( ( idx === ( items.length - 1 ) ) && ( self.direction > 0 ) ) ) return;

                        const curr = Array.from( btns ).find(( btn ) => {
                            return btn.getAttribute('href') === `#${ self.trigger.id }`;
                        });
                        curr.classList.remove( currentClass );
                    }
                }
            }
        });

    });

    if( !anchor.classList.contains('jt-anchor--init') ){

        btns.forEach(( btn ) => {

            btn.addEventListener('click', ( e ) => {
                e.preventDefault();
                e.stopPropagation();

                if( btn.getAttribute('href') !== '#' ){
                    const curr = document.querySelector( btn.getAttribute('href') );

                    if( curr ){
                        gsap.to(window, { duration: .4, scrollTo: curr.getBoundingClientRect().top + window.scrollY, ease: 'power3.out', onStart: () => {
                            JT.scroll.destroy( true );
                            anchor.querySelector(`.${ currentClass }`)?.classList.remove( currentClass );
                            btn.classList.add( currentClass );
                            isRun = true;
                        }, onComplete: () => {
                            JT.scroll.restore( true );
                            JT.globals.minimizeHeader( true );
                            isRun = false;
                        }});

                        return;
                    }
                }
            });

        });

        anchor.classList.add('jt-anchor--init');

    }

}



// Marquee init
function jt_marquee( target, args ){

    const selectors = document.querySelectorAll( target );

    const { speed = 50 } = args || {};

    selectors.forEach(( selector, idx ) => {

        let marqueeEndpoint = null;
        let originHtml      = selector.outerHTML;

        // Init class
        selector.classList.add('jt-marquee');

        if( !selector.querySelectorAll('.jt-marquee__items').length ){
            selector.innerHTML = `<div class="jt-marquee__items">${ selector.innerHTML }</div>`;
        }

        const item         = selector.querySelector('.jt-marquee__items');
        const selectorSize = selector.offsetWidth;
        const itemSize     = item.offsetWidth;
        const itemLength   = Math.ceil( selectorSize / itemSize ) + 1;
        const loopDuration = ( itemSize / speed ) - ( idx * 2 );

        if( isNaN( itemSize ) || ( itemSize === 0 ) ) return;

        item.querySelectorAll('.jt-lazyload').forEach(( lazy ) => {
            const img = lazy.querySelector('img');

            img.setAttribute('src', img.dataset.unveil);
            img.classList.add('jt-lazyload--loaded');
            lazy.classList.add('jt-lazyload--loaded');
        });

        if( !selector.querySelectorAll('.jt-marquee__inner').length ){
            selector.innerHTML = `<div class="jt-marquee__inner">${ selector.innerHTML }</div>`;
        }

        const marquee = selector.querySelector('.jt-marquee__inner');

        if( selector.querySelectorAll('.jt-marquee__items').length < itemLength ){
            let limit = ( itemLength - ( selector.querySelectorAll('.jt-marquee__items').length - 1 ) );
            for( let i = 0; i < limit; i++ ){
                let clone = item.cloneNode( true );
                marquee.appendChild( clone );
            }
        }

        if( ( idx % 2 == 0 ) ) {
            gsap.set( marquee, { x: -itemSize } );
            marqueeEndpoint = -( itemSize * 2 );
        } else {
            gsap.set( marquee, { x: -( itemSize * 2 ) } );
            marqueeEndpoint = 0;
        }

        // Kill animation
        let currIndex = marqueeList.findIndex(( obj ) => ( obj.selector === selector ));

        if( currIndex >= 0 ){
            if( marqueeList[currIndex] ) {
                marqueeList[currIndex].timeline.kill();
                marqueeList[currIndex].observer.unobserve( selector );
                gsap.set( marquee, { clearProps: 'all' } );
            }
        } else {
            currIndex = marqueeList.length;
            marqueeList[currIndex] = { selector: selector, originHtml: originHtml }
        }

        // Init animation
        marqueeList[currIndex] = { ...marqueeList[currIndex], timeline: gsap.timeline({ repeat: -1, paused: true }) };

        marqueeList[currIndex].timeline.to( marquee, { duration: 0, x: -itemSize, ease: 'none' });
        marqueeList[currIndex].timeline.to( marquee, { duration: loopDuration, x: marqueeEndpoint, ease: 'none' });

        if( selector.classList.contains('jt-marquee--play') ){
            marqueeList[currIndex].timeline.play();
        }

        marqueeList[currIndex].observer = new IntersectionObserver(( entries ) => {
            entries.forEach(( entry ) => {
                if( entry.isIntersecting ){
                    entry.target.classList.add('jt-marquee--play');
                    entry.target.classList.remove('jt-marquee--pause');
                    marqueeList[currIndex].timeline.play();
                } else {
                    entry.target.classList.add('jt-marquee--pause');
                    entry.target.classList.remove('jt-marquee--play');
                    marqueeList[currIndex].timeline.pause();
                }
            });
        });

        marqueeList[currIndex].observer.observe( selector );

    });

}



// MARQUEE DESTROY
function jt_marquee_destroy( target ){

    const selectors = document.querySelectorAll( target );

    selectors.forEach(async ( selector, idx ) => {

        const marquee = selector.querySelector('.jt-marquee__inner');

        if( !marquee ) return;

        // Clear class
        selector.classList.remove('jt-marquee');

        // Kill animation
        let currIndex = marqueeList.findIndex(( obj ) => ( obj.selector === selector ));

        if( currIndex >= 0 ){
            if( marqueeList[currIndex] ) {
                await reset().then(() => {
                    document.querySelectorAll( target )[idx].querySelectorAll('[data-unveil]').forEach(( image ) => {
                        new JtLazyload(image, 300, () => {
                            image.addEventListener('load', () => {
                                if( image.closest('.jt-lazyload') != null ) {
                                    image.closest('.jt-lazyload').classList.add('jt-lazyload--loaded');
                                } else {
                                    image.classList.add('jt-lazyload--loaded');
                                }
                            });
                        });
                    });
                });
            }
        }

        function reset(){
            return new Promise(( resolve ) => {
                selector.outerHTML = marqueeList[currIndex].originHtml;

                marqueeList[currIndex].timeline.kill();
                marqueeList[currIndex].observer.disconnect();
                marqueeList.splice(currIndex, 1);

                resolve();
            });
        }

    });
}



// Search filter select change event
function jt_search_filter(){

    const filters = document.querySelectorAll('.jt-filter__sort select');
    const checkboxs = document.querySelectorAll('.jt-filter input[type="checkbox"]');
    const pickers = document.querySelectorAll('.jt-filter__picker a');

    filters.forEach(( select ) => {
        select.addEventListener('change', ( e ) => {
            try {
                barba.go( e.currentTarget.value, `filter ${ document.body.classList[0] || '' }` );
            } catch ( e ) {
                location.href = e.currentTarget.value;
            }
        });
    });

    checkboxs.forEach(( checkbox ) => {

        checkbox.addEventListener('change', () => {

            const url = new URL(location.href);
            const search = new URLSearchParams();

            let searchUrl = ( url.origin + url.pathname );
            let parames = {};

            for( const [key, value] of url.searchParams.entries() ){
                if( key !== 'page' ){
                    parames[key] = value;
                    search.append(key, value);
                }
            }

            if( checkbox.checked ){
                parames[checkbox.name] = checkbox.value;
                search.append(checkbox.name, checkbox.value);
            } else {
                search.delete(checkbox.name);
            }

            searchUrl += ((search.size > 0) ? `?${search.toString()}` : '');

            try {
                barba.go( searchUrl, `filter ${ document.body.classList[0] || '' }` );
            } catch ( e ) {
                location.href = searchUrl;
            }


        });

    });

    pickers.forEach(( picker ) => {

        picker.addEventListener('click', ( e ) => {
            e.preventDefault();
            e.stopPropagation();

            try {
                barba.go( e.currentTarget.href, `filter ${ document.body.classList[0] || '' }` );
            } catch ( e ) {
                location.href = e.currentTarget.href;
            }
        });

    });

}



// Policy vercion select change event
function jt_single_select(){

    const selects = document.querySelectorAll('.jt-single__select select');

    selects.forEach(( select ) => {
        select.addEventListener('change', ( e ) => {
            try {
                barba.go( e.currentTarget.value, `filter ${ document.body.classList[0] || '' }` );
            } catch ( e ) {
                location.href = e.currentTarget.value;
            }
        });
    });

}



// Single table mobile scroll
function jt_single_scale(){

    const tables = document.querySelectorAll('.jt-single__content table');

    tables.forEach(( table, idx ) => {

        let width;

        if( document.body.classList.contains('manual-visitor-guide') ){
            return;
        }

        if( document.body.classList.contains('manual-policy-privacy') ){
            width = 860;
        }

        table_horizontal_scroll( table, width, idx );

    });

}



// Register agreement
function jt_agreement(){

    const agreement = document.querySelector('.jt-agreement');

    if( !agreement ) return;

    agreement.querySelector('.jt-agreement--all input[type="checkbox"]').addEventListener('click', ( e ) => {

        if( e.currentTarget.checked ){

            agreement.querySelectorAll('input[type="checkbox"]').forEach(( checkbox ) => {
                checkbox.checked = true;
            });

        } else {

            agreement.querySelectorAll('input[type="checkbox"]').forEach(( checkbox ) => {
                checkbox.checked = false;
            });

        }

    });

    agreement.querySelectorAll('input[type="checkbox"]').forEach(( checkbox ) => {

        checkbox.addEventListener('change', () => {

            let allChecked = true;

            agreement.querySelectorAll('input[type="checkbox"]').forEach(( check ) => {
                if( !check.closest('.jt-agreement--all') && !check.checked ) allChecked = false;
            });

            agreement.querySelector('.jt-agreement--all input[type="checkbox"]').checked = allChecked;

        });

    });


}



// Register agreement popup
function jt_agreement_popup(){

    const agreements = document.querySelectorAll('.jt-agreement__more');

    agreements.forEach(( agreement ) => {

        agreement.addEventListener('click', async ( e ) => {
            e.preventDefault();
            e.stopPropagation();

            const res = await fetch( agreement.href );

            if( res.status === 200 ){

                const html = await res.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const title = doc.querySelector('.jt-single__title');
                const content = doc.querySelector('.jt-single__body');
                const inner = document.querySelector('.jt-agreement-popup .jt-popup__container-inner');

                const resultHtml = `<h2 class="jt-agreement-popup__title jt-typo--03">${ title.innerText }</h2>\n
                                ${ content.innerHTML }`;

                inner.innerHTML = resultHtml;

                inner.querySelectorAll('table').forEach(( table, idx ) => {
                    table_horizontal_scroll(table, 860, idx);
                });

                jt_popup('.jt-agreement-popup', {
                    openCallback: () => {
                        JT.globals.minimizeHeader( true );
                    },
                    closeCallback: () => {
                        inner.innerHTML = '';

                        Object.keys( JT.globals.resizes ).map(( key ) => {
                            if( key.startsWith('table_horizontal_scroll_resize') ){
                                delete JT.globals.resizes[ key ];
                            }
                        });

                        JT.globals.minimizeHeader( false );
                    }
                });

                return;

            }
        });

    });

}



// Resercation result scroll mode
function reservation_result_scroll(){

    const result = document.querySelector('.jt-reservation .jt-reservation__result');

    if( !result ) return;

    result.addEventListener('mouseenter', () => {
        if( ( result.querySelector('.jt-reservation__result-content-inner').offsetHeight < result.querySelector('.jt-reservation__result-content-inner').scrollHeight ) && JT.smoothscroll.enabled ){
            JT.smoothscroll.destroy();
        }
    });

    result.addEventListener('mouseleave', () => {
        if( !JT.smoothscroll.enabled ) JT.smoothscroll.init();
    });

}



// Reservation useable qr code popup
function reservation_useable_popup(){

    const triggers = document.querySelectorAll('.jt-reservation__action--useable');

    let qrcode;
    let popup = document.querySelector('.reservation-qrcode-popup');

    if( !popup ) return;

    if( !!triggers.length ){
        popup.querySelector('.reservation-qrcode__image').innerHTML = '';
        qrcode = new QRCode('qr-code', {
            width: 90 * ( window.devicePixelRatio || 1 ),
            height: 90 * ( window.devicePixelRatio || 1 ),
            correctLevel: QRCode.CorrectLevel.L
        });
    }

    triggers.forEach(( trigger ) => {
        trigger.addEventListener('click', async ( e ) => {
            e.preventDefault();
            e.stopPropagation();

            const code = trigger.dataset.code || '';
            const make = () => new Promise(( resolve ) => {
                qrcode?.makeCode( code );

                popup.querySelector('.reservation-qrcode--code span').innerText = code;
                popup.querySelector('.reservation-qrcode--date span').innerText = trigger.closest('.jt-reservation__result').querySelector('.jt-reservation__result--date span').innerText;
                popup.querySelector('.reservation-qrcode--time span').innerText = trigger.closest('.jt-reservation__result').querySelector('.jt-reservation__result--time span').innerText;
                popup.querySelector('.reservation-qrcode--visitor span').innerText = trigger.closest('.jt-reservation__result').querySelector('.jt-reservation__result--visitor span').innerText;
                
                resolve();
            });

            if( qrcode ){
                await make();
                jt_popup( popup );
            }

        });
    });

}



// Reservation QR Code maker
function reservation_qrcode(){

    const el = document.querySelector('.reservation-qrcode__image');

    if( !el || el.closest('.reservation-qrcode-popup') ) return;

    const code = el.dataset.code || '';
    const qrcode = new QRCode('qr-code', {
        width: 90 * ( window.devicePixelRatio || 1 ),
        height: 90 * ( window.devicePixelRatio || 1 ),
        correctLevel: QRCode.CorrectLevel.L
    });

    qrcode.makeCode( code );

}



// Main scenery slider init
function main_scenery_slider(){
    
    const slider = document.querySelector('.main-scenery__slider');
    const pagination = document.querySelector('.main-scenery__pagination');

    if( !slider || !pagination ) return;
    if( slider.querySelectorAll('.swiper-slide').length <= 1 ){
        slider.querySelectorAll('.swiper-lazy').forEach(( el ) => { el.style.backgroundImage = 'url(' + el.getAttribute('data-background') + ')'; });
        jt_scenery_popup();
        return;
    }
    
    const swiperPagination = new Swiper(pagination, {
        init: false,
        loop: true,
        speed: 750,
        preventInteractionOnTransition: true,
        slidesPerView: 5,
        centeredSlides: true,
        allowTouchMove: false,
        on: {
            init: () => {
                pagination.querySelectorAll('.swiper-slide').forEach(( slide ) => {
                    slide.addEventListener('click', () => {
                        if( swiperSlider.animating ) return;

                        if( slide.classList.contains('swiper-slide-next') ){
                            swiperPagination.slideNext();
                            swiperSlider.slideNext();
                        } else if( slide.classList.contains('swiper-slide-prev') ){
                            swiperPagination.slidePrev();
                            swiperSlider.slidePrev();
                        }
                    });
                });
            }
        }
    });

    const swiperSlider = new Swiper(slider, {
        init: false,
        rewind: true,
        speed: 1000,
        preventInteractionOnTransition: true,
        preloadImages: false,
        effect: 'fade',
        autoplay: {
            delay: 5000,
            pauseOnMouseEnter: true,
            disableOnInteraction: false
        },
        fadeEffect: {
            crossFade: true
        },
        lazy: {
            loadPrevNext: true,
            loadOnTransitionStart: true
        },
        on: {
            init: () => {
                jt_scenery_popup();
            },
            realIndexChange: ( swiper ) => {
                if( swiper.swipeDirection === 'next' ){
                    swiperPagination.slideNext();
                } else if( swiper.swipeDirection === 'prev' ) {
                    swiperPagination.slidePrev();
                }
            },
        }
    });

    swiperPagination.init();
    swiperSlider.init();
}



// Board scenery popup init
function jt_scenery_popup(){

    const triggers = document.querySelectorAll('.jt-board__scenery-popup');
    const slider = document.querySelector('.jt-scenery-popup__slider');
    const images = [];

    triggers.forEach(( trigger, index ) => {

        images.push( trigger.href );

        trigger.addEventListener('click', ( e ) => {
            e.preventDefault();
            e.stopPropagation();

            jt_popup('.jt-scenery-popup', {
                openCallback: () => {
                    JT.globals.minimizeHeader( true );
                    popup_slider_change( images, index );
                },
                closeCallback: () => {
                    JT.globals.minimizeHeader( false );
                }
            });

            return;

        });

    });

    function popup_slider_change( images, index = 0 ){

        if( !slider ) return;

        // Reset
        slider.swiper?.destroy();
        slider.querySelector('.swiper-wrapper').innerHTML = '';

        images.forEach(( image ) => {

            const slide = document.createElement('div');
            slide.classList.add('jt-scenery-popup__item', 'swiper-slide');
            slide.innerHTML = `<div class="jt-scenery-popup__image">
                                  <img src="${ image }" alt="" />
                              </div>`;
            
            slider.querySelector('.swiper-wrapper').appendChild( slide );

        });

        if( slider.querySelectorAll('.swiper-slide').length <= 1 ){
            slider.querySelectorAll('.swiper-lazy').forEach(( el ) => { el.style.backgroundImage = 'url(' + el.getAttribute('data-background') + ')'; });
            gsap.set(slider, { opacity: 1 });
            return;
        }

        const swiper = new Swiper(slider, {
            init: false,
            rewind: true,
            speed: 1500,
            autoHeight: true,
            preventInteractionOnTransition: true,
            preloadImages: false,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            lazy: {
                loadPrevNext: true,
                loadOnTransitionStart: true
            },
            navigation: {
                nextEl: slider.querySelector('.swiper-button-next'),
                prevEl: slider.querySelector('.swiper-button-prev')
            },
            on: {
                init: () => {
                    slider.swiper.slideTo(index, 0);
                }
            }
        });
    
        imagesLoaded(slider, () => {
            swiper.init();
        });

    }

}



// Disable context menu
function disable_contextmenu(){

    document.addEventListener('contextmenu', ( e ) => e.preventDefault());

}



/* **************************************** *
 * HELPER
 * **************************************** */
/**
 * 스크롤 방지 처리
 *
 * @version 1.0.0
 * @author STUDIO-JT (JSH)
 * @requires jt.js
 * @requires layout.css
 * @description 스크롤트리거 disable/enable 함께 처리되어야함
 */
function scroll_fixed( enable ) {

    let scrollStorage = Math.abs( parseInt( getComputedStyle( document.body ).top ) || window.scrollY );

    if( enable ){
        document.body.classList.remove('scroll-fixed');
        JT.scroll.restore( true );

        if( JT.browser('ios') ){
            ScrollTrigger.getAll().forEach(( st ) => {
                st.enable( false );
            });

            ScrollTrigger.refresh();

            gsap.set(window, { scrollTo: scrollStorage, onComplete: () => { gsap.set('body', { clearProps: 'top' }) }});
        }

    } else {

        if( JT.browser('ios') ){
            scrollStorage = window.scrollY;
            gsap.set('body', { top: `-${ scrollStorage }px` })

            ScrollTrigger.getAll().forEach(( st ) => {
                st.disable( false, true );
            });
        }

        document.body.classList.add('scroll-fixed');
        JT.scroll.destroy( true );
    }
}



/**
 * JT.scroll.disalbedEvent 오버라이드
 *
 * @version 1.0.0
 * @author STUDIO-JT (JSH)
 * @requires jt.js
 * @requires jt-strap.css
 * @requires layout.css
 * @description 스크롤이 필요한 모달의 경우, 스크롤이 가능하도록 처리
 */
function scroll_disable_helper(){

    JT.scroll.disabledEvent = ( event ) => {
        if( !event.target.closest('.jt-popup') && !event.target.closest('#menu') ){
            event.preventDefault();
        } else {
            let scrollHeight = ( event.target.closest('.jt-popup') || event.target.closest('#menu') ).scrollHeight;
            let maxHeight = window.innerHeight;

            if( !!event.target.closest('.jt-popup__container-inner') ){
                scrollHeight = event.target.closest('.jt-popup__container-inner').scrollHeight;
                maxHeight = event.target.closest('.jt-popup__container').offsetHeight;
            }

            if( !!event.target.closest('#menu') ){
                maxHeight = event.target.closest('#menu').offsetHeight;
            }

            if( scrollHeight <= maxHeight ){
                event.preventDefault();
            }
        }
    }

}



/**
 * 뷰포트 높이 체크 (카카오 웹뷰)
 *
 * @version 1.0.0
 * @author STUDIO-JT (JSH)
 */
function full_height(){

    // Kakao browser scrolltrigger pin issue fix
    if( JT.browser('kakao') ){
        document.documentElement.style.setProperty('--fit-height', `${ window.innerHeight }px`);
        document.documentElement.style.setProperty('--full-height', `${ screen.height }px`);
    }

}



/**
 * Video lazyload + inview autoplay
 *
 * @version 1.0.0
 * @author STUDIO-JT (KMS)
 * @requires gsap.min.js
 * @requires ScrollTrigger.min.js
 * @see {@link https://greensock.com/docs/|GreenSock Docs}
 */
function autoplay_inview(){

    const targets = document.querySelectorAll('.jt-autoplay-inview');

    let observers = [];

    targets.forEach( ( target, idx ) => {

        // Autoplay trigger
        const observer = new IntersectionObserver(( entries ) => {
                            
            entries.forEach(( entry ) => {

                let videos = [];

                if( entry.isIntersecting ){
                    videos = Array.from( target.querySelectorAll('video') ).filter(( video ) => {
                        return is_visible( video );
                    });

                    videos.forEach(( video ) => {
                        let poster = video.closest('.jt-autoplay-inview').querySelector('.jt-background-video__poster');

                        if( video.readyState === 4 && video.paused && target.classList.contains('jt-autoplay--loaded') ) {
                            video.play().then(() => {
                                target.classList.remove('jt-autoplay-inview--paused');
                                target.classList.add('jt-autoplay-inview--play');

                                if( !!poster ) gsap.to(poster, { delay: ( JT.browser('kakao') ? .4 : 0 ), duration: .2, autoAlpha: 0, onComplete: () => { poster.style.display = 'none'; } });
                            });
                        } else {
                            video.load();
                            video.play().then(() => {

                                target.classList.remove('jt-autoplay-inview--paused');
                                target.classList.add('jt-autoplay-inview--play');

                                if( !!poster ) gsap.to(poster, { delay: ( JT.browser('kakao') ? .4 : 0 ), duration: .2, autoAlpha: 0, onComplete: () => { poster.style.display = 'none'; } });
                            }).catch(() => {
                                if( !!poster ){
                                    const error = poster.querySelector('.jt-background-video__error');
                                    gsap.to(error, { autoAlpha: 1, duration: .2 });

                                    if( !!error ){
                                        error.addEventListener('click', () => {
                                            if( video.readyState === 4 && video.paused && target.classList.contains('jt-autoplay--loaded') ) {
                                                video.play().then(() => {
                                                    target.classList.remove('jt-autoplay-inview--paused');
                                                    target.classList.add('jt-autoplay-inview--play');
                    
                                                    if( !!poster ) gsap.to(poster, { duration: .2, autoAlpha: 0, onComplete: () => { poster.style.display = 'none'; } });
                                                });
                                            }
                                        });
                                    }
                                }
                            });
                            target.classList.add('jt-autoplay--loaded');
                        }
                    });
                } else {
                    videos = target.querySelectorAll('video');

                    videos.forEach(( video ) => {
                        if( video.readyState === 4 && !video.paused && target.classList.contains('jt-autoplay--loaded') ) {
                            target.classList.remove('jt-autoplay-inview--play');
                            target.classList.add('jt-autoplay-inview--paused');
                            video.pause();
                        }
                    });
                }
            });

        });

        observer.observe( target );
        observers.push( observer );

        function visibility_change(){
            let videos = Array.from( target.querySelectorAll('video') ).filter(( video ) => {
                return is_visible( video );
            });
            
            if( document.visibilityState === 'visible' ){
                videos.forEach(( vid ) => {
                    if( vid.readyState === 4 && vid.paused && target.classList.contains('jt-autoplay-inview--play') ) {
                        vid.play();
                    }
                });
            } else {
                videos.forEach(( vid ) => {
                    if( vid.readyState === 4 && !vid.paused && target.classList.contains('jt-autoplay-inview--play') ) {
                        vid.pause();
                    }
                });
            }
        }

        globalObserver.push( observer );
        JT.globals.visibilityChanges[`autoplay_inview_visibility_change_${ idx }`] = visibility_change;

    });

    JT.globals.resizes[`autoplay_inview_resize`] = () => {

        observers.forEach(( observer ) => {
            globalObserver = globalObserver.filter(item => item !== observer);
        });

        for( let idx = 0; idx < targets.length; idx++ ){
            document.removeEventListener('visibilitychange', JT.globals.visibilityChanges[`autoplay_inview_visibility_change_${ idx }`]);
            delete JT.globals.visibilityChanges[`autoplay_inview_visibility_change_${ idx }`];
        }

        autoplay_inview();

    }

}



/**
 * 슬라이더 비디오 재생/일시정지 뷰포트 옵저버
 *
 * @version 1.0.0
 * @author STUDIO-JT (JSH)
 * @requires swiper-bundle.min.js
 * @requires swiper-bundle.min.css
 * @requires jt-strap.css
 *
 * @example
 * slider_visibility_observer(
 *     slider, // 슬라이더 엘리먼트
 *     id      // 고유 아이디
 * )
 */
function slider_visibility_observer( slider, id = '' ){

    if( slider.classList.contains('jt-observer--enable') ) return;

    slider.classList.add('jt-observer--enable');

    const observer = new IntersectionObserver(( entries ) => {
        entries.forEach(( entry ) => {

            let videos = [];

            if( entry.isIntersecting ){
                if( !!entry.target?.swiper ){
                    videos = Array.from( entry.target.querySelectorAll('.swiper-slide-active video, .swiper-slide-duplicate-active video') ).filter(( video ) => {
                        return is_visible( video );
                    });
                } else {
                    videos = Array.from( entry.target.querySelectorAll('video') ).filter(( video ) => {
                        return is_visible( video );
                    });
                }
                videos.forEach(( video ) => {
                    if( video.readyState === 4 && video.paused && video.closest('.jt-background-video').classList.contains('jt-background-video--loaded') ) {
                        video.play().then(() => {
                            video.closest('.jt-background-video').classList.remove('jt-background-video--paused');
                            video.closest('.jt-background-video').classList.add('jt-background-video--played');
                        });
                    }
                });
            } else {
                videos = entry.target.querySelectorAll('video');

                videos.forEach(( video ) => {
                    if( video.readyState === 4 && !video.paused && video.closest('.jt-background-video').classList.contains('jt-background-video--loaded') ) {
                        video.closest('.jt-background-video').classList.remove('jt-background-video--played');
                        video.closest('.jt-background-video').classList.add('jt-background-video--paused');
                        video.pause();
                    }
                });
            }
        });
    });

    observer.observe( slider );

    function visibility_change(){

        let videos = [];

        if( !!slider?.swiper ){
            videos = Array.from( slider.querySelectorAll('.swiper-slide-active video') ).filter(( video ) => {
                return is_visible( video );
            });
        } else {
            videos = Array.from( slider.querySelectorAll('video') ).filter(( video ) => {
                return is_visible( video );
            });
        }

        if( document.visibilityState === 'visible' ){
            videos.forEach(( video ) => {
                if( video.readyState === 4 && video.paused && video.closest('.jt-background-video').classList.contains('jt-background-video--played') ) {
                    video.play();
                }
            });
        } else {
            videos.forEach(( video ) => {
                if( video.readyState === 4 && !video.paused && video.closest('.jt-background-video').classList.contains('jt-background-video--played') ) {
                    video.pause();
                }
            });
        }
    }

    globalObserver.push( observer );
    JT.globals.visibilityChanges[`slider_visibility_change_${ id }`] = visibility_change;
}



/**
 * 슬라이더 비디오 플레이/정지/싱크로 헬퍼
 *
 * @version 1.0.0
 * @author STUDIO-JT (JSH)
 * @requires gsap.min.js
 * @requires swiper-bundle.min.js
 * @requires swiper-bundle.min.css
 * @requires jt-strap.css
 *
 * @example
 * slider_video_play(slider, { // 슬라이더 엘리먼트
 *     isAutoplay: true,  // 오토플레이 여부
 *     changeSpeed: 1000, // 슬라이드 트렌지션 속도 Millisecond
 *     changeDelay: 5000  // 슬라이드 잔류 시간 Millisecond
 * })
 */
function slider_video_play( slider, args ){

    const swiper = slider.swiper;
    const { isAutoplay, changeSpeed, changeDelay } = args || {};

    let curr = null;
    let prev = null;
    let isSingle = false;

    if( !swiper ){
        curr = slider.querySelector('.swiper-slide');
        isSingle = true;
    } else {
	    curr = swiper.slides[swiper.activeIndex];
	    prev = swiper.slides[swiper.previousIndex];
    }

    if( prev?.querySelector('video') && !!Array.from( prev.querySelectorAll('video') ).filter(( video ) => { return is_visible( video ); }).length ){

        let prevIndex = prev.dataset.swiperSlideIndex;
        let prevSlides = !isNaN( prevIndex ) ? slider.querySelectorAll(`.swiper-slide[data-swiper-slide-index='${ prevIndex }']`) : [ prev ];

        prevSlides.forEach(( slide ) => {

            const prevVideo = Array.from( slide.querySelectorAll('video') ).filter(( video ) => {
                if( !video.paused ) video.pause();
                return is_visible( video );
            });

            const prevPoster = Array.from( slide.querySelectorAll('.swiper-lazy') ).filter(( poster ) => {
                return is_visible( poster );
            });

            if( !!prevVideo.length ){
                prevVideo[0].closest('.jt-background-video').classList.add('jt-background-video--paused');
                prevVideo[0].closest('.jt-background-video').classList.remove('jt-background-video--played');

                if( !prevVideo[0].paused ) prevVideo[0].pause();

                if( changeSpeed ){
                    const progress = { counter: 0 };

                    gsap.fromTo(progress, {
                        counter: 0
                    }, {
                        counter: 1,
                        duration: parseFloat( changeSpeed / 1000 ),
                        ease: 'none',
                        onComplete: () => {
                            if( !!prevPoster.length ){
                                gsap.to(prevPoster[0], { duration: .2, autoAlpha: 1, onComplete: () => {
                                    prevVideo[0].currentTime = 0;
                                }});
                            } else {
                                prevVideo[0].currentTime = 0;
                            }
                        }
                    });
                }
            }
        });
    }

    if( curr?.querySelector('video') && !!Array.from( curr.querySelectorAll('video') ).filter(( video ) => { return is_visible( video ); }).length ){
        let currIndex = curr.dataset.swiperSlideIndex;
        let currSlides = isSingle ? slider.querySelectorAll('.swiper-slide') : ( !isNaN( currIndex ) ? slider.querySelectorAll(`.swiper-slide[data-swiper-slide-index='${ currIndex }']`) : [ curr ] );

        // Once run
        if( swiper && isAutoplay && !isSingle ){
            slider_progress( swiper, changeDelay );
        }

        currSlides.forEach(( slide ) => {

            const currVideo = Array.from( slide.querySelectorAll('video') ).filter(( video ) => {
                if( !video.paused ) video.pause();
                return is_visible( video );
            });

            const currPoster = Array.from( slide.querySelectorAll('.swiper-lazy') ).filter(( poster ) => {
                return is_visible( poster );
            });

            if( !!currVideo.length ){
                if( currVideo[0].readyState !== 4 ){
                    currVideo[0].load();
                    currVideo[0].addEventListener('load', video_canplay);
                    currVideo[0].addEventListener('canplaythrough', video_canplay);
                } else {
                    video_canplay();
                }
            }

            function video_canplay(){
                currVideo[0].removeEventListener('load', video_canplay);
                currVideo[0].removeEventListener('canplaythrough', video_canplay);

                currVideo[0].currentTime = 0;
                currVideo[0].play().then(() => {

                    currVideo[0].closest('.jt-background-video').classList.add('jt-background-video--played');
                    currVideo[0].closest('.jt-background-video').classList.remove('jt-background-video--paused');

                    if( !!currPoster[0] ){
                        gsap.to(currPoster[0], { duration: .2, autoAlpha: 0 });
                    }

                    // Overwrite run
                    if( swiper && isAutoplay && !isSingle ){
                        if( curr === swiper.slides[swiper.activeIndex] ){
                            slider_progress(swiper, ( currVideo[0].duration - currVideo[0].currentTime ) * 1000);
                        } else {
                            currVideo[0].currentTime = 0;
                            currVideo[0].pause();
                        }
                    }

                    if( isSingle ){
                        currVideo[0].addEventListener('ended', () => {
                            currVideo[0].currentTime = 0;
                            currVideo[0].play();
                        });
                    }
                }).catch(() => {
                    if( !!currPoster[0] ){
                        const error = currPoster[0].querySelector('.jt-background-video__error');
                        gsap.to(error, { autoAlpha: 1, duration: .2 });
                    }
                });

                currVideo[0].closest('.jt-background-video').classList.add('jt-background-video--loaded');
            }
        });

    } else {

        if( swiper && isAutoplay && !isSingle ){
            slider_progress( swiper, changeDelay );
        }

    }

}



/**
 * 슬라이더 오토플레이 프로그레스
 *
 * @version 1.0.0
 * @author STUDIO-JT (JSH)
 * @requires gsap.min.js
 * @requires swiper-bundle.min.js
 * @requires swiper-bundle.min.css
 *
 * @example
 * slider_progress(
 *     swiper,  // Swiper 객체
 *     duration // Millisecond
 * )
 */
function slider_progress( swiper, duration = 5000 ){
    const progress = { counter: 0 };

    sliderProgress?.kill();

    sliderProgress = gsap.fromTo(progress, {
        counter: 0
    }, {
        counter: 1,
        duration: parseFloat( duration / 1000 ),
        ease: 'none',
        onComplete: () => {
            if( !swiper.destroyed ) swiper.slideNext();
        }
    });

}



/**
 * 비메오 플레이어와 백그라운드 사운드 상호작용
 *
 * @version 1.0.0
 * @author STUDIO-JT (JSH)
 * @requires jt.js
 * @requires howler.core.js
 *
 * @example
 * sound_with_iframe( iframe ) // Iframe 엘리먼트
 */
function sound_with_iframe( iframe ){

    if( !iframe ) return;

    JT.globals.jt_vimeo_ready(() => {
        const video = new Vimeo.Player( iframe );

        if( video ){
            video.on('play', () => {
                if( globalSound.playing() && globalSoundVol > 0 ){
                    globalSoundVol = globalSound._volume;
                    globalSound.pause();
                }
            });

            video.on('pause', () => {
                if( !globalSound.playing() && globalSoundVol > 0 ){
                    globalSound.play();
                }
            });
        }
    });

}



/**
 * 요소가 보여지고 있는지 체크 ( element.checkVisibility 대용 )
 *
 * @version 1.0.0
 * @author STUDIO-JT (JSH)
 * @see {@link https://developer.mozilla.org/en-US/docs/Web/API/Element/checkVisibility|Element: checkVisibility() method}
 *
 * @example
 * is_visible( element ) // 체크할 엘리먼트
 */
function is_visible( element ){

    return !!( element.offsetWidth || element.offsetHeight || element.getClientRects().length );

}



/**
 * 디바이스 가로/세로 체크
 *
 * @version 1.0.0
 * @author STUDIO-JT (JSH)
 * @requires jt.js
 *
 * @example
 * is_orientation( type ) // 'portrait' 또는 'landscape'
 */
function is_orientation( type ){
    let isPortrait = JT.browser('mobile') ? ( screen.orientation.type.startsWith('portrait') ) : ( window.innerWidth <= window.innerHeight );

    if( type === 'portrait' ){
        return isPortrait;
    } else if( type === 'landscape' ){
        return !isPortrait;
    }

    return false;
}



/**
 * 모바일 테이블 스크롤러
 *
 * @version 1.0.0
 * @author STUDIO-JT (JSH)
 * @requires jt.js
 * @requires rwd-strap.css
 *
 * @example
 * table_horizontal_scroll(
 *     table, // 테이블 엘리먼트
 *     width, // 테이블 가로 크기
 *     idx    // 고유 번호
 * )
 */
function table_horizontal_scroll( table, width, idx ){

    if( !table ) return;

    let isInit = false;

    load();

    function init(){
        const wrapper = document.createElement('div');

        wrapper.classList.add('jt-single__table-scroller', `jt-single__table-scroller--${ idx }`);

        table.parentElement.insertBefore(wrapper, table);
        table.style.width = `${ !!width ? width : 468 }rem`;

        wrapper.appendChild(table);
    }

    function load(){

        if( JT.isScreen(540) && !isInit ){
            init();
            isInit = true;
        } else if( !JT.isScreen(540) && isInit ){
            destroy();
        }

    }

    function destroy(){

        table.removeAttribute('style');

        if( !!table.closest('.jt-single__table-scroller') ){
            table.closest('.jt-single__table-scroller').replaceWith(...table.closest('.jt-single__table-scroller').childNodes);
        }

        isInit = false;

    }

    function resize(){
        setTimeout(load, 100);
    }

    JT.globals.resizes[`table_horizontal_scroll_resize_${ idx }`] = resize;

    if( JT.browser('mobile') ){
        screen.orientation.addEventListener('change', resize);
    } else {
        window.addEventListener('resize', resize);
    }

}



/**
 * 윈도우 팝업
 *
 * @version 1.0.0
 * @author STUDIO-JT (JSH)
 * @requires jt.js
 *
 * @example
 * jt_popup_win(url, {
 *     title:  string, // 팝업 타이틀
 *     width:  number, // 팝업 가로 사이즈
 *     height: number, // 팝업 세로 사이즈
 *     left:   number, // 팝업 x 좌표
 *     top:    number, // 팝업 y 좌표
 * })
 */
function jt_popup_win( url, args ){

    const {
        title = '',
        width = 480,
        height = 800,
        left = (screen.availLeft + ((screen.availWidth - width) / 2)),
        top = (screen.availTop + ((screen.availHeight - height) / 2)),
    } = args || {};

    const option = `status=no, menubar=no, toolbar=no, resizable=no, width=${width}, height=${height}, left=${left}, top=${top}`;

    const popup = window.open(url, title, option);

    if( !popup ){
        JT.confirm({
            message: '팝업 차단 기능이 설정되어 있습니다. <br />해제 후 이용하시기 바랍니다.'
        });

        return;
    }

    return popup;

}



})();
