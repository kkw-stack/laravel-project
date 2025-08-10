@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '서비스 이용약관' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">서비스 이용약관 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">서비스 이용약관 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="boardTitle" class="form-label">제목 <em>*</em></label>
                            <input
                                type="text"
                                id="boardTitle"
                                placeholder="제목을 입력해주세요. (공백포함, 20자 이내)"
                                maxlength="20"
                                name="title"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('title'),
                                ])
                                value="{{ old('title', $service?->title ?? '') }}"
                            />
                            @error('title')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-0">
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
                            >{{ old('content', $service?->content ?? '') }}</textarea>
                            @error('content')
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
                        <div class="mb-3">
                            <span class="form-label d-block">상태 <em>*</em></span>

                            <div class="d-flex gap-1">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="status" value="1" @checked(old('status', $service?->status ?? false)) />
                                        <span>공개</span>
                                    </label>
                                </div><!-- .form-check -->

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="status" value="0" @checked(old('status', $service?->status ?? false) == false) />
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
                                    value="{{ old('published_at', $service?->published_at ?? null)}}"
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
                                    <button type="submit" class="btn btn-primary">{{ isset($service) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.service.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($service))
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

    @if(isset($service))
        <form method="POST" id="postDeleteForm">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
@endPush

@pushIf(isset($service), 'scripts')
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
