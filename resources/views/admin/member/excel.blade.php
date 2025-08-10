@php
    echo "\xEF\xBB\xBF";
@endphp

<style>
	br {mso-data-placement:same-cell;}
</style>

<table border="1">
    <thead>
        <tr>
            <th>상태</th>
            <th>아이디(이메일)</th>
            <th>이름</th>
            <th>출생년도</th>
            <th>성별</th>
            <th>휴대폰 번호</th>
            <th>SNS 연동</th>
            <th>가입일</th>
            <th>최근 접속일</th>
            <th>거주지역</th>
            <th>가입경로</th>
            <th>관리자메모</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->trashed() ? '탈퇴' : '회원' }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->birth?->format('Y-m-d') }}</td>
                <td>{{ $user->gender === null ? '' : ($user->gender == 1 ? '남자' : '여자') }}</td>
                <td>{{ $user->mobile }}</td>
                <td>{{ $user->getSnsConnectionLabels() }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>{{ $user->last_logged_in?->format('Y-m-d H:i') }}</td>
                <td>{{ $user->location }}</td>
                <td>{{ $user->source }}{{ '기타' === $user->source ? ' : ' . $user->source_etc : '' }}</td>
                <td>{!! nl2br($user->memo) !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>
