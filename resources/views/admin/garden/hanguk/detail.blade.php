@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '한국정원' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">한국정원 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">기본 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="boardTitle" class="form-label">항목명 <em>*</em></label>
                            <input
                                type="text"
                                id="boardTitle"
                                name="title"
                                placeholder="항목명을 입력해주세요. (공백 포함, 70자 이내)"
                                maxlength="70"
                                value="{{ old('title', $garden?->title ?? '')}}"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('title'),
                                ])
                            />

                            @error('title')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="boardContent" class="form-label">내용 <em>*</em></label>
                            <textarea
                                id="boardContent"
                                row="4"
                                name="content"
                                placeholder="내용을 입력해주세요. (공백 포함, 300자 이내)"
                                maxlength="300"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('content'),
                                ])
                            >{{ old('content', $garden?->content ?? '') }}</textarea>

                            @error('content')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 jt-file-with-preview">
                                <label for="boardDeskImage" class="form-label">PC 이미지 <em>*</em></label>
                                <p class="mt-n1 mb-2 text-muted">사이즈 1264 x 720 px, 2MB 이하 jpg, png, webp</p>

                                <div
                                    @class([
                                        'jt-image-preview',
                                        'mb-2',
                                        'mt-3',
                                        'd-none' => empty($garden?->image),
                                    ])
                                >
                                    <div class="wd-100-f position-relative">
                                        <img class="img-thumbnail wd-100 ht-100" alt="" src="{{ empty($garden?->image) ? '' : Storage::url($garden->image) }}" />
                                        <button type="button" class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border-0 rounded-circle">
                                            <span class="visually-hidden">Delete image</span>
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
                                        'is-invalid' => $errors->has('image'),
                                    ])
                                />

                                @error('image')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div><!-- .col -->

                            <div class="col-md-6 jt-file-with-preview">
                                <label for="boardMobileImage" class="form-label">모바일 이미지</label>
                                <p class="mt-n1 mb-2 text-muted">사이즈 640 x 860 px, 2MB 이하 jpg, png, webp</p>

                                <div
                                    @class([
                                        'jt-image-preview',
                                        'mb-2',
                                        'mt-3',
                                        'd-none' => empty($garden?->image_mobile),
                                    ])
                                >
                                    <div class="wd-100-f position-relative">
                                        <img class="img-thumbnail wd-100 ht-100" alt="" src="{{ empty($garden?->image_mobile) ? '' : Storage::url($garden->image_mobile) }}" />
                                        <button type="button" class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border-0 rounded-circle">
                                            <span class="visually-hidden">Delete image</span>
                                            <i class="icon-sm text-white" data-feather="x"></i>
                                        </button>
                                    </div>
                                </div><!-- .jt-image-preview -->

                                <input
                                    type="file"
                                    id="boardMobileImage"
                                    accept="image/jpeg, image/png, image/webp"
                                    data-size="2"
                                    name="image_mobile"
                                    @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('image_mobile'),
                                    ])
                                />

                                @error('image_mobile')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div><!-- .col -->
                        </div><!-- .row -->

                        <div class="row mb-0">
                            <div class="col-md-6 jt-file-with-preview">
                                <label for="boardDeskUrl" class="form-label">PC 영상</label>
                                <p class="mt-n1 mb-2 text-muted">
                                    비메오 영상 주소(video file link) <br />
                                    최적 사이즈 1264 x 720 px
                                </p>
                                <input
                                    type="text"
                                    id="boardDeskUrl"
                                    placeholder="비메오 영상 주소를 입력해주세요."
                                    name="video"
                                    value="{{ old('video', $garden?->video ?? '') }}"
                                    @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('video'),
                                    ])
                                />

                                @error('video')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div><!-- .col -->

                            <div class="col-md-6 jt-file-with-preview">
                                <label for="boardMobileUrl" class="form-label">모바일 영상</label>
                                <p class="mt-n1 mb-2 text-muted">
                                    비메오 영상 주소(video file link) <br />
                                    최적 사이즈 640 x 860 px
                                </p>
                                <input
                                    type="text"
                                    id="boardMobileUrl"
                                    placeholder="비메오 영상 주소를 입력해주세요."
                                    name="video_mobile"
                                    value="{{ old('video_mobile', $garden?->video_mobile ?? '') }}"
                                    @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('video_mobile'),
                                    ])
                                />

                                @error('video_mobile')
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
                                    <option value="{{ $category->id }}" @selected(old('category_id', ($garden?->category_id ?? null) == $category->id))>{{ $category->title }}</option>
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
                                            @checked(old('status', $garden?->status ?? false))
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
                                            @checked(old('status', $garden?->status ?? false) == false)
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
                                    value="{{ old('published_at', $garden?->published_at ?? null) }}"
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
                                    <button type="submit" class="btn btn-primary">{{ isset($garden) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.garden.hanguk.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($garden))
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

    @if(isset($garden))
        <form method="POST" id="postDeleteForm">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
@endPush

@pushIf(isset($garden), 'scripts')
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
