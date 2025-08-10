@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '자주묻는질문' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">자주묻는질문 카테고리 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">카테고리 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="boardTitle" class="form-label">카테고리명 <em>*</em></label>
                            <input
                                type="text"
                                id="boardTitle"
                                placeholder="카테고리명을 입력해주세요. (공백포함, 50자 이내)"
                                maxlength="50"
                                name="name"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('name'),
                                ])
                                value="{{ old('name', $category?->name ?? '') }}"
                            />
                            @error('name')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="boardContent" class="form-label">추가 설명</label>
                            <textarea
                                id="boardContent"
                                rows="4"
                                name="description"
                                placeholder="추가 설명을 입력해주세요. (공백포함, 200자 이내)"
                                maxlength="200"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('content'),
                                ])
                            >{{ old('description', $category?->description ?? '') }}</textarea>
                            @error('description')
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
                                    <button type="submit" class="btn btn-primary">{{ isset($category) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.scenery.category.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($category))
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

    @if(isset($category) && $category->sceneries->count() === 0)
        <form id="formDelete" method="post" action="{{ route('admin.scenery.category.delete', compact('category'))}}">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
@endPush

@pushIf(isset($category), 'scripts')
<script>
'use strict';

$(function () {
    $('#formDelete').on('submit', function () {
        return confirm('{{ __('jt.AL-04') }}');
    });

    $('#postDelete').on('click', function () {
        if ($('#formDelete').length > 0) {
            $('#formDelete').trigger('submit');
        } else {
            alert('{{ __('jt.AL-05', ['count' => $category->sceneries->count()]) }}');
        }
    });
});
</script>
@endPushIf
