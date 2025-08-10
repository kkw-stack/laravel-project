@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '행사' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">행사 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">행사 정보</h2>
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
                                value="{{ old('title', $event?->title ?? '') }}"
                            />
                            @error('title')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="boardContent" class="form-label">내용 <em>*</em></label>
                            <textarea
                                id="boardContent"
                                rows="10"
                                name="content"
                                @class([
                                    'form-control',
                                    'js-tinymce-editor',
                                    'is-invalid' => $errors->has('content'),
                                ])
                            >{{ old('content', $event?->content ?? '') }}</textarea>
                            @error('content')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="boardLocation" class="form-label">장소</label>
                            <input
                                type="text"
                                id="boardLocation"
                                placeholder="장소를 입력해주세요. (공백포함, 30자 이내)"
                                maxlength="30"
                                name="location"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('location'),
                                ])
                                value="{{ old('location', $event?->location ?? '') }}"
                            />
                            @error('location')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <span class="form-label d-block">파일첨부</span>
                            <div class="alert alert-secondary" role="alert">
                                <i data-feather="alert-circle"></i>
                                <b>포멧</b>
                                <ul class="mt-1 m-0">
                                    <li>지원 확장자 : zip, ppt, pptx, pdf, jpg, jpeg, png, webp, xlsx</li>
                                    {{-- <li>최대 수량 : 최대 10개</li> --}}
                                    <li>최대 용량 : 10MB</li>
                                </ul>
                            </div><!-- .alert -->

                            <div class="jt-customfile">
                                <div class="jt-customfile__field d-grid">
                                    <input
                                        type="file"
                                        id="boardFiles"
                                        name="files[]"
                                        multiple
                                        @class([
                                            'js-jt-file',
                                            'is-invalid' => $errors->has('files.*'),
                                        ])
                                    />
                                    <button type="button" tabindex="-1" class="jt-customfile__button btn btn-inverse-dark btn-lg"><span>추가하기</span></button>
                                    @error('files.*')
                                        <p class="error invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div><!-- .jt-customfile__field -->

                                <div class="jt-customfile__list mt-3 d-flex flex-wrap gap-1">
                                    @if(isset($event))
                                        @foreach($event->files as $file)
                                            <button type="button" class="btn btn-outline-dark btn-icon-text btn-xs">
                                                <input type="hidden" name="delete_files[]" value={{ $file->id }} disabled />
                                                <span>{{ $file->file_name }}</span>
                                                <i class="btn-icon-append" data-feather="x"></i>
                                            </button>
                                        @endforeach
                                    @endif
                                </div><!-- .jt-customfile__list -->
                            </div><!-- .jt-customfile -->
                        </div>
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
                                        @checked(old() ? old('use_always', false) : $event?->use_always ?? false)
                                    />
                                    <span class="text-muted">상시로 설정할 경우 시작일 종료일 없이 게시글이 “진행중” 탭에 계속 노출됩니다.</span>
                                </label>
                            </div><!-- .form-check -->
                        </div>

                        <div
                            @class([
                                'mb-3',
                                'jt-date-wrapper',
                                'd-none' => old() ? old('use_always', false) : $event?->use_always ?? false,
                            ])
                        >
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
                                    value="{{ old('start_date', $event?->start_date ?? null)}}"
                                />
                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                @error('start_date')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div><!-- .input-group -->
                        </div>

                        <div
                            @class([
                                'mb-0',
                                'jt-date-wrapper',
                                'd-none' => old() ? old('use_always', false) : $event?->use_always ?? false,
                            ])
                        >
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
                                    value="{{ old('end_date', $event?->end_date ?? null)}}"
                                />
                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                @error('end_date')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div><!-- .input-group -->
                        </div>
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">썸네일 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="jt-file-with-preview">
                            <label for="boardThumb" class="form-label">썸네일 <em>*</em></label>
                            <p class="mt-n1 mb-2 text-muted">* 최적 사이즈 952 x 952 px, 2MB 이하 jpg, png, webp 파일형식으로 등록 가능합니다.</p>

                            <div class="jt-image-preview mb-2 mt-3 {{ isset($event) ? 'd-block' : 'd-none' }}">
                                <div class="wd-100-f position-relative">
                                    <img
                                        class="img-thumbnail wd-100 ht-100"
                                        alt=""
                                        src="{{ isset($event) ? Storage::url($event->thumbnail) : '' }}"
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
                                        <input type="radio" class="form-check-input" name="status" value="1" @checked(old('status', $event?->status ?? false)) />
                                        <span>공개</span>
                                    </label>
                                </div><!-- .form-check -->

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="status" value="0" @checked(old('status', $event?->status ?? false) == false) />
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
                                    value="{{ old('published_at', $event?->published_at ?? null)}}"
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
                                    <button type="submit" class="btn btn-primary">{{ isset($event) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.event.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($event))
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

    @if(isset($event))
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

@pushIf(isset($event), 'scripts')
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
