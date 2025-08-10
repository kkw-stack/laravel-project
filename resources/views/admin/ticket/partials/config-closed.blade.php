<tr>
    <td class="jt-handle-sort__grap text-center fs-5">
        <i class="mdi mdi-menu"></i>
    </td>
    <td>
        <div class="d-flex align-items-center text-nowrap">
            <div class="input-group js-flatpickr-date me-2">
                <input
                    type="text"
                    name="closed_dates[][start]"
                    data-input
                    placeholder="시작일을 입력해주세요."
                    @class([
                        'form-control',
                        'is-invalid' => isset($idx) && $errors->has("closed_dates.{$idx}.start"),
                    ])
                    value="{{ isset($idx) ? old("closed_dates.{$idx}.start", $value['start'] ?? null): null }}"
                />
                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>

                @if(isset($idx))
                    @error("closed_dates.{$idx}.start")
                        <p class="error invalid-feedback">{{ $message }}</p>
                    @enderror
                @endif
            </div><!-- .input-group -->

            <div class="input-group js-flatpickr-date">
                <input
                    type="text"
                    name="closed_dates[][end]"
                    data-input
                    placeholder="종료일을 입력해주세요."
                    @class([
                        'form-control',
                        'is-invalid' => isset($idx) && $errors->has("closed_dates.{$idx}.end"),
                    ])
                    value="{{ isset($idx) ? old("closed_dates.{$idx}.end", $value['end'] ?? null) : null }}"
                />
                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>

                @if(isset($idx))
                    @error("closed_dates.{$idx}.end")
                        <p class="error invalid-feedback">{{ $message }}</p>
                    @enderror
                @endif
            </div><!-- .input-group -->
        </div>
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-xs btn-outline-danger" data-repeater-remove>삭제</button>
    </td>
</tr>
