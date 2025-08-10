@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '팝업' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">팝업 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">팝업 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-4">
                            <label for="boardTitle" class="form-label">제목 <em>*</em></label>
                            <input
                                type="text"
                                id="boardTitle"
                                placeholder="제목을 입력해주세요. (공백포함, 70자 이내)"
                                name="title"
                                maxlength="70"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('title')
                                ])
                                value="{{ old('title', $popup?->title ?? '') }}"
                            />

                            @error('title')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="jt-file-with-preview">
                                <label for="boardDeskImage" class="form-label">이미지 <em>*</em></label>
                                <p class="mt-n1 mb-2 text-muted">* 가로/세로 3:4 비율 권장, 2MB 이하 jpg, png, webp 파일형식으로 등록 가능합니다.</p>

                                <div
                                    @class([
                                        'jt-image-preview',
                                        'mb-2',
                                        'mt-3',
                                        'd-none' => empty($popup?->image),
                                    ])
                                >
                                    <div class="wd-100-f position-relative">
                                        <img class="img-thumbnail wd-100 ht-100" alt="" src="{{ empty($popup?->image) ? '' : Storage::url($popup->image) }}" />
                                        <button type="button" class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border-0 rounded-circle">
                                            <span class="popuply-hidden">Delete image</span>
                                            <i class="icon-sm text-white" data-feather="x"></i>
                                        </button>
                                    </div>
                                </div><!-- .jt-image-preview -->

                                <input
                                    type="file"
                                    id="boardDeskImage"
                                    accept="image/jpeg, image/png, image/webp"
                                    data-size="2"
                                    name="image"
                                    @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('image')
                                    ])
                                />

                                @error('image')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">기간 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <span class="form-label d-block">상시 여부</span>

                            <div class="form-check form-switch">
                                <label class="form-check-label">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        name="use_always"
                                        value="1"
                                        @checked(old('use_always', $popup?->use_always ?? false))
                                    />
                                    <span class="text-muted">상시</span>
                                </label>
                            </div><!-- .form-check -->
                        </div>

                        <div
                            @class([
                                'period-wrapper',
                                'd-none' => old('use_always', $popup?->use_always ?? false),
                            ])
                        >
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="boardStartDate" class="form-label">시작일 <em>*</em></label>

                                    <div class="input-group flatpickr js-flatpickr-datetime">
                                        <input
                                            type="text"
                                            id="boardStartDate"
                                            name="start_date"
                                            data-input
                                            @class([
                                                'form-control',
                                                'is-invalid' => $errors->has('start_date'),
                                            ])
                                            value="{{ old('start_date', $popup?->start_date ?? null)}}"
                                        />
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                        @error('start_date')
                                            <p class="error invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div><!-- .input-group -->
                                </div><!-- .col -->

                                <div class="col-md-6 mt-3 mt-md-0">
                                    <label for="boardEndDate" class="form-label">종료일 <em>*</em></label>

                                    <div class="input-group flatpickr js-flatpickr-datetime">
                                        <input
                                            type="text"
                                            id="boardEndDate"
                                            name="end_date"
                                            data-input
                                            @class([
                                                'form-control',
                                                'is-invalid' => $errors->has('end_date'),
                                            ])
                                            value="{{ old('end_date', $popup?->end_date ?? null)}}"
                                        />
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                        @error('end_date')
                                            <p class="error invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div><!-- .input-group -->
                                </div><!-- .col -->
                            </div><!-- .row -->
                        </div><!-- .period-wrapper -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">링크 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <span class="form-label d-block">팝업링크</span>
                            <p class="mt-n1 mb-2 text-muted">* 팝업 클릭시 이동되는 페이지의 URL 주소를 입력하여 사용할 수 있습니다.</p>

                            <div>
                                <input
                                    type="url"
                                    id="boardUrl"
                                    name="url"
                                    placeholder="URL 주소를 입력해주세요. ex) https://www.studio-jt.co.kr"
                                    @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('url'),
                                    ])
                                    value="{{ old('url', $popup?->url ?? null)}}"
                                />
                                @error('url')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        name="target"
                                        value="1"
                                        @checked(old('target', $popup?->target ?? false))
                                    />
                                    <span class="text-muted">새창으로 링크 열기</span>
                                </label>
                            </div><!-- .form-check -->
                        </div>
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">위치 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="row mb-0">
                            <p class="mt-n1 mb-2 text-muted">* 팝업이 하나일때, 여백값을 입력하지 않으면 화면 중앙에 위치합니다.</p>
                            <div class="col-md-6">
                                <label for="boardLocationTop" class="form-label">상단 여백</label>

                                <div
                                    @class([
                                        'input-group',
                                        'is-invalid' => $errors->has('top'),
                                    ])
                                >
                                    <input
                                        type="number"
                                        id="boardLocationTop"
                                        name="top"
                                        class="form-control"
                                        value="{{ old('top', $popup?->top ?? '') }}"
                                    />
                                    <div class="input-group-append">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>

                                @error('top')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div><!-- .col -->

                            <div class="col-md-6 mt-3 mt-md-0">
                                <label for="boardLocationLeft" class="form-label">좌측 여백</label>

                                <div
                                    @class([
                                        'input-group',
                                        'is-invalid' => $errors->has('top'),
                                    ])
                                >
                                    <input
                                        type="number"
                                        id="boardLocationLeft"
                                        name="left"
                                        class="form-control"
                                        value="{{ old('left', $popup?->left ?? '') }}"
                                    />
                                    <div class="input-group-append">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>

                                @error('left')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">발행 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-0">
                            <span class="form-label d-block">상태 <em>*</em></span>

                            <div @class(['is-invalid' => $errors->has('status')])>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            class="form-check-input"
                                            name="status"
                                            value="1"
                                            @checked(old('status', $popup?->status ?? false))
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
                                            @checked(old('status', $popup?->status ?? false) == false)
                                        />
                                        <span>비공개</span>
                                    </label>
                                </div><!-- .form-check -->
                            </div>

                            @error('status')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
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
                                    <button type="submit" class="btn btn-primary">{{ isset($popup) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.main.popup.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($popup))
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

    @if(isset($popup))
        <form method="POST" action="{{ route('admin.main.popup.delete', compact('popup')) }}" id="postDeleteForm">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
<script>
'use strict';

$('[name="use_always"]').on('change', function () {
    $(this).closest('.card-body').find('.period-wrapper').toggleClass('d-none');
});
</script>
@endPush

@pushIf(isset($popup), 'scripts')
<script>
    $('#postDelete').on('click', (function(e){
        if (confirm('{{ __('jt.AL-04') }}')) {
            $('#postDeleteForm').trigger('submit');
        }
    }));
</script>
@endPushIf
