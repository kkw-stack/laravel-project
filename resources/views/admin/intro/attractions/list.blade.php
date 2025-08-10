@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '주변 볼거리' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">주변 볼거리</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    @load_partials('admin.partials.locale-menu', [...compact('locale'), 'route' => 'admin.intro.attractions.list'])

    <div class="tab-content position-relative">
        <div class="tab-pane show active" id="langKorea">
            <a href="{{ route('admin.intro.attractions.create', compact('locale')) }}" class="btn btn-primary position-absolute end-0 tab-outside-btn">등록</a>

            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2 class="card-title mb-0">목록</h2>
                        </div><!-- .card-header -->

                        <div class="card-body">
                            <form method="post">
                                @csrf

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="wd-50-f text-center">순서</th>
                                                <th class="wd-100-f">상태</th>
                                                <th>장소명</th>
                                                <th class="wd-100-f">거리(KM)</th>
                                                <th class="wd-150-f">작성자</th>
                                                <th class="wd-150-f">등록일</th>
                                            </tr>
                                        </thead>
                                        <tbody class="jt-handle-sort">
                                            @forelse($attractions as $attraction)
                                                <tr>
                                                    <td class="jt-handle-sort__grap text-center fs-5">
                                                        <input type="hidden" name="sort_ids[]" value="{{ $attraction->id }}" />
                                                        <i class="mdi mdi-menu"></i>
                                                    </td>
                                                    <td>{{ $attraction->status ? '공개' : '비공개' }}</td>
                                                    <td>
                                                        <a class="text-decoration-underline" href="{{ route('admin.intro.attractions.detail', array_merge(request()->query(), compact('attraction'))) }}">
                                                            {{ $attraction->title }}
                                                        </a>
                                                    </td>
                                                    <td>{{ number_format($attraction->distance) }}</td>
                                                    <td>{{ $attraction->author->name }}</td>
                                                    <td>{{ $attraction->published_at->format('Y. m. d') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">등록된 게시물이 없습니다.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div><!-- .table-responsive -->

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-secondary btn-sm">순서 저장</button>
                                </div>
                            </form>
                        </div><!-- .card-body -->
                    </div><!-- .card -->
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .tab-pane -->
    </div><!-- .tab-content -->
@endsection
