@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '예약 상세' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">예약 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mb-0">결제정보</h2>
                </div><!-- .card-header -->

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="reservationNumber" class="form-label">예매번호</label>
                            <input type="text" id="reservationNumber" class="form-control" readonly value="{{ $reservation->code }}" />
                        </div><!-- .col -->

                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <label for="paymentState" class="form-label">결제상태</label>
                                    <input type="text" id="paymentState" class="form-control" readonly value="{{ $reservation->get_paid_status() }}" />
                                </div>

                                <div class="col">
                                    <label for="commentary" class="form-label">사용상태</label>
                                    <input type="text" id="commentary" class="form-control" readonly value="{{ $reservation->get_used_status() }}" />
                                </div>
                            </div>

                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row mb-3">
                        <div class="col">
                            <label for="tiketTitle" class="form-label">관람권명</label>
                            <input type="text" class="form-control" readonly value="{{ $reservation->ticket->title['ko'] }}" />
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row mb-3">
                        <div class="col">
                            <label for="visiteDate" class="form-label">방문날짜</label>
                            <input type="text" id="visiteDate" class="form-control" readonly value="{{ $reservation->select_date->format('Y-m-d') }}" />
                        </div><!-- .col -->

                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <label for="visiteTime" class="form-label">방문시간</label>
                                    <input type="text" id="visiteTime" class="form-control" readonly value="{{ date_format_korean($reservation->select_time, 'A h:i') }}" />
                                </div>

                                <div class="col">
                                    <label for="commentary" class="form-label">정원해설</label>
                                    <input type="text" id="commentary" class="form-control" readonly value="{{ $reservation->use_docent ? 'O' : 'X' }}" />
                                </div>
                            </div>
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row mb-3">
                        <div class="col">
                            <label for="visitePeople" class="form-label">방문인원</label>
                            <input type="text" id="visitePeople" class="form-control" readonly value="{{ $reservation->get_visitors_label() }}" />
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row mb-3">
                        <div class="col">
                            <label for="paymentType" class="form-label">결제수단</label>
                            <input type="text" id="paymentType" class="form-control" readonly value="{{ $reservation->get_payment_type() }}" />
                        </div><!-- .col -->

                        <div class="col">
                            <label for="paymentPrise" class="form-label">결제금액</label>
                            <input type="text" id="paymentPrise" class="form-control" readonly value="{{ number_format($reservation->amount) }}">
                        </div><!-- .col -->

                        <div class="col">
                            <label for="paymentDate" class="form-label">결제일</label>
                            <input type="text" id="paymentDate" class="form-control" readonly value="{{ $reservation->paid_at?->format('Y-m-d H:i:s') }}" />
                        </div><!-- .col -->
                    </div><!-- .row -->

                    @if(!empty($reservation->canceled_at) && is_null($reservation->canceled_by))
                        <div class="row">
                            <div class="col">
                                <label for="paymentCancelDate" class="form-label">취소 일자</label>
                                <input type="text" id="paymentCancelDate" class="form-control" readonly value="{{ $reservation->canceled_at?->format('Y-m-d H:i:s') }}" />
                            </div><!-- .col -->

                            <div class="col">
                                <label for="paymentCancelPrise" class="form-label">환불 금액</label>
                                <input type="text" id="paymentCancelPrise" class="form-control" readonly value="{{ number_format($reservation->canceled_amount) }}" />
                            </div><!-- .col -->
                        </div><!-- .row -->
                    @endif
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mb-0">이용자정보</h2>
                </div><!-- .card-header -->

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="userType" class="form-label">구분</label>
                            <input type="text" id="userType" class="form-control" readonly value="{{ $reservation->user || $reservation->withdraw_user ? ($reservation->user?->trashed() || $reservation->withdraw_user ? '회원(탈퇴)' : '회원') : '비회원' }}" />
                        </div><!-- .col -->

                        <div class="col">
                            <label for="userLocale" class="form-label">분류</label>
                            <input type="text" id="userLocale" class="form-control" readonly value="{{ 'ko' === $reservation->locale ? '국문' : '영문' }}" />
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row mb-3">
                        <div class="col">
                            <label for="userEmail" class="form-label">아이디(이메일)</label>
                            <input type="text" id="userEmail" class="form-control" readonly value="{{ $reservation->user_email }}" />
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row mb-3">
                        <div class="col">
                            <label for="userName" class="form-label">이름</label>
                            <input type="text" id="userName" class="form-control" readonly value="{{ $reservation->user_name }}" />
                        </div><!-- .col -->

                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <label for="userBirthday" class="form-label">출생년도</label>
                                    <input type="text" id="userBirthday" class="form-control" readonly value="{{ app()->getLocale() === 'en' || !$reservation->user_birth ? '' : $reservation->user_birth->format('Y-m-d') }}" />
                                </div>

                                <div class="col">
                                    <label for="useGender" class="form-label">성별</label>
                                    <input type="text" id="useGender" class="form-control" readonly value="{{ app()->getLocale() === 'en' || !$reservation->user_gender ? '' : $reservation->user_gender }}" />
                                </div>
                            </div>
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row mb-3">
                        <div class="col">
                            <label for="userPhone" class="form-label">휴대폰번호</label>
                            <input type="text" id="userPhone" class="form-control" readonly value="{{ phone_format($reservation->user_mobile) }}" />
                        </div><!-- .col -->

                        <div class="col">
                            <label for="useSns" class="form-label">SNS연동</label>
                            <input type="text" id="useSns" class="form-control" readonly value="{{ $reservation?->user?->getSnsConnectionLabels() ?? '-' }}" />
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <div class="row mb-3">
                        <div class="col">
                            <label for="userTotalCount" class="form-label">총 방문 수</label>
                            <input type="text" id="userTotalCount" class="form-control" readonly value="{{ number_format($total_count) }}" />
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->

        @if(is_null($reservation->used_at) && empty($reservation->canceled_at))
            <form id="cancelForm" method="POST">
                @csrf
                @method('PATCH')

                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title mb-0"><label for="cancelAmount">예약취소 금액</label></h2>
                        </div><!-- .card-header -->

                        <div class="card-body">
                            <div class="input-group mb-3 has-validation">
                                <input
                                    type="number"
                                    id="cancelAmount"
                                    name="cancel_amount"
                                    value="{{ old('cancel_amount') }}"
                                    min="0"
                                    max="{{ $reservation->amount }}"
                                    @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('cancel_amount'),
                                    ])
                                />
                                <button type="submit" class="btn btn-danger">예약취소</button>

                                @error('cancel_amount')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div><!-- .col -->
                        </div><!-- .card-body -->
                    </div><!-- .card -->
                </div>
            </form>
        @elseif(is_null($reservation->used_at) && !is_null($reservation->canceled_by))
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-0"><label for="cancelAmount">예약취소 금액</label></h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <label for="paymentCancelDate" class="form-label">취소 일자</label>
                                <input type="text" id="paymentCancelDate" class="form-control" readonly value="{{ $reservation->canceled_at?->format('Y-m-d H:i:s') }}" />
                            </div><!-- .col -->

                            <div class="col">
                                <label for="paymentCancelPrise" class="form-label">환불 금액</label>
                                <input type="text" id="paymentCancelPrise" class="form-control" readonly value="{{ number_format($reservation->canceled_amount) }}" />
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div>
        @endif

        <form method="post" novalidate>
            @csrf

            @if(is_null($reservation->canceled_at))
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2 class="card-title mb-0">사용여부</h2>
                        </div><!-- .card-header -->

                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex gap-1 align-items-center">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input
                                                    type="radio"
                                                    class="form-check-input"
                                                    name="use_status"
                                                    value="0"
                                                    @checked(is_null($reservation->used_at) && !$reservation->is_past())
                                                />
                                                <span>사용전</span>
                                            </label>
                                        </div><!-- .form-check -->

                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input
                                                    type="radio"
                                                    class="form-check-input"
                                                    name="use_status"
                                                    value="1"
                                                    @checked(!is_null($reservation->used_at))
                                                />
                                                <span>사용완료</span>
                                            </label>

                                            <div class="d-inline-block ms-2">
                                                <div class="input-group flatpickr js-flatpickr-datetime">
                                                    <input
                                                        type="text"
                                                        id="useDate"
                                                        name="used_at"
                                                        data-input
                                                        @class([
                                                            'form-control',
                                                            'is-invalid' => $errors->has('used_at'),
                                                        ])
                                                        value="{{ old('used_at', $reservation->used_at?->format('Y-m-d H:i:s') ?? null)}}"
                                                    />
                                                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                                    @error('used_at')
                                                        <p class="error invalid-feedback">{{ $message }}</p>
                                                    @enderror
                                                </div><!-- .input-group -->
                                            </div>
                                        </div><!-- .form-check -->
                                    </div>
                                </div><!-- .col -->
                            </div><!-- .row -->
                        </div><!-- .card-body -->
                    </div><!-- .card -->
                </div><!-- .col -->
            @endif

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
                                rows="5"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('memo'),
                                ])
                            >{{ old('memo', $reservation->memo) }}</textarea>

                            @error('memo')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                                <div class="d-flex gap-1">
                                    <button type="submit" class="btn btn-primary">수정</button>
                                    <a href="{{ route('admin.reservation.list', request()->query()) }}" class="btn btn-light">취소</a>
                                </div>
                            </div><!-- .col -->
                        </div><!-- .rwo -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div>
        </form>
    </div><!-- .row -->
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
@endPush

@pushif(empty($reservation->canceled_at), 'scripts')
<script>
$(function () {
    $('#cancelForm').on('submit', function () {
        return confirm('{{ __('jt.AL-07') }}');
    });
});
</script>
@endpushif
