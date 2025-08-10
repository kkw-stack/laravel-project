@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '비주얼 슬라이드' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">비주얼 슬라이드 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">슬라이드 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-4">
                            <label for="boardTitle" class="form-label">제목 <em>*</em></label>
                            <input
                                type="text"
                                id="boardTitle"
                                name="title"
                                placeholder="제목을 입력해주세요. (공백포함, 70자 이내)"
                                maxlength="70"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('title')
                                ])
                                value="{{ old('title', $visual?->title ?? '') }}"
                            />

                            @error('title')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 jt-file-with-preview">
                                <label for="boardDeskImage" class="form-label">PC 이미지 <em>*</em></label>
                                <p class="mt-n1 mb-2 text-muted">사이즈 1903 x 954 px, 2MB 이하 jpg, png, webp</p>

                                <div
                                    @class([
                                        'jt-image-preview',
                                        'mb-2',
                                        'mt-3',
                                        'd-none' => empty($visual?->thumbnail),
                                    ])
                                >
                                    <div class="wd-100-f position-relative">
                                        <img class="img-thumbnail wd-100 ht-100" alt="" src="{{ empty($visual?->thumbnail) ? '' : Storage::url($visual->thumbnail) }}" />
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
                                    name="thumbnail"
                                    @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('thumbnail')
                                    ])
                                />

                                @error('thumbnail')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div><!-- .col -->

                            <div class="col-md-6 jt-file-with-preview">
                                <label for="boardMobileImage" class="form-label">모바일 이미지</label>
                                <p class="mt-n1 mb-2 text-muted">사이즈 780 x 1688 px, 2MB 이하 jpg, png, webp</p>

                                <div
                                    @class([
                                        'jt-image-preview',
                                        'mb-2',
                                        'mt-3',
                                        'd-none' => empty($visual?->thumbnail_mobile),
                                    ])
                                >
                                    <div class="wd-100-f position-relative">
                                        <img class="img-thumbnail wd-100 ht-100" alt="" src="{{ empty($visual?->thumbnail_mobile) ? '' : Storage::url($visual->thumbnail_mobile) }}" />
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
                                    name="thumbnail_mobile"
                                    @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('thumbnail_mobile')
                                    ])
                                />

                                @error('thumbnail_mobile')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div><!-- .col -->
                        </div><!-- .row -->

                        <div class="row mb-3">
                            <div class="col-md-6 jt-file-with-preview">
                                <label for="boardDeskUrl" class="form-label">PC 영상</label>
                                <p class="mt-n1 mb-2 text-muted">
                                    비메오 영상 주소(video file link) <br />
                                    최적 사이즈 1904 x 954 px
                                </p>
                                <input
                                    type="text"
                                    id="boardDeskUrl"
                                    placeholder="비메오 영상 주소를 입력해주세요."
                                    name="video"
                                    value="{{ old('video', $visual?->video ?? '') }}"
                                    @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('video')
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
                                    최적 사이즈 780 x 1688 px
                                </p>
                                <input
                                    type="text"
                                    id="boardMobileUrl"
                                    placeholder="비메오 영상 주소를 입력해주세요."
                                    name="video_mobile"
                                    value="{{ old('video_mobile', $visual?->video_mobile ?? '') }}"
                                    @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('video_mobile')
                                    ])
                                />

                                @error('video_mobile')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div><!-- .col -->
                        </div><!-- .row -->

                        <div class="mb-3">
                            <span class="form-label d-block">날씨 아이콘 <em>*</em></span>

                            <div @class([
                                'd-flex',
                                'gap-1',
                                'flex-wrap',
                                'is-invalid' => $errors->has('weather_icon')
                            ])>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            name="weather_icon"
                                            value="sun"
                                            class="form-check-input"
                                            @checked(old('weather_icon', $visual?->weather_icon ?? 'none') === 'sun')
                                        />
                                        <span>해</span>
                                    </label>
                                </div><!-- .form-check -->

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            name="weather_icon"
                                            value="moon"
                                            class="form-check-input"
                                            @checked(old('weather_icon', $visual?->weather_icon ?? 'none') === 'moon')
                                        />
                                        <span>밤(달)</span>
                                    </label>
                                </div><!-- .form-check -->

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            name="weather_icon"
                                            value="cloud"
                                            class="form-check-input"
                                            @checked(old('weather_icon', $visual?->weather_icon ?? 'none') === 'cloud')
                                        />
                                        <span>안개</span>
                                    </label>
                                </div><!-- .form-check -->

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            name="weather_icon"
                                            value="rain"
                                            class="form-check-input"
                                            @checked(old('weather_icon', $visual?->weather_icon ?? 'none') === 'rain')
                                        />
                                        <span>비</span>
                                    </label>
                                </div><!-- .form-check -->

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            name="weather_icon"
                                            value="snow"
                                            class="form-check-input"
                                            @checked(old('weather_icon', $visual?->weather_icon ?? 'none') === 'snow')
                                        />
                                        <span>눈</span>
                                    </label>
                                </div><!-- .form-check -->

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            name="weather_icon"
                                            value="none"
                                            class="form-check-input"
                                            @checked(old('weather_icon', $visual?->weather_icon ?? 'none') === 'none')
                                        />
                                        <span>없음</span>
                                    </label>
                                </div><!-- .form-check -->
                            </div>

                            @error('weather_icon')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="boardDesc" class="form-label">설명</label>
                            <input
                                type="text"
                                id="boardDesc"
                                placeholder="날씨에 맞는 설명을 입력해주세요. (공백포함, 100자 이내)"
                                maxlength="100"
                                name="description"
                                value="{{ old('description', $visual?->description ?? '') }}"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('description'),
                                ])
                            />

                            @error('description')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
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
                                            @checked(old('status', $visual?->status ?? false))
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
                                            @checked(old('status', $visual?->status ?? false) == false)
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
                                    <button type="submit" class="btn btn-primary">{{ isset($visual) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.main.visual.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($visual))
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

    @if(isset($visual))
        <form method="POST" action="{{ route('admin.main.visual.delete', compact('visual')) }}" id="postDeleteForm">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
@endPush

@pushIf(isset($visual), 'scripts')
<script>
    $('#postDelete').on('click', (function(e){
        if (confirm('{{ __('jt.AL-04') }}')) {
            $('#postDeleteForm').trigger('submit');
        }
    }));
</script>
@endPushIf
