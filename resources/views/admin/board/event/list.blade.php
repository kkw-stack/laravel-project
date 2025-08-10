@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '행사' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">행사</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    @load_partials('admin.partials.locale-menu', [...compact('locale'), 'route' => 'admin.event.list'])

    <div class="tab-content position-relative">
        <div class="tab-pane show active" id="langKorea">
            <a href="{{ route('admin.event.create', compact('locale')) }}" class="btn btn-primary position-absolute end-0 tab-outside-btn">행사 등록</a>

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
                                            <span class="input-group-text">구분</span>

                                            <select name="filter_progress" class="form-select wd-100-f">
                                                <option value="">전체</option>
                                                <option value="proceed" @selected('proceed' === $filter_progress)>진행예정</option>
                                                <option value="proceeding" @selected('proceeding' === $filter_progress)>진행중</option>
                                                <option value="ended" @selected('ended' === $filter_progress)>종료</option>
                                            </select><!-- .form-select -->
                                        </div><!-- .input-group -->
                                    </div><!-- col -->

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
                                <p class="card-text mb-3">“{{ $search }}” 검색결과 {{ $events->total() }}개</p>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="wd-100-f">구분</th>
                                            <th class="wd-100-f">상태</th>
                                            <th>제목</th>
                                            <th class="wd-150-f">작성자</th>
                                            <th class="wd-150-f">시작일</th>
                                            <th class="wd-150-f">종료일</th>
                                            <th class="wd-150-f">등록일</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($events as $event)
                                            <tr>
                                                <td>
                                                    <span class="badge rounded-pill bg-primary">{{ $event->currentStatusLabel() }}</span>
                                                </td>
                                                <td>{{ $event->status ? '공개' : '비공개' }}</td>
                                                <td>
                                                    <a class="text-decoration-underline" href="{{ route('admin.event.detail', [...request()->query(), ...compact('event')]) }}">
                                                        {!! highlight($event->title, 'title' === $search_type ? $search : null ) !!}
                                                    </a>
                                                </td>
                                                <td>{!! highlight($event->author->name, 'author' === $search_type ? $search : null) !!}</td>
                                                <td>{!! $event->use_always ? '상시' : nl2br($event->start_date->format('Y.m.d' . PHP_EOL . 'H:i')) !!}</td>
                                                <td>{!! $event->use_always ? '상시' : nl2br($event->end_date->format('Y.m.d' . PHP_EOL . 'H:i')) !!}</td>
                                                <td>{{ $event->published_at->format('Y. m. d') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">등록된 게시물이 없습니다.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div><!-- .table-responsive -->

                            {{ $events->withQueryString()->links('admin.partials.pagination') }}
                        </div><!-- .card-body -->
                    </div><!-- .card -->
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .tab-pane -->
    </div><!-- .tab-content -->
@endsection
