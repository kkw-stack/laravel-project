@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '관람권 사용 관리' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">관람권 사용 관리</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mb-0">예약번호 입력</h2>
                </div><!-- .card-header -->

                <div class="card-body">
                    <form novalidate>
                        <div class="row">
                            <div class="col">
                                <div class="input-group">
                                    <input type="text" name="id" id="reservationNumber" class="form-control" />
                                    <button type="submit" class="btn btn-secondary">조회</button>
                                </div><!-- .input-group -->
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </form>
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->

        @if(!is_null($reservation))
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">조회결과</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        @if(false === $reservation)
                            <div class="text-center">
                                <p class="text-danger">예약번호가 존재하지 않습니다.</p>
                            </div>
                        @else
                            <form action="{{ route('admin.reservation.manage.used', compact('reservation')) }}" method="post" novalidate>
                                @csrf

                                <div class="row">
                                    <div class="col">
                                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 mb-4 pe-1">
                                            <div class="col mb-2 mb-md-0">
                                                <b class="text-black me-2">예매번호</b>
                                                <span class="text-muted">{{ $reservation->code }}</span>
                                            </div><!-- .col -->
                                            <div class="col mb-2 mb-md-0">
                                                <b class="text-black me-2">이름</b>
                                                <span class="text-muted">{{ $reservation->user_name }}</span>
                                            </div><!-- .col -->
                                            <div class="col mb-2 mb-sm-0">
                                                <b class="text-black me-2">휴대폰번호</b>
                                                <span class="text-muted">{{ phone_format($reservation->user_mobile) }}</span>
                                            </div><!-- .col -->
                                            <div class="col mb-2 mb-sm-0">
                                                <b class="text-black me-2">아이디(이메일)</b>
                                                <span class="text-muted">{{ $reservation->user_email }}</span>
                                            </div><!-- .col -->
                                        </div><!-- .row -->
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 border rounded p-3 mb-4 mx-0">
                                    <div class="col p-1 p-sm-2 p-md-3">
                                        <b class="text-black me-2">관람권명</b>
                                        <span class="text-muted">{{ $reservation->ticket->title['ko'] }}</span>
                                    </div><!-- .col -->
                                    <div class="col p-1 p-sm-2 p-md-3">
                                        <b class="text-black me-2">관람구역</b>
                                        <span class="text-muted">{{ $reservation->ticket->sector['ko'] }}</span>
                                    </div><!-- .col -->
                                    <div class="col p-1 p-sm-2 p-md-3">
                                        <b class="text-black me-2">방문날짜</b>
                                        <span class="text-muted">{{ date_format_korean($reservation->select_date, 'Y년 n월 j일(D)') }}</span>
                                    </div><!-- .col -->
                                    <div class="col p-1 p-sm-2 p-md-3">
                                        <b class="text-black me-2">방문시간</b>
                                        <span class="{{ $reservation->can_use() ? 'text-danger' : 'text-muted' }}">{{ date_format_korean($reservation->select_time, 'A h:i') }}</span>
                                    </div><!-- .col -->
                                    <div class="col p-1 p-sm-2 p-md-3">
                                        <b class="text-black me-2">정원해설</b>
                                        <span class="text-muted">{{ $reservation->use_docent ? 'O' : 'X' }}</span>
                                    </div><!-- .col -->
                                    <div class="col p-1 p-sm-2 p-md-3">
                                        <b class="text-black me-2">방문인원</b>
                                        <span class="text-muted">{{ $reservation->get_visitors_label() }}</span>
                                    </div><!-- .col -->
                                    <div class="col p-1 p-sm-2 p-md-3">
                                        <b class="text-black me-2">결제수단</b>
                                        <span class="text-muted">{{ $reservation->get_payment_type() }}</span>
                                    </div><!-- .col -->
                                    <div class="col p-1 p-sm-2 p-md-3">
                                        <b class="text-black me-2">결제금액</b>
                                        <span class="text-muted">{{ number_format($reservation->amount) }}</span>
                                    </div><!-- .col -->
                                    <div class="col p-1 p-sm-2 p-md-3">
                                        <b class="text-black me-2">결제일</b>
                                        <span class="text-muted">{{ $reservation->paid_at?->format('Y-m-d H:i:s') }}</span>
                                    </div><!-- .col -->
                                </div><!-- .row -->

                                <div class="text-center">
                                    @if(!empty($reservation->canceled_at))
                                        <p class="text-danger">취소 처리된 예약입니다.</p>
                                    @elseif($reservation->is_past())
                                        <p class="text-danger">사용 기간이 만료된 예약입니다.</p>
                                    @elseif($reservation->is_future())
                                        <p class="text-danger">오늘은 방문날짜가 아닙니다. 방문날짜를 다시 확인해주세요.</p>
                                    @elseif($reservation->can_use())
                                        @if(abs($reservation->select_date_diff_in_minutes(now())) > 10)
                                            <p class="text-danger mb-3">현재 시간과 방문시간이 10분 이상 차이가 나므로, 유의하여 처리해주세요.</p>
                                        @endif
                                        <button type="submit" class="btn btn-primary">사용완료</button>
                                    @else
                                        <button type="button" class="btn btn-secondary" disabled>사용처리</button>
                                    @endif
                                </div>
                            </form>
                        @endif
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->
        @endif

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mb-0">사용완료 내역</h2>
                </div><!-- .card-header -->

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th class="wd-150-f">예매번호</th>
                                    <th class="wd-100-f">이름</th>
                                    <th class="wd-150-f">휴대폰 번호</th>
                                    <th>아이디(이메일)</th>
                                    <th class="wd-200-f">사용완료 날짜</th>
                                    <th class="wd-100-f">사용취소</th>
                                    <th class="wd-50-f"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->code }}</td>
                                    <td>{{ $reservation->user_name }}</td>
                                    <td>{{ phone_format($reservation->user_mobile) }}</td>
                                    <td>{{ $reservation->user_email }}</td>
                                    <td>{{ date_format_korean($reservation->used_at, 'Y-m-d A h:i') }}</td>
                                    <td>
                                        <form action="{{ route('admin.reservation.manage.cancel', compact('reservation')) }}" method="post" class="cancelform">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="btn btn-xs btn-danger">취소</button>
                                        </form>
                                    </td>
                                    <td><button type="button" class="btn btn-xs btn-light btn-icon jt-table-accordion__item"><i data-feather="chevron-down"></i></button></td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="p-0 text-wrap">
                                        <div class="jt-table-accordion__content">
                                            <div class="row row-cols-3 p-3 mx-0">
                                                <div class="col p-1 p-sm-2 p-md-3">
                                                    <b class="text-black me-2">관람권명</b>
                                                    <span class="text-muted">{{ $reservation->ticket->title['ko'] }}</span>
                                                </div><!-- .col -->
                                                <div class="col p-1 p-sm-2 p-md-3">
                                                    <b class="text-black me-2">관람구역</b>
                                                    <span class="text-muted">{{ $reservation->ticket->sector['ko'] }}</span>
                                                </div><!-- .col -->
                                                <div class="col p-1 p-sm-2 p-md-3">
                                                    <b class="text-black me-2">방문날짜</b>
                                                    <span class="text-muted">{{ date_format_korean($reservation->select_date, 'Y년 n월 j일(D)') }}</span>
                                                </div><!-- .col -->
                                                <div class="col p-1 p-sm-2 p-md-3">
                                                    <b class="text-black me-2">방문시간</b>
                                                    <span class="text-muted">{{ date_format_korean($reservation->select_time, 'A h:i') }}</span>
                                                </div><!-- .col -->
                                                <div class="col p-1 p-sm-2 p-md-3">
                                                    <b class="text-black me-2">정원해설</b>
                                                    <span class="text-muted">{{ $reservation->use_docent ? 'O' : 'X' }}</span>
                                                </div><!-- .col -->
                                                <div class="col p-1 p-sm-2 p-md-3">
                                                    <b class="text-black me-2">방문인원</b>
                                                    <span class="text-muted">{{ $reservation->get_visitors_label() }}</span>
                                                </div><!-- .col -->
                                                <div class="col p-1 p-sm-2 p-md-3">
                                                    <b class="text-black me-2">결제수단</b>
                                                    <span class="text-muted">{{ $reservation->get_payment_type() }}</span>
                                                </div><!-- .col -->
                                                <div class="col p-1 p-sm-2 p-md-3">
                                                    <b class="text-black me-2">결제금액</b>
                                                    <span class="text-muted">{{ number_format($reservation->amount) }}</span>
                                                </div><!-- .col -->
                                                <div class="col p-1 p-sm-2 p-md-3">
                                                    <b class="text-black me-2">결제일</b>
                                                    <span class="text-muted">{{ $reservation->paid_at?->format('Y-m-d H:i:s') }}</span>
                                                </div><!-- .col -->
                                            </div><!-- .row -->
                                        </div><!-- .jt-table-accordion__content -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- .table-responsive -->
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->
    </div><!-- .row -->
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
<script>
// Prevent alert
window.addEventListener('beforeunload', ( e ) => {
    e.stopImmediatePropagation();
});

$(function () {
    'use strict';

    let barcode = '';
    let interval;

    document.querySelectorAll('.cancelform').forEach(function (el) {
        el.addEventListener('submit', function (e) {
            e.preventDefault();

            if( confirm('{{ __("jt.AL-09") }}') ){
                el.submit();
            }
        });
    });

    document.addEventListener('keydown', ( e ) => {
        if( interval ){
            clearInterval( interval );
        }

        if( e.key?.toLowerCase() == 'enter' ){
            if( barcode ){
                e.preventDefault();
                barcodeScene( barcode );
            }
            barcode = '';
            return;
        }

        if( e.key?.toLowerCase() != 'shift' ){
            barcode += e.key;
        }

        interval = setInterval(() => {
            barcode = '';
        }, 20);
    });

    function barcodeScene( barcode ){
        location.href = location.pathname + '?id=' + barcode;
    }
});
</script>
@endpush
