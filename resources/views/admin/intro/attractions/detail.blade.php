@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '주변 볼거리' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">주변 볼거리 상세</h1>
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
                            <label for="boardTitle" class="form-label">장소명 <em>*</em></label>
                            <input
                                type="text"
                                id="boardTitle"
                                placeholder="장소명을 입력해주세요. (공백포함, 50자 이내)"
                                name="title"
                                maxlength="50"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('title')
                                ])
                                value="{{ old('title', $attraction?->title ?? '') }}"
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
                                placeholder="내용을 입력해주세요. (공백 포함, 1,000자 이내)"
                                maxlength="1000"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('content'),
                                ])
                            >{{ old('content', $attraction?->content ?? '') }}</textarea>
                            @error('content')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="boardOrigin" class="form-label">사진출처</label>
                            <input
                                type="text"
                                id="boardOrigin"
                                placeholder="사진출처를 입력해주세요. (공백포함, 50자 이내)"
                                maxlength="50"
                                name="source"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('source'),
                                ])
                                value="{{ old('source', $attraction?->source ?? '') }}"
                            />
                            @error('source')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="boardDistance" class="form-label">거리(km) <em>*</em></label>
                            <input
                                type="number"
                                id="boardDistance"
                                placeholder="숫자로 입력해주세요. (5자 이내)"
                                name="distance"
                                data-maxlength="5"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('distance')
                                ])
                                value="{{ old('distance', $attraction?->distance ?? null) }}"
                            />

                            @error('distance')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="jt-file-with-preview mb-0">
                            <label for="boardThumb" class="form-label">이미지 <em>*</em></label>
                            <p class="mt-n1 mb-2 text-muted">* 최적 사이즈 1464 x 1000px, 2MB 이하 jpg, png, webp 파일형식으로 등록 가능합니다.</p>

                            <div
                                @class([
                                    'jt-image-preview',
                                    'mb-2',
                                    'mt-3',
                                    'd-block' => isset($attraction),
                                    'd-none' => !isset($attraction),
                                ])
                            >
                                <div class="wd-100-f position-relative">
                                    <img
                                        class="img-thumbnail wd-100 ht-100"
                                        alt=""
                                        src="{{ isset($attraction) ? Storage::url($attraction->thumbnail) : '' }}"
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
                                            @checked(old('status', $attraction?->status ?? false))
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
                                            @checked(old('status', $attraction?->status ?? false) == false)
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
                                    value="{{ old('published_at', $attraction?->published_at ?? null)}}"
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
                                    <button type="submit" class="btn btn-primary">{{ isset($attraction) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.intro.attractions.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($attraction))
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

    @if(isset($attraction))
        <form method="POST" action="{{ route('admin.intro.attractions.delete', compact('attraction')) }}" id="postDeleteForm">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
@endPush

@pushIf(isset($attraction), 'scripts')
<script>
    $('#postDeleteForm').on('submit', e => confirm('{{ __('jt.AL-04') }}'));
    $('#postDelete').on('click', (function(e){
        $('#postDeleteForm').trigger('submit');
    }));
</script>
@endPushIf
