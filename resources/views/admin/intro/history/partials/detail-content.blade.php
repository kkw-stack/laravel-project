<tr>
    <td class="jt-handle-sort__grap text-center fs-5">
        <i class="mdi mdi-menu"></i>
    </td>
    <td>
        <div class="mb-3">
            <label class="form-label">내용 <em>*</em></label>
            <textarea
                id="boardContent"
                row="4"
                name="content[][content]"
                placeholder="내용을 입력해주세요. (공백 포함, 200자 이내)"
                maxlength="200"
                @class([
                    'form-control',
                    'is-invalid' => isset($idx) && $errors->has("content.{$idx}.content"),
                ])
            >{{ isset($idx) ? old("content.{$idx}.content", $value['content'] ?? null) : null }}</textarea>

            @if(isset($idx))
                @error("content.{$idx}.content")
                    <p class="error invalid-feedback">{{ $message }}</p>
                @enderror
            @endif
        </div>

        <div class="mb-3">
            <span class="form-label d-block">이미지</span>

            <div class="form-check form-switch">
                <label class="form-check-label">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        name="content[][use_image]"
                        value="1"
                        @checked($value['use_image'] ?? false)
                    />
                    <span class="text-muted">사용</span>
                </label>
            </div><!-- .form-check -->
        </div>

        <div
            @class([
                'image-wrapper',
                'p-3',
                'border',
                'd-none' => !($value['use_image'] ?? false),
            ])
        >

            <div class="mb-3">
                <span class="form-label d-block">이미지 사이즈 <em>*</em></span>
                <select
                    name="content[][size]"
                    @class([
                        'form-select',
                    ])
                >
                    <option value="type-02" @selected('type-02' === ($value['size'] ?? null))>사이즈: 696 x 696</option>
                    <option value="type-01" @selected('type-01' === ($value['size'] ?? null))>사이즈: 696 x 800</option>
                </select>
            </div>

            <div class="jt-file-with-preview">
                <span class="form-label d-block">이미지 파일 <em>*</em></span>
                <p class="mt-n1 mb-2 text-muted">2MB 이하 jpg, png, webp 파일형식으로 등록 가능합니다.</p>

                <div
                    @class([
                        'jt-image-preview',
                        'mb-2',
                        'mt-3',
                        'd-none' => empty($value['image']),
                    ])
                >
                    <div class="wd-100-f position-relative">
                        <img class="img-thumbnail wd-100 ht-100" alt="" src="{{ empty($value['image']) ? '' : Storage::url($value['image']) }}" />
                        <button type="button" class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border-0 rounded-circle">
                            <span class="visually-hidden">Delete image</span>
                            <i class="icon-sm text-white" data-feather="x"></i>
                        </button>
                    </div>
                </div><!-- .jt-image-preview -->

                <input
                    type="file"
                    accept="image/jpeg, image/png, image/webp"
                    data-size="2"
                    name="content[][image]"
                    @class([
                        'form-control',
                        'is-invalid' => isset($idx) && $errors->has("content.{$idx}.image"),
                    ])
                />

                @if(isset($idx))
                    <input type="hidden" name="content[][image_path]" value="{{ $value['image'] ?? null }}" />
                    @error("content.{$idx}.image")
                        <p class="error invalid-feedback">{{ $message }}</p>
                    @enderror
                @endif
            </div><!-- .jt-file-with-preview -->
        </div>
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-xs btn-outline-danger" data-repeater-remove>삭제</button>
    </td>
</tr>
