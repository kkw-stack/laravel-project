@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '관람안내' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">관람안내 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form id="postForm" method="POST" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">상세 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="boardTitle" class="form-label">제목 <em>*</em></label>
                            <input
                                type="text"
                                id="boardTitle"
                                name="title"
                                placeholder="제목을 입력해주세요. (공백포함, 50자 이내)"
                                maxlength="50"
                                value="{{ old('title', $guide?->title ?? '') }}"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('title')
                                ])
                            />
                            @error('title')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <div class="jt-repeater" data-repeater-content="data-repeater-parent-content" data-repeater-template="data-repeater-parent" data-repeater-min="1">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody class="jt-handle-sort" data-repeater-parent-content>
                                            @forelse(old('content', $guide?->content ?? []) as $idx => $content)
                                                @load_partials('admin.guide.visitor.item', compact('idx', 'content'))
                                            @empty
                                                @load_partials('admin.guide.visitor.item')
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div><!-- .table-responsive -->

                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-secondary btn-sm " data-repeater-add>추가</button>
                                </div>
                            </div><!-- .jt-repeater -->
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

                            <div
                                @class([
                                    'd-flex',
                                    'gap-1',
                                    'is-invalid' => $errors->has('status'),
                                ])
                            >
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            class="form-check-input"
                                            name="status"
                                            value="1"
                                            @checked(old('status', $guide?->status ?? false))
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
                                            @checked(old('status', $guide?->status ?? false) == false)
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
                                    data-input
                                    name="published_at"
                                    value="{{ old('published_at', $guide?->published_at ?? null )}}"
                                    @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('published_at'),
                                    ])
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
                                    <button type="submit" class="btn btn-primary">{{ isset($guide) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.guide.visitor.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($guide))
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

    <template data-repeater-parent>
        @load_partials('admin.guide.visitor.item')
    </template>

    <template data-repeater-child>
        @load_partials('admin.guide.visitor.item-child')
    </template>

    @if(isset($guide))
        <form method="POST" id="postDeleteForm">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
<script src="/assets/admin/js/repeater.js"></script>
<script>
$(function () {
    $(document).on('change', '.form-check-input__use_table', function () {
        $(this).closest('.mb-3').next().toggleClass('d-none');
        $(this).closest('.mb-3').next().next().toggleClass('d-none');
    });

    $('#postForm').on('submit', function () {
        const $form = $(this);

        try {
            $form.find('.jt-repeater [data-repeater-parent-content] > *').each(function (idx) {
                $(this).find('[name]').each(function () {
                    $(this).attr('name', $(this).attr('name').replace(/\[\]/, `[${idx}]`));
                });

                $(this).find('.jt-repeater [data-repeater-child-content] > *').each(function (subIdx) {
                    $(this).find('[name]').each(function () {
                        $(this).attr('name', $(this).attr('name').replace(/\[\]/, `[${subIdx}]`));
                    });
                });
            });
        } catch (e) {
            console.log(e);
        }

        return true;
    });
});
</script>
@endPush

@pushIf(isset($guide), 'scripts')
<script>
    $('#postDeleteForm').on('submit', (function(e){
        return confirm('{{ __('jt.AL-04') }}');
    }));

    $('#postDelete').on('click', (function(e){
        $('#postDeleteForm').trigger('submit');
    }));
</script>
@endPushIf
