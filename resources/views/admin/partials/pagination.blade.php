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
    <nav class="mt-4" aria-label="Page navigation">
        <ul class="pagination justify-content-center mb-0">
            @if($paginator->onFirstPage())
                <li class="page-item disabled"><a class="page-link"><i data-feather="chevrons-left"></i></a></li>
                <li class="page-item disabled"><a class="page-link"><i data-feather="chevron-left"></i></a></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}"><i data-feather="chevrons-left"></i></a></li>
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i data-feather="chevron-left"></i></a></li>
            @endif

            @foreach($arr_page as $page)
                @if($page == $paginator->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            @if($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i data-feather="chevron-right"></i></a></li>
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}"><i data-feather="chevrons-right"></i></a></li>
            @else
                <li class="page-item disabled"><a class="page-link"><i data-feather="chevron-right"></i></a></li>
                <li class="page-item disabled "><a class="page-link"><i data-feather="chevrons-right"></i></a></li>
            @endif
        </ul><!-- .pagination -->
    </nav>
@else
    <nav class="mt-4" aria-label="Page navigation">
        <ul class="pagination justify-content-center mb-0">
            <li class="page-item active">
                <span class="page-link" href="{{ $paginator->url(1) }}">1</span>
            </li>
        </ul><!-- .pagination -->
    </nav>
@endif
