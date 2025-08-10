@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '자주묻는질문' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">자주묻는질문</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    @load_partials('admin.partials.locale-menu', [...compact('locale'), 'route' => 'admin.faq.list'])

    <div class="tab-content position-relative">
        <div class="tab-pane show active" id="langKorea">
            <a href="{{ route('admin.faq.create', compact('locale')) }}" class="btn btn-primary position-absolute end-0 tab-outside-btn">등록</a>

            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2 class="card-title mb-0">목록</h2>

                            <form novalidate>
                                <input type="hidden" name="locale" value="{{ $locale }}" />

                                <div class="row justify-content-end">
                                    <div class="col-auto border-end">
                                        <div class="input-group">
                                            <span class="input-group-text">카테고리</span>

                                            <select name="filter_category" class="form-select">
                                                <option value="">전체</option>

                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @selected($filterCategory === $category->id)>{{ $category->name }}</option>
                                                @endforeach
                                            </select><!-- .form-select -->
                                        </div><!-- .input-group -->
                                    </div><!-- col -->

                                    <div class="col-auto">
                                        <div class="input-group">
                                            <select name="search_type" class="form-select wd-100-f">
                                                <option value="question">질문</option>
                                                <option value="answer" @selected('answer' === $searchType)>내용</option>
                                                <option value="author" @selected('author' === $searchType)>작성자</option>
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
                                <p class="card-text mb-3">“{{ $search }}” 검색결과 {{ $faqs->total() }}개</p>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="wd-100-f">상태</th>
                                            <th class="wd-100-f">카테고리</th>
                                            <th>질문</th>
                                            <th class="wd-150-f">작성자</th>
                                            <th class="wd-150-f">등록일</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($faqs as $faq)
                                            <tr>
                                                <td>{{ $faq->status ? '공개' : '비공개' }}</td>
                                                <td>{{ $faq->category->name }}
                                                <td>
                                                    <a class="text-decoration-underline" href="{{ route('admin.faq.detail', array_merge(request()->query(), compact('faq'))) }}">
                                                        {!! highlight($faq->question, 'question' === $searchType ? $search : null ) !!}
                                                    </a>
                                                </td>
                                                <td>{!! highlight($faq->author->name, 'author' === $searchType ? $search : null ) !!}</td>
                                                <td>{{ $faq->published_at->format('Y. m. d') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">등록된 게시물이 없습니다.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div><!-- .table-responsive -->

                            {{ $faqs->withQueryString()->links('admin.partials.pagination') }}
                        </div><!-- .card-body -->
                    </div><!-- .card -->
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .tab-pane -->
    </div><!-- .tab-content -->
@endsection
