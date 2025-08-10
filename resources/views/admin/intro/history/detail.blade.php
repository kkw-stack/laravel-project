@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '걸어온 길' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">걸어온 길 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form id="postForm" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">기본 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="boardYear" class="form-label">연도 <em>*</em></label>
                            <input
                                type="text"
                                id="boardYear"
                                name="year"
                                placeholder="연도을 입력해주세요. (공백 포함, 4자 이내)"
                                maxlength="4"
                                value="{{ old('year', $history?->year ?? '')}}"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('year'),
                                ])
                            />

                            @error('year')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <div class="jt-repeater" data-repeater-content="data-repeater-content" data-repeater-template="data-repeater-item" data-repeater-min="1">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th class="wd-50-f text-center">순서</th>
                                                <th>내용</th>
                                                <th class="wd-100-f"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="jt-handle-sort" data-repeater-content>
                                            @forelse(old('content', $history?->content ?? []) as $idx => $value)
                                                @load_partials('admin.intro.history.partials.detail-content', compact('idx', 'value'))
                                            @empty
                                                @load_partials('admin.intro.history.partials.detail-content')
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div><!-- .table-responsive -->

                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-secondary btn-sm" data-repeater-add>추가</button>
                                </div>
                            </div><!-- .jt-repeater -->
                        </div>
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->


            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">카테고리 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="row">
                            <label for="boardCategory" class="form-label">카테고리 <em>*</em></label>

                            <select
                                name="category_id"
                                @class([
                                    'form-select',
                                    'is-invalid' => $errors->has('category_id'),
                                ])
                            >
                                <option value="">카테고리를 선택해주세요.</option>

                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', ($history?->category_id ?? null) == $category->id))>{{ $category->title }}</option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">발행 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <span class="form-label d-block">상태 <em>*</em></span>

                            <div @class([
                                'd-flex',
                                'gap-1',
                                'is-invalid' => $errors->has('status')
                            ])>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            class="form-check-input"
                                            name="status"
                                            value="1"
                                            @checked(old('status', $history?->status ?? false))
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
                                            @checked(old('status', $history?->status ?? false) == false)
                                        />
                                        <span>비공개</span>
                                    </label>
                                </div><!-- .form-check -->
                            </div>

                            @error('status')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="boardDate" class="form-label">등록일</label>

                            <div class="input-group flatpickr js-flatpickr-datetime">
                                <input
                                    type="text"
                                    id="boardDate"
                                    name="published_at"
                                    data-input
                                    @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('published_at'),
                                    ])
                                    value="{{ old('published_at', $history?->published_at ?? null) }}"
                                />
                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>

                                @error('published_at')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div><!-- .input-group -->
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
                                    <button type="submit" class="btn btn-primary">{{ isset($history) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.intro.history.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($history))
                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-danger" id="postDelete">삭제</button>
                                </div><!-- .col -->
                            @endif
                        </div><!-- .rwo -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div><!-- .row -->
    </form>

    <template data-repeater-item>
        @load_partials('admin.intro.history.partials.detail-content')
    </template>

    @if(isset($history))
        <form method="POST" id="postDeleteForm">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
<script src="/assets/admin/js/repeater.js"></script>
<script>
$('#postForm').on('change', '[name="content[][use_image]"]', function () {
    $(this).closest('td').find('.image-wrapper').toggleClass('d-none');
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

@pushIf(isset($history), 'scripts')
<script>
'use strict';

$(function () {
    $('#postDeleteForm').on('submit', function () {
        return confirm('{{ __('jt.AL-04') }}');
    });

    $('#postDelete').on('click', function () {
        $('#postDeleteForm').trigger('submit');
    });
});
</script>
@endPushIf
