@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '언론뉴스' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">언론뉴스 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">언론뉴스 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <span class="form-label d-block">외부링크 사용</span>

                            <div class="form-check form-switch">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="use_link" value="1" @checked(old('use_link', $news?->use_link ?? false)) />
                                    <span class="text-muted">외부링크 사용시 상세페이지가 아닌 입력된 링크로 새창이 열립니다.</span>
                                </label>
                            </div><!-- .form-check -->
                        </div>
                        <div
                            @class([
                                'mb-3',
                                'd-none' => !old('use_link', $news?->use_link ?? false),
                            ])
                        >
                            <label for="boardTitle" class="form-label">외부링크 <em>*</em></label>
                            <p class="mt-n1 mb-2 text-muted">링크주소 입력시 https:// 또는 http:// 를 앞에 꼭 입력해주세요.</p>
                            <input
                                type="url"
                                id="boardLink"
                                placeholder="링크를 입력해주세요."
                                name="link"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('link'),
                                ])
                                value="{{ old('link', $news?->link ?? '') }}"
                            />
                            @error('link')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
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
                                value="{{ old('title', $news?->title ?? '') }}"
                            />
                            @error('title')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div
                            @class([
                                'mb-0',
                                'd-none' => old('use_link', $news?->use_link ?? false),
                            ])
                        >
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
                            >{{ old('content', $news?->content ?? '') }}</textarea>
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
                                        <input type="radio" class="form-check-input" name="status" value="1" @checked(old('status', $news?->status ?? false)) />
                                        <span>공개</span>
                                    </label>
                                </div><!-- .form-check -->

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="status" value="0" @checked(old('status', $news?->status ?? false) == false) />
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
                                    value="{{ old('published_at', $news?->published_at ?? null)}}"
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
                                    <button type="submit" class="btn btn-primary">{{ isset($news) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.news.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($news))
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

    @if(isset($news))
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

    $('[name="use_link"]').on('change', function () {
        $('[name="link"]').closest('div').toggleClass('d-none');
        $('[name="content"]').closest('div').toggleClass('d-none');
    });
});
</script>
@endPush

@pushIf(isset($news), 'scripts')
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
