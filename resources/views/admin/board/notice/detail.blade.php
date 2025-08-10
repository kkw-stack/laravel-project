@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '공지' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">공지 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">공지 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <span class="form-label d-block">공지 여부</span>

                            <div class="form-check form-switch">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="is_notice" value="1" @checked(old('is_notice', $notice?->is_notice ?? false)) />
                                    <span class="text-muted">해당 게시글을 최상단 붙박이로 고정시킵니다. 고정된 게시글은 최신순으로 배치됩니다.</span>
                                </label>
                            </div><!-- .form-check -->
                        </div>

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
                                value="{{ old('title', $notice?->title ?? '') }}"
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
                            >{{ old('content', $notice?->content ?? '') }}</textarea>
                            @error('content')
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
                                    @if(isset($notice))
                                        @foreach($notice->files as $file)
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
                        <h2 class="card-title mb-0">발행 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <span class="form-label d-block">상태 <em>*</em></span>

                            <div class="d-flex gap-1">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="status" value="1" @checked(old('status', $notice?->status ?? false)) />
                                        <span>공개</span>
                                    </label>
                                </div><!-- .form-check -->

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="status" value="0" @checked(old('status', $notice?->status ?? false) == false) />
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
                                    value="{{ old('published_at', $notice?->published_at ?? null)}}"
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
                                    <button type="submit" class="btn btn-primary">{{ isset($notice) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.notice.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($notice))
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

    @if(isset($notice))
        <form method="POST" id="postDeleteForm">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
@endPush

@pushIf(isset($notice), 'scripts')
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
