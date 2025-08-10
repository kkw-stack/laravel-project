<div class="jt-pagination">
    <div class="jt-pagination__inner">
        @if($paginator->hasPages())
            @php
            $page_cnt = 5;
            $current_page = $paginator->currentPage();
            $total_page = ceil($paginator->total() / $paginator->perPage());
            $separator  = floor( $page_cnt / 2 );
            $paging     = '';
            $arr_page   = range( $current_page - $separator, $current_page + $separator );
            $arr_page   = array_filter( $arr_page, function ( $val ) use( $total_page ) { return $val > 0 && $val <= $total_page; } );

            if($arr_page){
                while( count( $arr_page) < $page_cnt ) {
                    if ( max( $arr_page ) + 1 <= $total_page ) {
                        $arr_page[] = max( $arr_page ) + 1;
                    } else {
                        break;
                    }
                }

                while( count( $arr_page) < $page_cnt ) {
                    if ( min( $arr_page ) - 1 > 0 ) {
                        $arr_page[] = min( $arr_page ) - 1;
                    } else {
                        break;
                    }
                }
                sort( $arr_page );
            }
            @endphp

            @if(!$paginator->onFirstPage())
                <div class="jt-pagination__prev">
                    <a href="{{ $paginator->url(1) }}" class="jt-pagination__first-btn">
                        <span class="sr-only">{!! __('front.ui.first-page') !!}</span>
                        <i class="jt-icon">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M11.41,10,14.7,6.71a1,1,0,1,0-1.4-1.42L8.59,9.94l4.7,4.76a1,1,0,1,0,1.42-1.4Z"/>
                                <path d="M6,5A1,1,0,0,0,5,6v8a1,1,0,0,0,2,0V6A1,1,0,0,0,6,5Z"/>
                            </svg>
                        </i><!-- .jt-icon -->
                    </a><!-- .jt-pagination__first-btn -->
                    <a href="{{ $paginator->previousPageUrl() }}" class="jt-pagination__prev-btn">
                        <span class="sr-only">{!! __('front.ui.prev-page') !!}</span>
                        <i class="jt-icon">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.41,10,12.7,6.71a1,1,0,1,0-1.4-1.42L6.59,9.94l4.7,4.76a1,1,0,1,0,1.42-1.4Z"/>
                            </svg>
                        </i><!-- .jt-icon -->
                    </a><!-- .jt-pagination__prev-btn -->
                </div><!-- .jt-pagination__prev -->
            @endif

            <div class="jt-pagination__number">
                @foreach($arr_page as $page)
                    @if($page == $paginator->currentPage())
                        <a class="jt-pagination--current"><span class="jt-typo--15">{{ $page }}</span></a>
                    @else
                        <a href="{{ $paginator->url($page) }}"><span class="jt-typo--15">{{ $page }}</span></a>
                    @endif
                @endforeach
            </div><!-- .jt-pagination__number -->

            @if($paginator->hasMorePages())
                <div class="jt-pagination__next">
                    <a href="{{ $paginator->nextPageUrl() }}" class="jt-pagination__next-btn">
                        <span class="sr-only">{!! __('front.ui.next-page') !!}</span>
                        <i class="jt-icon">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M8.7,5.29A1,1,0,1,0,7.3,6.71L10.59,10,7.29,13.3a1,1,0,1,0,1.42,1.4l4.7-4.76Z"/>
                            </svg>
                        </i><!-- .jt-icon -->
                    </a><!-- .jt-pagination__next-btn -->
                    <a href="{{ $paginator->url($paginator->lastPage()) }}" class="jt-pagination__last-btn">
                        <span class="sr-only">{!! __('front.ui.last-page') !!}</span>
                        <i class="jt-icon">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M5.3,5.3a1,1,0,0,0,0,1.4L8.6,10,5.3,13.3a1,1,0,0,0,1.4,1.4l4.7-4.8L6.7,5.3A1,1,0,0,0,5.3,5.3Z"/>
                                <path d="M14,5a.94.94,0,0,0-1,1v8a1,1,0,0,0,2,0V6A.94.94,0,0,0,14,5Z"/>
                            </svg>
                        </i><!-- .jt-icon -->
                    </a><!-- .jt-pagination__last-btn -->
                </div><!-- .jt-pagination__next -->
            @endif
        @else
            <div class="jt-pagination__number">
                <a class="jt-pagination--current"><span class="jt-typo--15">1</span></a>
            </div><!-- .jt-pagination__number -->
        @endif
    </div><!-- .jt-pagination__inner -->
</div><!-- .jt-pagination -->
