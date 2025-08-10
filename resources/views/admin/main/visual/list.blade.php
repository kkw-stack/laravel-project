@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '비주얼 슬라이드' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">비주얼 슬라이드</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    @load_partials('admin.partials.locale-menu', [...compact('locale'), 'route' => 'admin.main.visual.list'])

    <div class="tab-content position-relative">
        <div class="tab-pane show active" id="langKorea">
            <a href="{{ route('admin.main.visual.create', compact('locale')) }}" class="btn btn-primary position-absolute end-0 tab-outside-btn">슬라이드 등록</a>

            <div class="row">
                <form method="post">
                    @csrf

                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="card-title mb-0">공개중</h2>
                            </div><!-- .card-header -->

                            <div class="card-body">
                                <p class="card-text text-muted mb-3">첫번째로 오는 슬라이드 이미지가 인트로에 노출됩니다. 드래그앤드랍으로 순서 조정이 가능합니다.</p>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="wd-50-f text-center">순서</th>
                                                <th class="wd-100-f">상태</th>
                                                <th>제목</th>
                                                <th class="wd-150-f">작성자</th>
                                                <th class="wd-150-f">등록일</th>
                                            </tr>
                                        </thead>
                                        <tbody class="jt-handle-sort">
                                            @forelse($sortVisuals as $visual)
                                                <tr>
                                                    <input type="hidden" name="sort_ids[]" value="{{ $visual->id }}" />
                                                    <td class="jt-handle-sort__grap text-center fs-5"><i class="mdi mdi-menu"></i></td>
                                                    <td>{{ $visual->status ? '공개' : '비공개' }}</td>
                                                    <td>
                                                        <a class="text-decoration-underline" href="{{ route('admin.main.visual.detail', array_merge(request()->query(), compact('visual'))) }}">{{ $visual->title }}</a>
                                                    </td>
                                                    <td>{{ $visual->author->name }}</td>
                                                    <td>{{ $visual->created_at->format('Y. m. d') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">공개중인 게시물이 없습니다.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div><!-- .table-responsive -->

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-secondary btn-sm">순서 저장</button>
                                </div>
                            </div><!-- .card-body -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                </form>
            </div><!-- .row -->

            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2 class="card-title mb-0">목록</h2>
                        </div><!-- .card-header -->

                        <div class="card-body">
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
                                        @forelse($mainVisuals as $visual)
                                            <tr>
                                                <td>{{ $visual->status ? '공개' : '비공개' }}</td>
                                                <td>
                                                    <a class="text-decoration-underline" href="{{ route('admin.main.visual.detail', array_merge(request()->query(), compact('visual'))) }}">
                                                        {{ $visual->title }}
                                                    </a>
                                                </td>
                                                <td>{{ $visual->author->name }}</td>
                                                <td>{{ $visual->created_at->format('Y. m. d') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">등록된 게시물이 없습니다.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div><!-- .table-responsive -->

                            {{ $mainVisuals->withQueryString()->links('admin.partials.pagination') }}
                        </div><!-- .card-body -->
                    </div><!-- .card -->
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .tab-pane -->
    </div><!-- .tab-content -->
@endsection
