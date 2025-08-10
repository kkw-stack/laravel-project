@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '메덩골 풍경' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">메덩골 풍경 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">메덩골 풍경 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="boardTitle" class="form-label">제목 <em>*</em></label>
                            <input
                                type="text"
                                id="boardTitle"
                                placeholder="제목을 입력해주세요. (공백포함, 200자 이내)"
                                maxlength="200"
                                name="title"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('title'),
                                ])
                                value="{{ old('title', $scenery?->title ?? '') }}"
                            />
                            @error('title')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div><!-- .card-body -->

                    <div class="card-body">
                        <label for="boardCategory" class="form-label">카테고리 <em>*</em></label>

                        <select
                            name="scenery_category_id"
                            @class([
                                'form-select',
                                'is-invalid' => $errors->has('scenery_category_id'),
                            ])
                        >
                            <option value="">카테고리를 선택해주세요.</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('scenery_category_id', isset($scenery) ? $scenery->category->id : null) === $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>

                        @error('scenery_category_id')
                            <p class="error invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">이미지 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="jt-file-with-preview">
                            <label for="boardThumb" class="form-label">이미지 <em>*</em></label>
                            <p class="mt-n1 mb-2 text-muted">* 최적 사이즈 1920 X 954px, 2MB 이하 jpg, png, webp 파일형식으로 등록 가능합니다.
                            </p>

                            <div class="jt-image-preview mb-2 mt-3 {{ isset($scenery) ? 'd-block' : 'd-none' }}">
                                <div class="wd-100-f position-relative">
                                    <img
                                        class="img-thumbnail wd-100 ht-100"
                                        alt=""
                                        src="{{ isset($scenery) ? Storage::url($scenery->thumbnail) : '' }}"
                                    />
                                    <button type="button" class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border-0 rounded-circle">
                                        <span class="visually-hidden">Delete image</span>
                                        <i class="icon-sm text-white" data-feather="x"></i>
                                    </button>
                                </div>
                            </div><!-- .jt-image-preview -->

                            <input
                                type="file"
                                id="boardThumb"
                                name="thumbnail"
                                accept="image/jpeg, image/png, image/webp"
                                data-size="2"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('thumbnail'),
                                ])
                            />
                            @error('thumbnail')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div><!-- .jt-file-with-preview -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">발행 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <span class="form-label d-block">상태 <em>*</em></span>

                            <div class="d-flex gap-1">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="status" value="1" @checked(old('status', $scenery?->status ?? false)) />
                                        <span>공개</span>
                                    </label>
                                </div><!-- .form-check -->

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="status" value="0" @checked(old('status', $scenery?->status ?? false) == false) />
                                        <span>비공개</span>
                                    </label>
                                </div><!-- .form-check -->
                            </div>
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
                                    value="{{ old('published_at', $scenery?->published_at ?? null)}}"
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
                                    <button type="submit" class="btn btn-primary">{{ isset($scenery) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.scenery.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($scenery))
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

    @if(isset($scenery))
        <form method="POST" id="postDeleteForm">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
<script>
$(function () {
    'use strict';

    $('[name="use_always"]').on('change', function () {
        $('[name="start_date"]').closest('div.jt-date-wrapper').toggleClass('d-none');
        $('[name="end_date"]').closest('div.jt-date-wrapper').toggleClass('d-none');
    });
});
</script>
@endPush

@pushIf(isset($scenery), 'scripts')
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
