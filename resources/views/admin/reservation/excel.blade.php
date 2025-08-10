@php
    echo "\xEF\xBB\xBF";
@endphp

<style>
	br {mso-data-placement:same-cell;}
</style>

<table border="1">
    <thead>
        <tr>
            <th>예매번호</th>
            <th>사용여부</th>
            <th>사용완료 날짜/시간</th>
            <th>결제상태</th>
            <th>관람권명</th>
            <th>방문날짜</th>
            <th>방문시간</th>
            <th>정원 해설 신청</th>
            <th>방문인원</th>
            <th>결제수단</th>
            <th>결제금액</th>
            <th>결제일</th>
            <th>부분취소 일자</th>
            <th>부분취소 금액</th>
            <th>구분</th>
            <th>분류</th>
            <th>아이디(이메일)</th>
            <th>이름</th>
            <th>출생년도</th>
            <th>성별</th>
            <th>휴대폰번호</th>
            <th>SNS연동</th>
            <th>관리자메모</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reservations as $reservation)
            <tr>
                <td>{{ $reservation->code }}</td>
                <td>{{ $reservation->get_used_status() }}</td>
                <td>{{ $reservation->used_at }}</td>
                <td>{{ $reservation->get_paid_status() }}</td>
                <td>{{ $reservation->ticket->title['ko'] }}</td>
                <td>{{ $reservation->select_date->format('Y-m-d') }}</td>
                <td>{{ date_format_korean($reservation->select_time, 'A h:i') }}</td>
                <td>{{ $reservation->use_docent ? 'O' : 'X' }}</td>
                <td>{{ $reservation->get_visitors_label() }}</td>
                <td>{{ $reservation->get_payment_type() }}</td>
                <td>{{ number_format($reservation->amount) }}</td>
                <td>{{ $reservation->paid_at?->format('Y-m-d H:i:s') }}</td>
                <td>{{ $reservation->canceled_at?->format('Y-m-d H:i:s') }}</td>
                <td>{{ number_format($reservation->canceled_amount) }}</td>
                <td>{{ $reservation->user || $reservation->withdraw_user ? ($reservation->user?->trashed() || $reservation->withdraw_user ? '회원(탈퇴)' : '회원') : '비회원' }}</td>
                <td>{{ 'ko' === $reservation->locale ? '국문' : '영문' }}</td>
                <td>{{ $reservation->user_email }}</td>
                <td>{{ $reservation->user_name }}</td>
                <td>{{ $reservation->user_birth ? $reservation->user_birth->format('Y-m-d') : '' }}</td>
                <td>{{ $reservation->user_gender }}</td>
                <td>{{ phone_format($reservation->user_mobile) }}</td>
                <td>{{ $reservation?->user?->getSnsConnectionLabels() ?? '-' }}</td>
                <td>{!! nl2br($reservation->memo) !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>
