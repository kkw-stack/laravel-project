@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '관리자 정보' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">관리자 정보</h1>
        </div><!-- .col -->

        <div class="col-auto">
            <a href="{{ route('admin.manager.create') }}" class="btn btn-primary">관리자 등록</a>
        </div><!-- .col -->
    </div><!-- .row -->

    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">목록</h2>

                    <form novalidate>
                        <div class="row justify-content-end">
                            <div class="col-auto">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="이름을 입력해주세요." value="{{ $search }}" />
                                    <button class="btn btn-secondary" type="submit">검색</button>
                                </div><!-- .input-group -->
                            </div><!-- col -->
                        </div><!-- row -->
                    </form>
                </div><!-- .card-header -->

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="wd-150-f">이름</th>
                                    <th>이메일</th>
                                    <th class="wd-200-f">휴대폰 번호</th>
                                    <th class="wd-150-f">등록일</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($managers as $manager)
                                    <tr
                                        @class([
                                            'table-warning' => $manager->trashed(),
                                        ])
                                    >
                                        <td>{{ $manager->name . ($manager->trashed() ? ' (탈퇴)' : '') }}</td>
                                        <td><a class="text-decoration-underline" href="{{ route('admin.manager.detail', [...request()->query(), ...compact('manager')]) }}">{{ $manager->email }}</a></td>
                                        <td>{{ $manager->phone }}</td>
                                        <td>{{ $manager->created_at->format('Y. m. d') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">등록된 관리자가 없습니다.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div><!-- .table-responsive -->

                    {{ $managers->withQueryString()->links('admin.partials.pagination') }}
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->
    </div><!-- .row -->
@endsection
