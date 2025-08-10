<tr>
    <td class="jt-handle-sort__grap text-center fs-5">
        <i class="mdi mdi-menu"></i>
    </td>
    <td>
        <div class="d-flex align-items-center text-nowrap">
            <div class="input-group js-flatpickr-date me-2">
                <input
                    type="text"
                    name="disable_time_table[][date]"
                    data-input
                    placeholder="방문날짜를 선택해주세요."
                    value="{{ $data['date'] ?? null }}"
                    @class([
                        'form-control',
                        'is-invalid' => isset($idx) && $errors->has("disable_time_table.{$idx}.date"),
                    ])
                />
                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>

                @if(isset($idx))
                    @error("disable_time_table.{$idx}.date")
                        <p class="error invalid-feedback">{{ $message }}</p>
                    @enderror
                @endif
            </div><!-- .input-group -->

            <div class="input-group">
                <select
                    name="disable_time_table[][time]"
                    @class([
                        'form-select',
                        'is-invalid' => isset($idx) && $errors->has("disable_time_table.{$idx}.time"),
                    ])
                >
                    <option value="">방문시간을 선택해주세요.</option>
                    @for($i = 0; $i < 24; $i++)
                        <optgroup label="{{ $i }}시">
                            @for($j = 0; $j < 60; $j += 10)
                                <option value="{{ sprintf('%02d:%02d', $i, $j) }}" 
                                    @selected(sprintf('%02d:%02d', $i, $j) == ($data['time'] ?? null))>
                                    {{ sprintf('%02d:%02d', $i, $j) }}
                                </option>
                            @endfor
                        </optgroup>
                    @endfor
                </select>

                @if(isset($idx))
                    @error("disable_time_table.{$idx}.time")
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
