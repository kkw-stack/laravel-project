@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '관리자 복원' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">관리자 복원</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form method="POST" novalidate>
        @csrf
        @method('PATCH')

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">관리자 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="userName" class="form-label">이름</label>
                            <input type="text" class="form-control" id="userName" disabled value="{{ $manager->name }}" />
                        </div>

                        <div class="mb-3">
                            <label for="userStatus" class="form-label">상태</label>
                            <input type="text" class="form-control" id="userStatus" disabled value="탈퇴" />
                        </div>

                        <div class="mb-3">
                            <label for="userEmail" class="form-label">아이디 (이메일)</label>
                            <input type="email" class="form-control" id="userEmail" disabled value="{{ $manager->email }}" />
                        </div>

                        <div class="mb-3">
                            <label for="userTel" class="form-label">휴대폰번호</label>
                            <input type="tel" class="form-control" id="userTel" disabled value="{{ $manager->phone }}" />
                        </div>
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            @if(0)
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2 class="card-title mb-0">콘텐츠 관리</h2>
                        </div><!-- .card-header -->

                        <div class="card-body">
                            <p class="card-text mb-3">해당 관리자를 탈퇴처리합니다. 관리자가 작성한 콘텐츠는 어떻게 처리할까요?</p>

                            <div class="mb-2 mb-sm-1">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="contentOption" id="contentDelete" name="delete_type" value="cascade" checked />
                                    <label class="form-check-label" for="contentDelete">모든 콘텐츠 제거</label>
                                </div><!-- .form-check -->
                            </div>
                            <div class="input-group align-items-center gap-2 gap-md-3">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="contentOption" id="contentTransfer" name="delete_type" value="rename" />
                                    <label class="form-check-label" for="contentTransfer">다음 관리자에게 귀속</label>
                                </div><!-- .form-check -->

                                <div class="wd-xs-300-f">
                                    <select class="js-select-primary form-select" data-width="100%" name="admin_id">
                                        @foreach(App\Models\Admin::whereNot('id', $admin->id)->get() as $target)
                                            <option value="{{ $target->id }}">${{ $target->name }}({{ $target->email }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div><!-- .card-body -->
                    </div><!-- .card -->
                </div><!-- .col -->
            @endif

            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">복원</button>
                                <a href="{{ route('admin.manager.list', request()->query()) }}" class="btn btn-light">취소</a>
                            </div><!-- .col -->
                        </div><!-- .rwo -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div><!-- .row -->
    </form>
@endsection

@push('scripts')
<script>
$(function () {
    'use strict';

    // 회원탈퇴 재확인
    $('form').on('submit', (function(e){
        return confirm('{{ __('jt.AL-03') }}');
    }));
});
</script>
@endpush
