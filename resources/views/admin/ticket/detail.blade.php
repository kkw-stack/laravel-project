@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '관람권 상세' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">관람권 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form id="postForm" method="post" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">관람권 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-4">
                            <label for="ticketTitle" class="form-label">관람권명 <em>*</em></label>

                            <div class="row">
                                <div class="col">
                                    <input
                                        type="text"
                                        id="ticketTitle"
                                        placeholder="관람권명을 입력해주세요. (공백포함, 20자 이내)"
                                        name="title[ko]"
                                        maxlength="20"
                                        value="{{ old('title.ko', $ticket->title['ko'] ?? null) }}"
                                        @class([
                                            'form-control',
                                            'is-invalid' => $errors->has('title.ko'),
                                        ])
                                    />

                                    @error('title.ko')
                                        <p class="error invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col">
                                    <input
                                        type="text"
                                        placeholder="영문을 입력해주세요. (공백포함, 60자 이내)"
                                        name="title[en]"
                                        maxlength="60"
                                        value="{{ old('title.en', $ticket->title['en'] ?? null) }}"
                                        @class([
                                            'form-control',
                                            'is-invalid' => $errors->has('title.en'),
                                        ])
                                    />

                                    @error('title.en')
                                        <p class="error invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label for="ticketArea" class="form-label">관람구역 <em>*</em></label>

                            <div class="row">
                                <div class="col">
                                    <input
                                        type="text"
                                        id="ticketArea"
                                        placeholder="관람구역을 입력해주세요. (공백포함, 20자 이내)"
                                        name="sector[ko]"
                                        maxlength="20"
                                        value="{{ old('sector.ko', $ticket->sector['ko'] ?? null) }}"
                                        @class([
                                            'form-control',
                                            'is-invalid' => $errors->has('sector.ko'),
                                        ])
                                    />

                                    @error('sector.ko')
                                        <p class="error invalid-feedback">{{ $message }}</p>
                                    @enderror('sector.ko')
                                </div>

                                <div class="col">
                                    <input
                                        type="text"
                                        placeholder="영문을 입력해주세요. (공백포함, 80자 이내)"
                                        name="sector[en]"
                                        maxlength="80"
                                        value="{{ old('sector.en', $ticket->sector['en'] ?? null) }}"
                                        @class([
                                            'form-control',
                                            'is-invalid' => $errors->has('sector.en'),
                                        ])
                                    />

                                    @error('sector.en')
                                        <p class="error invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">관람시간</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <p class="card-text text-muted mb-3">* 관람시간별 정보 변경시, 변경된 시점부터 사용자 예약화면에 반영되며, 이미 결제 처리된 예약건은 변경되지 않습니다.</p>

                        <div class="jt-repeater" data-repeater-content="data-repeater-content" data-repeater-template="data-repeater-item" data-repeater-max="144">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th class="wd-50-f text-center">순서</th>
                                            <th class="text-center">관람시간/관람인원</th>
                                            <th class="wd-100-f"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="jt-handle-sort" data-repeater-content>
                                        @forelse(old('time_table', $ticket->time_table ?? []) as $idx => $data)
                                            @load_partials('admin.ticket.partials.detail-time-table', [...compact('idx', 'data'), 'name' => 'time_table'])
                                        @empty
                                            @load_partials('admin.ticket.partials.detail-time-table', ['name' => 'time_table'])
                                        @endforelse
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

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h2 class="card-title mb-0">야간 관람시간</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">

                        <div class="mb-0">
                            <span class="form-label d-block">사용 여부</span>

                            <div class="form-check form-switch">
                                <label class="form-check-label">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        name="use_night_time_table"
                                        value="1"
                                        @checked(old('use_night_time_table', $ticket?->use_night_time_table ?? false))
                                    />
                                    <span class="text-muted">사용</span>
                                </label>
                            </div><!-- .form-check -->
                        </div>

                        <div
                            @class([
                                'period-wrapper',
                                'mt-3',
                                'd-none' => !old('use_night_time_table', $ticket?->use_night_time_table ?? false),
                            ])
                        >
                            <p class="card-text text-muted mb-3">* 야간 관람가능 시간을 입력해주세요. 시작일과 종료일 입력시 매년 동일한 기간에 적용됩니다.</p>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="ticketStartDate" class="form-label">시작일 <em>*</em></label>

                                    <div class="input-group js-flatpickr-date" data-format="m-d" data-alt-format="m. d" data-hide="year">
                                        <input
                                            type="text"
                                            id="ticketStartDate"
                                            name="night_start_date"
                                            data-input
                                            value="{{ old('night_start_date', $ticket?->night_start_date ?? null) }}"
                                            @class([
                                                'form-control',
                                                'is-invalid' => $errors->has('night_start_date'),
                                            ])
                                        />
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>

                                        @error('night_start_date')
                                            <p class="error invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div><!-- .input-group -->
                                </div><!-- .col -->
                                <div class="col-md-6">
                                    <label for="ticketEndDate" class="form-label">종료일 <em>*</em></label>

                                    <div class="input-group js-flatpickr-date" data-format="m-d" data-alt-format="m. d" data-hide="year">
                                        <input
                                            type="text"
                                            id="ticketEndDate"
                                            name="night_end_date"
                                            data-input
                                            value="{{ old('night_end_date', $ticket?->night_end_date ?? null) }}"
                                            @class([
                                                'form-control',
                                                'is-invalid' => $errors->has('night_end_date'),
                                            ])
                                        />
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>

                                        @error('night_end_date')
                                            <p class="error invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div><!-- .input-group -->
                                </div><!-- .col -->
                            </div><!-- .row -->

                            <div class="jt-repeater" data-repeater-content="data-repeater-content" data-repeater-template="data-repeater-night" data-repeater-max="144">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th class="wd-50-f text-center">순서</th>
                                                <th class="text-center">관람시간/관람인원</th>
                                                <th class="wd-100-f"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="jt-handle-sort" data-repeater-content>
                                            @forelse(old('night_time_table', $ticket?->night_time_table ?? []) as $idx => $data)
                                                @load_partials('admin.ticket.partials.detail-time-table', [...compact('idx', 'data'), 'name' => 'night_time_table'])
                                            @empty
                                                @load_partials('admin.ticket.partials.detail-time-table', ['name' => 'night_time_table'])
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div><!-- .table-responsive -->

                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-secondary btn-sm" data-repeater-add>추가</button>
                                </div>
                            </div><!-- .jt-repeater -->
                        </div><!-- .period-wrapper -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">가격정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <p class="card-text text-muted mb-3">* 가격정보 변경시, 변경된 시점부터 결제 금액이 변경되며, 이전 결제 처리된 금액은 변경되지 않습니다.</p>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th class="wd-150-f text-center">대상</th>
                                        <th class="text-center">성수기</th>
                                        <th class="text-center">비성수기</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(App\Models\Ticket::PRICE_LABELS as $name => $label)
                                        @load_partials('admin.ticket.partials.detail-price', [...compact('name', 'label'), 'data' => old('price', $ticket?->price ?? [])[$name] ?? null])
                                    @endforeach
                                </tbody>
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">외국인</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(App\Models\Ticket::PRICE_FOREIGN_LABELS as $name => $label)
                                        @load_partials('admin.ticket.partials.detail-price', [...compact('name', 'label'), 'data' => old('price', $ticket?->price ?? [])[$name] ?? null])
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- .table-responsive -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">예약 불가 날짜/시간 별도 지정</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <p class="card-text text-muted mb-3">* 지정된 날짜와 방문시간에는 예약을 할 수 없도록 설정합니다.</p>

                        <div class="jt-repeater" data-repeater-content="data-repeater-content" data-repeater-template="data-repeater-disabled" data-repeater-max="24">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th class="wd-50-f text-center">순서</th>
                                            <th class="text-center">날짜/시간</th>
                                            <th class="wd-100-f"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="jt-handle-sort" data-repeater-content>
                                        @foreach(old('disable_time_table', $ticket?->disable_time_table ?? []) as $idx => $data)
                                            @load_partials('admin.ticket.partials.detail-disable-time-table', compact('idx', 'data'))
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

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">발행 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-0">
                            <span class="form-label d-block">상태 <em>*</em></span>

                            <div class="d-flex gap-1">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            class="form-check-input"
                                            name="status"
                                            value="1"
                                            @checked(true === ($ticket?->status ?? true))
                                        />
                                        <span>공개</span>
                                    </label>
                                </div><!-- .form-check -->

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            class="form-check-input"
                                            name="status"
                                            value="0"
                                            @checked(true !== ($ticket?->status ?? true))
                                        />
                                        <span>비공개(+판매중지)</span>
                                    </label>
                                </div><!-- .form-check -->
                            </div>

                        </div>
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                                <div class="d-flex gap-1">
                                    <button type="submit" class="btn btn-primary">{{ isset($ticket) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.ticket.list') }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($ticket))
                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-danger" id="postDelete">삭제</button>
                                </div><!-- .col -->
                            @endif
                        </div><!-- .row -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div><!-- .row -->
    </form>

    @if(isset($ticket))
        <form method="POST" id="postDeleteForm">
            @csrf
            @method('DELETE')
        </form>
    @endif

    <template data-repeater-item>
        @load_partials('admin.ticket.partials.detail-time-table', ['name' => 'time_table'])
    </template>

    <template data-repeater-night>
        @load_partials('admin.ticket.partials.detail-time-table', ['name' => 'night_time_table'])
    </template>

    <template data-repeater-disabled>
        @load_partials('admin.ticket.partials.detail-disable-time-table')
    </template>
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
<script src="/assets/admin/js/repeater.js"></script>
<script>
'use strict';

$('[name="use_night_time_table"]').on('change', function () {
    $(this).closest('.card-body').find('.period-wrapper').toggleClass('d-none');
});

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

@pushIf(isset($ticket), 'scripts')
<script>
$(function () {
    'use strict';

    $('#postDelete').on('click', (function(e){
        if (confirm('{{ __('jt.AL-04') }}')) {
            $('#postDeleteForm').trigger('submit');
        }
    }));
});
</script>
@endPushIf
