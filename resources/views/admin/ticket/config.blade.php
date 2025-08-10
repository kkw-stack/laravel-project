@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '관람권 공통관리' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">관람권 공통관리</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form id="postForm" method="post" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">예약 가능 기간</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <p class="card-text text-muted mb-3">* 미입력시 기본 +30일로 예약 가능일을 처리합니다. 최소 1, 최대 365까지 입력 가능합니다.</p>

                        <div class="input-group align-items-center">
                            <input
                                type="number"
                                name="max_date"
                                min="1"
                                max="365"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('max_date'),
                                ])
                                value="{{ old('max_date', $config->max_date) }}"
                            />
                            <span class="ms-2">일</span>

                            @error('max_date')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">같은 날짜, 같은 시간 최대 예약 가능 매수</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <p class="card-text text-muted mb-3">* 미입력시 기본 최대 5장으로 처리합니다. 최소 1, 최대 99까지 입력 가능합니다.</p>

                        <div class="input-group align-items-center">
                            <input
                                type="number"
                                name="max_count"
                                min="1"
                                max="99"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('max_count'),
                                ])
                                value="{{ old('max_count', $config->max_count) }}"
                            />
                            <span class="ms-2">장</span>

                            @error('max_count')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">정원해설 신청가능 인원</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <p class="card-text text-muted mb-3">* 미입력시 기본 최대 10명으로 처리합니다. 최소 1, 최대 99까지 입력 가능합니다.</p>

                        <div class="input-group align-items-center">
                            <input
                                type="number"
                                name="max_docent"
                                min="1"
                                max="99"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('max_docent'),
                                ])
                                value="{{ old('max_docent', $config->max_docent) }}"
                            />
                            <span class="ms-2">명</span>

                            @error('max_docent')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h2 class="card-title mb-0">비수기 날짜 설정</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <p class="card-text text-muted mb-3">* 비수기 날짜 외 날짜는 성수기 요금이 적용되며, 비수기 날짜 미지정시 모든 날짜가 성수기 요금으로 처리됩니다.</p>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th class="wd-150-f text-center">구분</th>
                                        <th class="text-center">시작일</th>
                                        <th class="text-center">종료일</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>비수기(한여름)</td>
                                        <td>
                                            <div class="input-group js-flatpickr-date" data-format="m-d" data-alt-format="m. d" data-hide="year">
                                                <input
                                                    type="text"
                                                    name="summer_start"
                                                    data-input
                                                    placeholder="시작일을 입력해주세요."
                                                    @class([
                                                        'form-control',
                                                        'is-invalid' => $errors->has('summer_start'),
                                                    ])
                                                    value="{{ old('summer_start', $config->summer_start) }}"
                                                />
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>

                                                @error('summer_start')
                                                    <p class="error invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div><!-- .input-group -->
                                        </td>
                                        <td>
                                            <div class="input-group js-flatpickr-date" data-format="m-d" data-alt-format="m. d" data-hide="year">
                                                <input
                                                    type="text"
                                                    name="summer_end"
                                                    data-input
                                                    placeholder="종료일을 입력해주세요."
                                                    @class([
                                                        'form-control',
                                                        'is-invalid' => $errors->has('summer_end'),
                                                    ])
                                                    value="{{ old('summer_end', $config->summer_end) }}"
                                                />
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>

                                                @error('summer_end')
                                                    <p class="error invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div><!-- .input-group -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>비수기(한겨울)</td>
                                        <td>
                                            <div class="input-group js-flatpickr-date" data-format="m-d" data-alt-format="m. d" data-hide="year">
                                                <input
                                                    type="text"
                                                    name="winter_start"
                                                    data-input
                                                    placeholder="시작일을 입력해주세요."
                                                    @class([
                                                        'form-control',
                                                        'is-invalid' => $errors->has('winter_start'),
                                                    ])
                                                    value="{{ old('winter_start', $config->winter_start) }}"
                                                />
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>

                                                @error('winter_start')
                                                    <p class="error invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div><!-- .input-group -->
                                        </td>
                                        <td>
                                            <div class="input-group js-flatpickr-date" data-format="m-d" data-alt-format="m. d" data-hide="year">
                                                <input
                                                    type="text"
                                                    name="winter_end"
                                                    data-input
                                                    placeholder="종료일을 입력해주세요."
                                                    @class([
                                                        'form-control',
                                                        'is-invalid' => $errors->has('winter_end'),
                                                    ])
                                                    value="{{ old('winter_end', $config->winter_end) }}"
                                                />
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>

                                                @error('winter_end')
                                                    <p class="error invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div><!-- .input-group -->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!-- .table-responsive -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">정기 휴관일</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <p class="card-text text-muted mb-3">* 주의)정기휴관일 변경시 관람안내 및 예약페이지의 안내사항도 함께 변경하여 방문자에게 혼란을 주지 않도록 합니다.</p>

                        <div>
                            @foreach(['일', '월', '화', '수', '목', '금', '토'] as $idx => $weekDay)
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input
                                            type="checkbox"
                                            name="closed_weekday[]"
                                            @class([
                                                'form-check-input',
                                            ])
                                            @checked(in_array($idx, old('closed_weekday', $config->closed_weekday ?? [])))
                                            value="{{ $idx }}"
                                        />
                                        <span>{{ $weekDay }}</span>
                                    </label>
                                </div><!-- .form-check -->
                            @endforeach
                        </div>
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">휴관일 별도 지정</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="jt-repeater" data-repeater-content="data-repeater-content" data-repeater-template="data-repeater-item">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th class="wd-50-f text-center">순서</th>
                                            <th class="text-center">시작일/종료일</th>
                                            <th class="wd-100-f"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="jt-handle-sort" data-repeater-content>
                                        @foreach(old('closed_dates', $config->closed_dates ?? []) as $idx => $value)
                                            @load_partials('admin.ticket.partials.config-closed', compact('idx', 'value'))
                                        @endforeach
                                    </tbody>
                                </table>

                            </div><!-- .table-responsive -->

                            <div class="mt-3 text-end">
                                <button type="button" class="btn btn-secondary btn-sm" data-repeater-add>추가</button>
                            </div>
                        </div><!-- .jt-repeater -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">업데이트</button>
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div><!-- .row -->
    </form>

    <template data-repeater-item>
        @load_partials('admin.ticket.partials.config-closed')
    </template>
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
<script src="/assets/admin/js/repeater.js"></script>
<script>
$('#postForm').on('submit', function () {
    const $form = $(this);

    try {
        $form.find('.jt-repeater').each(function () {
            $(this).find('[data-repeater-content] > *').each(function (idx) {
                $(this).find('[name]').each(function () {
                    $(this).attr('name', $(this).attr('name').replace(/\[\]/, `[${idx}]`));
                });
            });
        });
    } catch (e) {
        console.log(e);
    }

    return true;
});
</script>
@endPush
