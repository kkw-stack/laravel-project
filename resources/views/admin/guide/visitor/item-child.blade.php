@php
$idx = $idx ?? 0;
$childIdx = $childIdx ?? 0;
$value = $value ?? '';
@endphp

<tr class="align-middle">
    <td class="jt-handle-sort__grap wd-50-f text-center fs-5"><i class="mdi mdi-menu"></i></td>
    <td>
        <textarea
            rows="4"
            placeholder="내용을 입력해주세요. (공백포함, 1,000자 이내)"
            maxlength="1000"
            name="content[][array][]"
            @class([
                'form-control',
                'is-invalid' => isset($idx) && $errors->has("content.{$idx}.array.{$childIdx}"),
            ])
        >{{ isset($idx) ? old("content.{$idx}.array.{$childIdx}", $value ?? '') : null }}</textarea>

        @if(isset($idx))
            @error("content.{$idx}.array.{$childIdx}")
                <p class="error invalid-feedback">{{ $message }}</p>
            @enderror
        @endif
    </td>

    <td class="wd-100-f text-center">
        <button
            type="button"
            class="btn btn-xs btn-outline-danger"
            data-repeater-remove
        >삭제</button>
    </td>
</tr>
