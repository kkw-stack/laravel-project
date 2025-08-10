@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '회원관리' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">회원관리</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-header">
                    <form novalidate>
                        <div class="row justify-content-between">
                            <div class="col-auto mb-2 mb-md-0">
                                <div class="row">
                                    <div class="col-auto border-end-md mb-2 mb-md-0">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-primary" data-period="all">전체</button>
                                            <button type="button" class="btn btn-outline-primary" data-period="week">1주일</button>
                                            <button type="button" class="btn btn-outline-primary" data-period="month">1개월</button>
                                            <button type="button" class="btn btn-outline-primary" data-period="year">1년</button>
                                        </div><!-- .btn-group -->
                                    </div><!-- .col -->

                                    <div class="col-auto">
                                        <div class="d-flex align-items-center text-nowrap">
                                            <div class="input-group js-flatpickr-date wd-200 me-2">
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                                <input type="text" class="form-control" placeholder="검색 시작일" data-input name="start_date" value="{{ $start_date }}">
                                            </div><!-- .input-group -->
                                            
                                            <div class="input-group js-flatpickr-date wd-200 me-2">
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                                <input type="text" class="form-control" placeholder="검색 종료일" data-input name="end_date" value="{{ $end_date}}">
                                            </div><!-- .input-group -->
                                        </div>
                                    </div><!-- .col -->
                                </div><!-- .row -->
                            </div><!-- .col-auto -->

                            <div class="col-auto">
                                <div class="input-group">
                                    <select name="search_type" class="form-select w-auto">
                                        <option value="name">이름</option>
                                        <option value="email" @selected($search_type === 'email')>아이디(이메일)</option>
                                        <option value="mobile" @selected($search_type === 'mobile')>휴대폰번호</option>
                                    </select><!-- .form-select -->

                                    <input type="text" class="form-control wd-200-f" placeholder="검색어를 입력해주세요." name="search" value="{{ $search }}" />
                                    <button class="btn btn-secondary" type="submit">검색</button>
                                </div><!-- .input-group -->
                            </div><!-- col -->
                        </div><!-- row -->

                        <div class="row mt-3 justify-content-between">
                            <div class="col-auto d-flex align-items-center">
                                <ul class="d-flex ps-0 mb-0">
                                    <li class="d-flex">
                                        <a 
                                            @class([
                                                'text-body' => request()->query('user_type', 'all') != 'all',
                                                'text-primary' => request()->query('user_type', 'all') == 'all'
                                            ])
                                            href="{{ route('admin.member.list', array_merge(request()->query(), ['user_type' => 'all'])) }}"
                                        >전체 ({{ $total }})</a>
                                    </li>
                                    <li class="ms-3 ps-3 border-start d-flex">
                                        <a 
                                            @class([
                                                'text-body' => request()->query('user_type', 'all') != 'ko',
                                                'text-primary' => request()->query('user_type', 'all') == 'ko'
                                            ])
                                            href="{{ route('admin.member.list', array_merge(request()->query(), ['user_type' => 'ko'])) }}"
                                        >국문 ({{ $total_ko }})</a>
                                    </li>
                                    <li class="ms-3 ps-3 border-start d-flex">
                                        <a 
                                            @class([
                                                'text-body' => request()->query('user_type', 'all') != 'en',
                                                'text-primary' => request()->query('user_type', 'all') == 'en'
                                            ]) 
                                            href="{{ route('admin.member.list', array_merge(request()->query(), ['user_type' => 'en'])) }}"
                                        >영문 ({{ $total_en }})</a>
                                    </li>
                                </ul>
                            </div><!-- .col -->

                            <div class="col-auto">
                                <select name="rpp" class="form-select w-auto">
                                    <option value="10">10개</option>
                                    <option value="20" @selected(20 == $rpp)>20개</option>
                                    <option value="50" @selected(50 == $rpp)>50개</option>
                                    <option value="100" @selected(100 == $rpp)>100개</option>
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
                                    <th class="wd-100-f">구분</th>
                                    <th class="wd-100-f">분류</th>
                                    <th>아이디(이메일)</th>
                                    <th class="wd-150-f">이름</th>
                                    <th class="wd-200-f">휴대폰 번호</th>
                                    <th class="wd-150-f">SNS연동</th>
                                    <th class="wd-150-f">가입일</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr
                                        @class([
                                            'table-warning' => $user->trashed(),
                                        ])
                                    >
                                        <td>{{ $user->trashed() ? '탈퇴' : '회원' }}</td>
                                        <td>{{ 'ko' === $user->locale ? '국문' : '영문' }}</td>
                                        <td><a class="text-decoration-underline" href="{{ route('admin.member.detail', [...request()->query(), ...compact('user')]) }}">{{ $user->email }}</a></td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->mobile }}</td>
                                        <td>{{ $user->getSnsConnectionLabels() }}</td>
                                        <td>{{ $user->created_at->format('Y. m. d') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">등록된 회원이 없습니다.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div><!-- .table-responsive -->

                    {{ $users->withQueryString()->links('admin.partials.pagination') }}

                    <div class="mt-4">
                        <form method="post" target="_blank" novalidate>
                            @csrf

                            <input type="hidden" name="start_date" value="{{ $start_date }}" />
                            <input type="hidden" name="end_date" value="{{ $end_date}}" />
                            <input type="hidden" name="search_type" value="{{ $search_type }}" />
                            <input type="hidden" name="search" value="{{ $search }}" />
                            <input type="hidden" name="user_type" value="{{ $user_type }}" />
                            <button type="submit" class="btn btn-secondary btn-sm">액셀 다운로드</button>
                        </form>
                    </div>
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->
    </div><!-- .row -->
@endsection

@push('scripts')
<script>
'use strict';

$(function () {
    $('[data-period]').on('click', e => {
        const $this = $(e.currentTarget);
        const period = $this.data('period');
        const $startDate = $('[name="start_date"]');
        const $endDate = $('[name="end_date"]');

        let startDate = null;
        let endDate = null;

        if ('all' !== period) {
            endDate = new Date();
            startDate = new Date(endDate);

            if ('week' === period) {
                startDate = new Date(startDate.setDate(startDate.getDate() - 7));
            } else if ('month' === period) {
                startDate = new Date(startDate.setMonth(startDate.getMonth() - 1));
            } else if ('year' === period) {
                startDate = new Date(startDate.setYear(startDate.getFullYear() - 1));
            }

        }

        if( !!$startDate.closest('.js-flatpickr-date').length ){
            $startDate.closest('.js-flatpickr-date')[0]._flatpickr?.setDate(startDate, false, 'Y-m-d');
        } else {
            $startDate.val(formatDate(startDate));
        }

        if( !!$endDate.closest('.js-flatpickr-date').length ){
            $endDate.closest('.js-flatpickr-date')[0]._flatpickr?.setDate(endDate, false, 'Y-m-d');
        } else {
            $endDate.val(formatDate(endDate));
        }
        
    });

    $('[name="rpp"]').on('change', function(){
        $(this).closest('form').submit();
    });

    function formatDate(date) {
        if (date instanceof Date) {
            const year = date.getFullYear();
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const day = date.getDate().toString().padStart(2, '0');

            return `${year}-${month}-${day}`;
        }

        return null;
    }
});
</script>
@endpush
