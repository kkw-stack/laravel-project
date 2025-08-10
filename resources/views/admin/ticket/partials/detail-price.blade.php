<tr>
<td>{{ $label }}</td>
<td>
    <input
        type="number"
        placeholder="금액을 입력해주세요."
        min="0"
        max="999999"
        name="price[{{ $name }}][peak]"
        value="{{ $data['peak'] ?? null }}"
        @class([
            'form-control',
            'is-invalid' => $errors->has("price.{$name}.peak"),
        ])
    />

    @error("price.{$name}.peak")
        <p class="error invalid-feedback">{{ $message }}</p>
    @enderror
</td>
<td>
    <input
        type="number"
        placeholder="금액을 입력해주세요."
        min="0"
        max="999999"
        name="price[{{ $name }}][off]"
        value="{{ $data['off'] ?? null }}"
        @class([
            'form-control',
            'is-invalid' => $errors->has("price.{$name}.off"),
        ])
    />

    @error("price.{$name}.off")
        <p class="error invalid-feedback">{{ $message }}</p>
    @enderror
</td>
</tr>
