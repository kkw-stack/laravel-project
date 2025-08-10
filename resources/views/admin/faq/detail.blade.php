@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '자주묻는질문' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">자주묻는질문 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form method="POST" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">공지 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="boardQuestion" class="form-label">질문 <em>*</em></label>
                            <input
                                type="text"
                                id="boardQuestion"
                                placeholder="질문을 입력해주세요. (공백포함, 100자 이내)"
                                maxlength="70"
                                name="question"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('question'),
                                ])
                                value="{{ old('question', $faq?->question ?? '') }}"
                            />
                            @error('question')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="boardAnswer" class="form-label">답변 <em>*</em></label>
                            <textarea
                                id="boardAnswer"
                                rows="10"
                                name="answer"
                                maxlength="1000"
                                placeholder="답변을 입력해주세요. (공백포함, 1000자 이내)"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('answer'),
                                ])
                            >{{ old('answer', $faq?->answer ?? '') }}</textarea>

                            @error('answer')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="boardCategory" class="form-label">카테고리 <em>*</em></label>

                            <select
                                name="faq_category_id"
                                @class([
                                    'form-select',
                                    'is-invalid' => $errors->has('faq_category_id'),
                                ])
                            >
                                <option value="">카테고리를 선택해주세요.</option>

                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('faq_category_id', isset($faq) ? $faq->category->id : null) === $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>

                            @error('faq_category_id')
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
                                        <input type="radio" class="form-check-input" name="status" value="1" @checked(old('status', $faq?->status ?? false)) />
                                        <span>공개</span>
                                    </label>
                                </div><!-- .form-check -->

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="status" value="0" @checked(old('status', $faq?->status ?? false) == false) />
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
                                    value="{{ old('published_at', $faq?->published_at ?? null)}}"
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
                                    <button type="submit" class="btn btn-primary">{{ isset($faq) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.faq.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($faq))
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

    @if(isset($faq))
        <form method="POST" id="postDeleteForm">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
@endPush

@pushIf(isset($faq), 'scripts')
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
