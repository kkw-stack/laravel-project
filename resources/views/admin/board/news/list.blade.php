@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '언론뉴스' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">언론뉴스</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    @load_partials('admin.partials.locale-menu', [...compact('locale'), 'route' => 'admin.news.list'])

    <div class="tab-content position-relative">
        <div class="tab-pane show active" id="langKorea">
            <a href="{{ route('admin.news.create', compact('locale')) }}" class="btn btn-primary position-absolute end-0 tab-outside-btn">언론뉴스 등록</a>

            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2 class="card-title mb-0">목록</h2>

                            <form novalidate>
                                <input type="hidden" name="locale" value="{{ $locale }}" />

                                <div class="row justify-content-end">
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <select name="search_type" class="form-select wd-100-f">
                                                <option value="title">제목</option>
                                                <option value="content" @selected($search_type === 'content')>내용</option>
                                                <option value="author" @selected($search_type === 'author')>작성자</option>
                                            </select><!-- .form-select -->
                                            <input type="text" class="form-control wd-200-f" placeholder="검색어를 입력해주세요." name="search" value="{{ $search }}" />
                                            <button class="btn btn-secondary" type="submit">검색</button>
                                        </div><!-- .input-group -->
                                    </div><!-- col -->
                                </div><!-- row -->
                            </form>
                        </div><!-- .card-header -->

                        <div class="card-body">
                            @if(!empty($search) )
                                <p class="card-text mb-3">“{{ $search }}” 검색결과 {{ $newses->total() }}개</p>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="wd-100-f">상태</th>
                                            <th>제목</th>
                                            <th class="wd-150-f">작성자</th>
                                            <th class="wd-150-f">등록일</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($newses as $news)
                                            <tr>
                                                <td>{{ $news->status ? '공개' : '비공개' }}</td>
                                                <td>
                                                    <a class="text-decoration-underline" href="{{ route('admin.news.detail', [...request()->query(), ...compact('news')]) }}">
                                                        {!! highlight($news->title, 'title' === $search_type ? $search : null ) !!}
                                                    </a>
                                                </td>
                                                <td>{!! highlight($news->author->name, 'author' === $search_type ? $search : null) !!}</td>
                                                <td>{{ $news->published_at->format('Y. m. d') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">등록된 게시물이 없습니다.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div><!-- .table-responsive -->

                            {{ $newses->withQueryString()->links('admin.partials.pagination') }}
                        </div><!-- .card-body -->
                    </div><!-- .card -->
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .tab-pane -->
    </div><!-- .tab-content -->
@endsection
