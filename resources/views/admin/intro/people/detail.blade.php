@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '함께한 사람들' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">함께한 사람들 상세</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <form id="postForm" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">기본 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="boardTitle" class="form-label">이름 <em>*</em></label>
                            <input
                                type="text"
                                id="boardTitle"
                                name="name"
                                placeholder="이름을 입력해주세요. (공백 포함, 50자 이내)"
                                maxlength="50"
                                value="{{ old('name', $people->name ?? '')}}"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('name'),
                                ])
                            />

                            @error('name')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="boardDesc" class="form-label">한줄소개 <em>*</em></label>
                            <input
                                type="text"
                                id="boardDesc"
                                name="intro"
                                placeholder="한줄소개를 입력해주세요. (공백 포함, 50자 이내)"
                                maxlength="50"
                                value="{{ old('intro', $people->intro ?? '')}}"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('intro'),
                                ])
                            />

                            @error('intro')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="jt-file-with-preview">
                            <label for="boardThumb" class="form-label">썸네일 <em>*</em></label>
                            <p class="mt-n1 mb-2 text-muted">* 최적 사이즈 696 x 800 px, 2MB 이하 jpg, png, webp 파일형식으로 등록 가능합니다.</p>

                            <div
                                @class([
                                    'jt-image-preview',
                                    'mb-2',
                                    'mt-3',
                                    'd-none' => empty($people?->thumbnail),
                                ])
                            >
                                <div class="wd-100-f position-relative">
                                    <img class="img-thumbnail wd-100 ht-100" alt="" src="{{ empty($people?->thumbnail) ? '' : Storage::url($people->thumbnail) }}" />
                                    <button type="button" class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border-0 rounded-circle">
                                        <span class="visually-hidden">Delete thumbnail</span>
                                        <i class="icon-sm text-white" data-feather="x"></i>
                                    </button>
                                </div>
                            </div><!-- .jt-image-preview -->

                            <input
                                type="file"
                                id="boardThumb"
                                accept="image/jpeg, image/png, image/webp"
                                data-size="2"
                                name="thumbnail"
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
                        <h2 class="card-title mb-0">인터뷰 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <span class="form-label d-block">인터뷰 영상</span>

                            <div class="form-check form-switch">
                                <label class="form-check-label">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        name="use_video"
                                        value="1"
                                        @checked(old('use_video', $people?->use_video ?? true))
                                    />
                                    <span class="text-muted">사용</span>
                                </label>
                            </div><!-- .form-check -->
                        </div>

                        <div
                            @class([
                                'interview-wrapper',
                                'd-none' => !old('use_video', $people?->use_video ?? true),
                            ])
                        >
                            <div
                                @class([
                                    'jt-file-with-preview',
                                    'mb-3',
                                ])
                            >
                                <label for="boardVideoPoster" class="form-label">이미지 <em>*</em></label>
                                <p class="mt-n1 mb-2 text-muted">* 최적 사이즈 1632 x 918 px, 2MB 이하 jpg, png, webp 파일형식으로 등록 가능합니다.</p>

                                <div
                                    @class([
                                        'jt-image-preview',
                                        'mb-2',
                                        'mt-3',
                                        'd-none' => empty($people?->image),
                                    ])
                                >
                                    <div class="wd-100-f position-relative">
                                        <img class="img-thumbnail wd-100 ht-100" alt="" src="{{ empty($people?->image) ? '' : Storage::url($people->image) }}" />
                                        <button type="button" class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border-0 rounded-circle">
                                            <span class="visually-hidden">Delete image</span>
                                            <i class="icon-sm text-white" data-feather="x"></i>
                                        </button>
                                    </div>
                                </div><!-- .jt-image-preview -->

                                <input
                                    type="file"
                                    id="boardVideoPoster"
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
                            </div><!-- .jt-file-with-preview -->

                            <div class="mb-0">
                                <label for="boardVideoUrl" class="form-label">영상</label>
                                <p class="mt-n1 mb-2 text-muted">
                                    비메오 영상, ID 예) 123456789 <br />
                                    최적 사이즈 1920 x 1080 px
                                </p>

                                <input
                                    type="text"
                                    id="boardVideoUrl"
                                    placeholder="비메오 영상 주소를 입력해주세요."
                                    name="video"
                                    value="{{ old('video', $people?->video ?? '') }}"
                                    class="form-control"
                                />
                            </div>
                        </div>
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">상세 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="boardContent" class="form-label">내용 <em>*</em></label>
                            <textarea
                                id="boardContent"
                                rows="10"
                                name="content"
                                maxlength="1000"
                                placeholder="내용을 입력해주세요. (공백 포함, 1,000자 이내)"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('content'),
                                ])
                            >{{ old('content', $people?->content ?? '') }}</textarea>

                            @error('content')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <span class="form-label d-block">파일첨부</span>
                            <div class="alert alert-secondary" role="alert">
                                <i data-feather="alert-circle"></i>
                                <b>포멧</b>
                                <ul class="mt-1 m-0">
                                    <li>지원 확장자 : zip, ppt, pptx, pdf, jpg, jpeg, png, webp, xlsx</li>
                                    <li>최대 용량 : 10MB</li>
                                </ul>
                            </div><!-- .alert -->

                            <div class="jt-customfile">
                                <div class="jt-customfile__field d-grid">
                                    <input
                                        type="file"
                                        id="boardFiles"
                                        name="files"
                                        data-count="1"
                                        @class([
                                            'js-jt-file',
                                            'is-invalid' => $errors->has('files'),
                                        ])
                                    />
                                    <button type="button" tabindex="-1" class="jt-customfile__button btn btn-inverse-dark btn-lg"><span>추가하기</span></button>
                                    @error('files')
                                        <p class="error invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div><!-- .jt-customfile__field -->

                                <div class="jt-customfile__list mt-3 d-flex flex-wrap gap-1">
                                    @if(isset($people) && $people->files->isNotEmpty())
                                        <button type="button" class="btn btn-outline-dark btn-icon-text btn-xs">
                                            <input type="hidden" name="delete_files[]" value={{ $people->files->first()->id }} disabled />
                                            <span>{{ $people->files->first()->file_name }}</span>
                                            <i class="btn-icon-append" data-feather="x"></i>
                                        </button>
                                    @endif
                                </div><!-- .jt-customfile__list -->
                            </div><!-- .jt-customfile -->
                        </div>

                        <div class="mb-3">
                            <label for="boardProject" class="form-label">대표작</label>
                            <input
                                type="text"
                                id="boardProject"
                                name="masterpiece"
                                placeholder="대표작 입력해주세요. (공백 포함, 200자 이내)"
                                maxlength="200"
                                value="{{ old('masterpiece', $people->masterpiece ?? '')}}"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('masterpiece'),
                                ])
                            />

                            @error('masterpiece')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <span class="form-label d-block">함께한 메덩골 프로젝트</span>

                            <div class="jt-repeater" data-repeater-content="data-repeater-content" data-repeater-template="data-repeater-item" data-repeater-min="1">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody class="jt-handle-sort" data-repeater-content>
                                            @forelse(old('project', $people?->project ?? []) as $idx => $value)
                                                @load_partials('admin.intro.people.item', compact('idx', 'value'))
                                            @empty
                                                @load_partials('admin.intro.people.item')
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div><!-- .table-responsive -->

                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-secondary btn-sm" data-repeater-add>추가</button>
                                </div>
                            </div><!-- .jt-repeater -->
                        </div>
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">카테고리 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-0">
                            <span class="form-label d-block">카테고리 <em>*</em></span>

                            <select
                                name="category_id"
                                @class([
                                    'form-select',
                                    'is-invalid' => $errors->has('category_id'),
                                ])
                            >
                                <option value="">카테고리를 선택해주세요.</option>

                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', ($people?->category_id ?? null) == $category->id))>{{ $category->title }}</option>
                                @endforeach
                            </select>

                            @error('category_id')
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

                            <div @class(['is-invalid' => $errors->has('status')])>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input
                                            type="radio"
                                            class="form-check-input"
                                            name="status"
                                            value="1"
                                            @checked(old('status', $people?->status ?? false))
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
                                            @checked(old('status', $people?->status ?? false) == false)
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
                                    value="{{ old('published_at', $people?->published_at ?? null) }}"
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
                                    <button type="submit" class="btn btn-primary">{{ isset($people) ? '수정' : '등록' }}</button>
                                    <a href="{{ route('admin.intro.people.list', request()->query()) }}" class="btn btn-light" id="postCancel">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($people))
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

    <template data-repeater-item>
        @load_partials('admin.intro.people.item')
    </template>

    @if(isset($people))
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
    $('[name="use_video"]').on('change', function () {
        $(this).closest('.card-body').find('.interview-wrapper').toggleClass('d-none');
    });

    $('#postForm').on('submit', function () {
        const $form = $(this);

        try {
            $form.find('.jt-repeater').each(function () {
                $(this).find('[data-repeater-content] > *').each(function (idx) {
                    $(this).find('[name]').each(function () {
                        $(this).attr('name', $(this).attr('name').replace(/\[\]/, `[${idx}]`));
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

@pushIf(isset($people), 'scripts')
<script>
    $('#postDeleteForm').on('submit', (function(e){
        return confirm('{{ __('jt.AL-04') }}');
    }));

    $('#postDelete').on('click', (function(e){
        $('#postDeleteForm').trigger('submit');
    }));
</script>
@endPushIf
