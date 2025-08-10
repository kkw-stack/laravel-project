<tr>
    <td class="jt-handle-sort__grap text-center fs-5">
        <i class="mdi mdi-menu"></i>
    </td>
    <td>
        <div class="d-flex align-items-center text-nowrap">
            <div class="me-2 flex-fill">
                <select
                    name="{{ $name }}[][time]"
                    @class([
                        'form-select',
                        'is-invalid' => isset($idx) && $errors->has("{$name}.{$idx}.time"),
                    ])
                >
                    <option value="">시간을 선택해주세요.</option>
                    @for($i = 0; $i < 24; $i++)
                        <optgroup label="{{ $i }}시">
                            @for($j = 0; $j < 60; $j += 10)
                                <option value="{{ sprintf('%02d:%02d', $i, $j) }}" 
                                    @selected(isset($idx) && $data['time'] == sprintf('%02d:%02d', $i, $j))>
                                    {{ sprintf('%02d:%02d', $i, $j) }}
                                </option>
                            @endfor
                        </optgroup>
                    @endfor
                </select>

                @if(isset($idx))
                    @error("{$name}.{$idx}.time")
                        <p class="error invalid-feedback">{{ $message }}</p>
                    @enderror
                @endif
            </div>

            <div class="me-2 flex-fill">
                <input
                    type="number"
                    placeholder="수량을 입력해주세요."
                    name="{{ $name }}[][total]"
                    min="1"
                    max="999"
                    value="{{ $data['total'] ?? null }}"
                    @class([
                        'form-control',
                        'is-invalid' => isset($idx) && $errors->has("{$name}.{$idx}.total"),
                    ])
                />

                @if(isset($idx))
                    @error("{$name}.{$idx}.total")
                        <p class="error invalid-feedback">{{ $message }}</p>
                    @enderror
                @endif
            </div>

            <div class="form-check">
                <label class="form-check-label">
                    <input
                        type="checkbox"
                        name="{{ $name }}[][docent]"
                        value="1"
                        @checked($data['docent'] ?? false)
                        @class([
                            'form-check-input',
                        ])
                    />
                    <span class="text-muted">해설사 동반</span>
                </label><!-- .form-check-label -->
            </div><!-- .form-check -->
        </div>
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-xs btn-outline-danger" data-repeater-remove>삭제</button>
    </td>
</tr>
