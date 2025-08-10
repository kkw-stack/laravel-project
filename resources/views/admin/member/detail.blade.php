@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '회원 상세' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">회원 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form method="post" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">가입 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="userStatus" class="form-label">구분</label>
                                <input
                                    type="text"
                                    id="userStatus"
                                    class="form-control"
                                    value="{{ $user->trashed() ? '탈퇴' : '회원' }}"
                                    readonly
                                />
                            </div><!-- .col -->

                            <div class="col-md-6">
                                <label for="userType" class="form-label">분류</label>
                                <input
                                    type="text"
                                    id="userType"
                                    class="form-control"
                                    value="{{ 'ko' === $user->locale ? '국문' : '영문' }}"
                                    readonly
                                />
                            </div><!-- .col -->
                        </div><!-- .row -->

                        <div class="mb-3">
                            <label for="userEmail" class="form-label">아이디 (이메일)</label>
                            <input
                                type="email"
                                id="userEmail"
                                class="form-control"
                                value="{{ $user->email }}"
                                readonly
                            />
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="userName" class="form-label">이름</label>
                                <input
                                    type="text"
                                    id="userName"
                                    class="form-control"
                                    value="{{ $user->name }}"
                                    readonly
                                />
                            </div><!-- .col -->

                            <div class="col-md-3">
                                <label for="userName" class="form-label">출생년도</label>
                                <input
                                    type="text"
                                    id="userName"
                                    class="form-control"
                                    value="{{ $user->birth?->format('Y') }}"
                                    readonly
                                />
                            </div><!-- .col -->

                            <div class="col-md-3">
                                <label for="userName" class="form-label">성별</label>
                                <input
                                    type="text"
                                    id="userName"
                                    class="form-control"
                                    value="{{ $user->gender === null ? '' : ($user->gender == 1 ? '남자' : '여자') }}"
                                    readonly
                                />
                            </div><!-- .col -->
                        </div><!-- .row -->

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="userMobile" class="form-label">휴대폰 번호</label>
                                <input
                                    type="text"
                                    id="userMobile"
                                    class="form-control"
                                    value="{{ $user->mobile }}"
                                    readonly
                                />
                            </div><!-- .col -->

                            <div class="col-md-6">
                                <label for="userSNS" class="form-label">SNS연동</label>
                                <input
                                    type="text"
                                    id="userSNS"
                                    class="form-control"
                                    value="{{ $user->getSnsConnectionLabels() }}"
                                    readonly
                                />
                            </div><!-- .col -->
                        </div><!-- .row -->

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="userCreatedAt" class="form-label">가입일</label>
                                <input
                                    type="text"
                                    id="userCreatedAt"
                                    class="form-control"
                                    value="{{ $user->created_at->format('Y. m. d') }}"
                                    readonly
                                />
                            </div><!-- .col -->

                            <div class="col-md-6">
                                <label for="userLastConnectedAt" class="form-label">최근 접속일</label>
                                <input
                                    type="text"
                                    id="userLastConnectedAt"
                                    class="form-control"
                                    value="{{ $user->last_logged_in?->format('Y. m. d H:i') }}"
                                    readonly
                                />
                            </div><!-- .col -->
                        </div><!-- .row -->

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="userCreatedAt" class="form-label">마케팅 정보 수신동의</label>
                                <input
                                    type="text"
                                    id="userCreatedAt"
                                    class="form-control"
                                    value="{{ $user->marketing ? '동의' : '미동의' }}"
                                    readonly
                                />
                            </div><!-- .col -->

                            <div class="col-md-6">
                                <label for="userLastConnectedAt" class="form-label">수신 동의/해제 날짜</label>
                                <input
                                    type="text"
                                    id="userLastConnectedAt"
                                    class="form-control"
                                    value="{{ $user->marketing_updated_at?->format('Y. m. d H:i') }}"
                                    readonly
                                />
                            </div><!-- .col -->
                        </div><!-- .row -->

                        <div class="row mb-3">
                            <div class="col">
                                <label for="userLocation" class="form-label">거주지역</label>
                                <input
                                    type="text"
                                    id="userLocation"
                                    class="form-control"
                                    value="{{ $user->location }}"
                                    readonly
                                />
                            </div><!-- .col -->
                        </div><!-- .row -->

                        <div class="row">
                            <div class="col">
                                <label for="userLocation" class="form-label">가입경로</label>
                                <input
                                    type="text"
                                    id="userLocation"
                                    class="form-control"
                                    value="{{ $user->source }}"
                                    readonly
                                />

                                @if('기타' === $user->source)
                                    <textarea class="form-control mt-3" rows="3">{{ $user->source_etc }}</textarea>
                                @endif
                            </div><!-- .col -->
                        </div><!-- .row -->

                        @if($user->trashed())
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="userWithdrawDate" class="form-label">탈퇴일</label>
                                    <input
                                        type="text"
                                        id="userWithdrawDate"
                                        class="form-control"
                                        value="{{ $user->deleted_at->format('Y-m-d H:i') }}"
                                        readonly
                                    />
                                </div><!-- .col -->
                            </div><!-- .row -->

                            @if($user->withdraw)
                                <div class="row mt-3">
                                    <div class="col">
                                        <label for="userWithdraw" class="form-label">탈퇴 사유</label>
                                        <input
                                            type="text"
                                            id="userWithdraw"
                                            class="form-control"
                                            value="{{ $user->withdraw }}"
                                            readonly
                                        />

                                        @if('기타' === $user->withdraw)
                                            <textarea class="form-control mt-1" rows="5" readonly>{{ $user->withdraw_memo }}</textarea>
                                        @endif
                                    </div><!-- .col -->
                                </div><!-- .row -->
                            @endif
                        @endif
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-0"><label for="managerMemo">관리자 메모</label></h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <textarea
                                id="managerMemo"
                                name="memo"
                                class="form-control"
                                rows="5"
                            >{{ $user->memo }}</textarea>
                        </div>

                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                                <div class="d-flex gap-1">
                                    <button type="submit" class="btn btn-primary">수정</button>
                                    <a href="{{ route('admin.member.list', request()->query()) }}" class="btn btn-light">취소</a>
                                </div>
                            </div><!-- .col -->

                            <div class="col-auto">
                                <div class="d-flex gap-1">
                                    <button type="button" type="button" class="btn btn-outline-danger" id="managerDelete">{{ $user->trashed() ? '복원' : '탈퇴' }}</button>

                                    @if($user->trashed() && Auth::user('admin')->is_super)
                                        <button type="button" type="button" class="btn btn-danger" id="managerForceDelete">완전 삭제</button>
                                    @endif
                                </div>
                            </div><!-- .col -->
                        </div><!-- .rwo -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div><!-- .row -->
    </form>

    <form method="POST" id="managerDeleteForm">
        @csrf
        @method('DELETE')
    </form>

    @if($user->trashed() && Auth::user('admin')->is_super)
        <form action="{{ route('admin.member.delete.force', compact('user')) }}" method="POST" id="managerForceDeleteForm">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
<script>
$(function () {
    'use strict';

    $('#managerDelete').on('click', function () {
        if (confirm('{{ __($user->trashed() ? "jt.AL-03" : "jt.AL-02") }}')) {
            $('#managerDeleteForm').submit();
        }
    });
});
</script>
@endpush

@pushif(Auth::user('admin')->is_super, 'scripts')
<script>
$(function () {
    'use strict';

    $('#managerForceDelete').on('click', function () {
        if (confirm('해당 사용자를 강제 삭제하시겠습니까?\n강제 삭제시 데이터 원복이 불가합니다.')) {
            $('#managerForceDeleteForm').submit();
        }
    });
});
</script>
@endpushif
