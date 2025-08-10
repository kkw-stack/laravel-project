@php
$idx = $idx ?? 0;
$value = $value ?? [];
@endphp

<tr class="align-middle">
    <td class="jt-handle-sort__grap wd-50-f text-center fs-5"><i class="mdi mdi-menu"></i></td>
    <td>
        <div class="jt-file-with-preview mb-3">
            <span class="form-label d-block">이미지</span>
            <p class="mt-n1 mb-2 text-muted">* 최적 사이즈 784 x 480 px, 2MB 이하 jpg, png, webp 파일형식으로 등록 가능합니다.</p>

            <div
                @class([
                    'jt-image-preview',
                    'mb-2',
                    'mt-3',
                    'd-none' => empty($value['image']) && empty($value['image_path']),
                ])
            >
                <div class="wd-100-f position-relative">
                    <img
                        class="img-thumbnail wd-100 ht-100"
                        alt=""
                        src="{{ empty($value['image']) && empty($value['image_path']) ? '' : Storage::url($value['image'] ?? $value['image_path']) }}"
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
                accept="image/jpeg, image/png, image/webp"
                data-size="2"
                name="project[][image]"
                class ="form-control"
            />

            @if(isset($idx))
                <input type="hidden" name="project[][image_path]" value="{{ $value['image'] ?? ($value['image_path'] ?? null) }}" />

                @error("project.{$idx}.image")
                    <p class="error invalid-feedback">{{ $message }}</p>
                @enderror
            @endif
        </div><!-- .jt-file-with-preview -->

        <div class="mb-3">
            <span class="form-label d-block">설명 <em>*</em></span>
            <input
                type="text"
                placeholder="설명을 입력해주세요. (공백 포함, 50자 이내)"
                maxlength="50"
                name="project[][explanation]"
                value="{{ isset($idx) ? old("project.{$idx}.explanation", $value['explanation'] ?? '') : null }}"
                @class([
                    'form-control',
                    'is-invalid' => isset($idx) && $errors->has("project.{$idx}.explanation")
                ])
            />

            @if(isset($idx))
                @error("project.{$idx}.explanation")
                    <p class="error invalid-feedback">{{ $message }}</p>
                @enderror
            @endif
        </div>
    </td>

    <td class="wd-100-f text-center">
        <button
            type="button"
            class="btn btn-xs btn-outline-danger"
            data-repeater-remove
        >삭제</button>
    </td>
</tr>
