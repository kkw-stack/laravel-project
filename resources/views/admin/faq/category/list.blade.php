@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '자주묻는질문' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">자주묻는질문 카테고리 관리</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    @load_partials('admin.partials.locale-menu', [...compact('locale'), 'route' => 'admin.faq.category.list'])

    <div class="tab-content position-relative">
        <div class="tab-pane show active" id="langKorea">
            <a href="{{ route('admin.faq.category.create', compact('locale')) }}" class="btn btn-primary position-absolute end-0 tab-outside-btn">카테고리 등록</a>

            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2 class="card-title mb-0">목록</h2>
                        </div><!-- .card-header -->

                        <div class="card-body">
                            <form id="formOrderCategory" method="post">
                                @csrf

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="wd-50-f text-center">순서</th>
                                                <th>카테고리명</th>
                                                <th class="wd-150-f">작성자</th>
                                                <th class="wd-150-f">등록일</th>
                                            </tr>
                                        </thead>
                                        <tbody class="jt-handle-sort">
                                            @forelse($categories as $category)
                                                <tr>
                                                    <input type="hidden" name="category_ids[]" value="{{ $category->id }}" />
                                                    <td class="jt-handle-sort__grap text-center fs-5"><i class="mdi mdi-menu"></i></td>
                                                    <td>
                                                        <a class="text-decoration-underline" href="{{ route('admin.faq.category.detail', array_merge(request()->query(), compact('category'))) }}">
                                                            {{ $category->name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $category->author->name }}
                                                    </td>
                                                    <td>{{ $category->created_at->format('Y. m. d') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">등록된 카테고리가 없습니다.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div><!-- .table-responsive -->

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-secondary btn-sm">순서 저장</button>
                                </div>
                            </div><!-- .card-body -->
                        </form>
                    </div><!-- .card -->
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .tab-pane -->
    </div><!-- .tab-content -->
@endsection
