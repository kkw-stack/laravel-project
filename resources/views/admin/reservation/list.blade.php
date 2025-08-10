@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '예약 관리' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">예약 관리</h1>
            <p class="text-muted mt-2">날짜별 총 금액은 단순 참고를 위한 것으로 PG사의 실제 정산금액과 차이가 있을 수 있습니다.</p>
        </div><!-- .col -->
    </div><!-- .row -->

    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-header">
                    <div class="mb-3">
                        <div class="js-fullcalendar"></div>
                    </div>

                    <form novalidate>
                        <div class="row justify-content-between">
                            <div class="col-auto">
                            </div><!-- .col-auto -->
                        </div><!-- row -->

                        <div class="row mt-1 gap-1 justify-content-between">
                            <div class="col-auto">
                                <div class="d-flex gap-1 flex-wrap">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <div class="input-group js-flatpickr-date wd-200">
                                            <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            <input type="text" class="form-control" placeholder="검색 시작일" data-input name="start_date" value="{{ $start_date }}" />
                                        </div><!-- .input-group -->

                                        <div class="input-group js-flatpickr-date wd-200">
                                            <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            <input type="text" class="form-control" placeholder="검색 종료일" data-input name="end_date" value="{{ $end_date }}" />
                                        </div><!-- .input-group -->
                                    </div>

                                    <div class="d-flex gap-1 flex-wrap">
                                        <select name="status" class="form-select w-auto">
                                            <option value="">결제상태</option>
                                            <option value="결제대기" @selected('결제대기' === $status)>결제대기</option>
                                            <option value="결제완료" @selected('결제완료' === $status)>결제완료</option>
                                            <option value="취소" @selected('취소' === $status)>취소</option>
                                        </select><!-- .form-select -->

                                        <select name="used" class="form-select w-auto">
                                            <option value="">사용여부</option>
                                            <option value="no" @selected('no' === $used_status)>사용전</option>
                                            <option value="yes" @selected('yes' === $used_status)>사용완료</option>
                                            <option value="past" @selected('past' === $used_status)>기간만료</option>
                                        </select><!-- .form-select -->

                                        <select name="ticket" class="form-select w-auto">
                                            <option value="">관람권명</option>
                                            @foreach($tickets as $ticket)
                                                <option value="{{ $ticket->id }}" @selected($ticket_id === $ticket->id)>{{ $ticket->title['ko'] }}</option>
                                            @endforeach
                                        </select><!-- .form-select -->

                                        <select name="payment_method" class="form-select w-auto">
                                            <option value="">결제수단</option>
                                            <option value="11" @selected('11' === $payment_method)>카드결제</option>
                                            <option value="21" @selected('21' === $payment_method)>계좌이체</option>
                                            <option value="00" @selected('00' === $payment_method)>기타</option>
                                        </select><!-- .form-select -->

                                        <button class="btn btn-secondary" type="submit">조회</button>
                                        <a href="{{ route('admin.reservation.list') }}" class="btn btn-light btn-reset">초기화</a>
                                    </div>
                                </div>
                            </div><!-- .col -->

                            <div class="col-auto">
                                <div class="input-group">
                                    <select name="search_type" class="form-select w-auto">
                                        <option value="code">예매번호</option>
                                        <option value="user_name" @selected('user_name' === $search_type)>이름</option>
                                        <option value="user_email" @selected('user_email' === $search_type)>아이디(이메일)</option>
                                        <option value="user_mobile" @selected('user_mobile' === $search_type)>휴대폰번호</option>
                                    </select><!-- .form-select -->

                                    <input type="text" class="form-control wd-200-f" placeholder="검색어를 입력해주세요." name="search" value="{{ $search }}" />
                                    <button class="btn btn-secondary" type="submit">검색</button>
                                </div><!-- .input-group -->
                            </div><!-- col -->
                        </div><!-- .row -->

                        <div class="row mt-3 gap-3 justify-content-between">
                            <div class="col-auto d-flex gap-3 align-items-center">
                                <h2 class="card-title mb-0">목록({{ number_format($reservations->total()) }})</h2>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="docent" @checked($docent) />
                                        <span class="text-muted">정원해설 신청</span>
                                    </label><!-- .form-check-label -->
                                </div><!-- .form-check -->
                            </div><!-- .col -->

                            <div class="col-auto d-flex gap-1">
                                <select name="rpp" class="form-select w-auto">
                                    <option value="10">10개</option>
                                    <option value="20" @selected(20 == $rpp)>20개</option>
                                    <option value="50" @selected(50 == $rpp)>50개</option>
                                    <option value="100" @selected(100 == $rpp)>100개</option>
                                </select><!-- .form-select -->

                                <select name="sort" class="form-select w-auto">
                                    <option value="paid_date">결제일순</option>
                                    <option value="select_date" @selected('select_date' === $sort)>방문날짜/시간순</option>
                                </select><!-- .form-select -->
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </form>
                </div><!-- .card-header -->

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="wd-100-f">결제상태</th>
                                    <th class="wd-100-f">사용여부</th>
                                    <th class="wd-150-f">예매번호</th>
                                    <th>관람권명</th>
                                    <th class="wd-100-f">정원해설 신청</th>
                                    <th class="wd-100-f">구분</th>
                                    <th class="wd-100-f">분류</th>
                                    <th>아이디(이메일)</th>
                                    <th class="wd-100-f">이름</th>
                                    <th class="wd-150-f">휴대폰 번호</th>
                                    <th class="wd-100-f">결제수단</th>
                                    <th class="wd-150-f">방문날짜/시간</th>
                                    <th class="wd-150-f">결제일</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->get_paid_status() }}</td>
                                    <td>{{ $reservation->get_used_status() }}</td>
                                    <td>
                                        <a href="{{ route('admin.reservation.detail', [ ...request()->query(), ...compact('reservation')]) }}">{{ $reservation->code }}</a>
                                    </td>
                                    <td>{{ $reservation->ticket->title['ko'] }}</td>
                                    <td class="text-center">{{ $reservation->use_docent ? 'O' : 'X' }}</td>
                                    <td>{{ $reservation->user || $reservation->withdraw_user ? ($reservation->user?->trashed() || $reservation->withdraw_user ? '회원(탈퇴)' : '회원') : '비회원' }}</td>
                                    <td>{{ 'ko' === $reservation->locale ? '국문' : '영문' }}</td>
                                    <td>{{ $reservation?->user_email ?? '-' }}</td>
                                    <td>{{ $reservation->user_name }}</td>
                                    <td>{{ phone_format($reservation->user_mobile) }}</td>
                                    <td>{{ $reservation->get_payment_type() }}</td>
                                    <td>{{ date_format_korean($reservation->select_date, 'Y-m-d') }} <br />{{ date_format_korean($reservation->select_time, 'A h:i') }}</td>
                                    <td>{{ $reservation->paid_at?->format('Y-m-d') }}<br />{{ $reservation->paid_at?->format('H:i:s') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- .table-responsive -->

                    {{ $reservations->withQueryString()->links('admin.partials.pagination') }}

                    <div class="mt-4">
                        <form method="post" target="excelFrame" novalidate>
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm">액셀 다운로드</button>
                        </form>
                        <iframe name="excelFrame" style="position: absolute; left: -9999px; width: 1px; height: 1px; font-size: 0; overflow: hidden;"></iframe>
                    </div>
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->
    </div><!-- .row -->
@endsection

@push('scripts')
<script>
$(function () {
    'use strict';

    let el = document.querySelector('.js-fullcalendar');

    if (el) {
        let calendar = new FullCalendar.Calendar(el, {
            locale: 'ko',
            headerToolbar: {
                left: 'title',
                center: '',
                right: 'prev,today,next'
            },
            height: 700,
            initialDate: '{{ $start_date ? $start_date : now()->format("Y-m-d") }}',
            initialView: 'dayGridMonth',
            timeZone: 'UTC',
            eventOrder: 'start',
            events: [
                {
                    groupId: 'selectRange',
                    start: '{{ $start_date ? $start_date : "0000-01-01" }}',
                    end: dayjs('{{ $end_date ? $end_date : "9999-12-31" }}').add(1, 'day').format('YYYY-MM-DD'),
                    display: 'background'
                }
            ],
            dateClick: ( info ) => {
                location.href = `{{ route('admin.reservation.list') }}?start_date=${ info.dateStr }&end_date=${ info.dateStr }`;
            },
            datesSet: ( info ) => {
                let date = new URL( location.href ).searchParams.get('date');

                $(el).find('.fc-daygrid-day').each(( _, day ) => {
                    if( day.dataset['date'] === date ){
                        day.classList.add('fc-day-current');
                    }
                });

                const now = dayjs(calendar.getDate());

                calendar.getEvents().forEach((e) => {
                    if(e.groupId != 'selectRange'){
                        e.remove();
                    }
                });

                fetch('{{ route('admin.api.reservation.calendar') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        year: now.format('YYYY'),
                        month: now.format('MM'),
                    }),
                }).then(res => res.json()).then(data => {
                    
                    calendar.addEventSource(data.total?.map(item => {
                        return {
                            title: `총 ${item.count}건`,
                            start: `${item.select_date}`,
                            url: `{{ route('admin.reservation.list') }}?start_date=${item.select_date}&end_date=${item.select_date}`,
                        };
                    }));

                    calendar.addEventSource(data.docent_total?.map(item => {
                        return {
                            title: `정원해설 ${item.count}건`,
                            start: `${item.select_date}`,
                            url: `{{ route('admin.reservation.list') }}?start_date=${item.select_date}&end_date=${item.select_date}`,
                            color: 'rgba(var(--bs-success-rgb), .2)'
                        };
                    }));
                });
            }
        });

        calendar.render();
    }

    $('[name="docent"], [name="rpp"], [name="sort"]').on('change', function(){
        $(this).closest('form').submit();
    });

    $('.btn-reset').on('click', function(){
        location.href = location.origin + location.pathname;
    });
});
</script>
@endpush
