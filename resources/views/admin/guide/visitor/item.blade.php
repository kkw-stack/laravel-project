@php
$idx = $idx ?? 0;
$content = $content ?? [];
$useTable = (bool)(old("content.{$idx}.use_table", $content['use_table'] ?? false)) !== false;
@endphp

<tr class="align-middle">
    <td class="jt-handle-sort__grap wd-50-f text-center fs-5"><i class="mdi mdi-menu"></i></td>
    <td>
        <div class="mb-3">
            <span class="form-label d-block">항목명</span>
            <input
                type="text"
                placeholder="항목명을 입력해주세요. (공백포함, 100자 이내)"
                maxlength="100"
                name="content[][title]"
                value="{{ isset($idx) ? old("content.{$idx}.title", $content['title'] ?? '') : null }}"
                @class([
                    'form-control',
                    'is-invalid' => isset($idx) && $errors->has("content.{$idx}.title")
                ])
            />

            @if(isset($idx))
                @error("content.{$idx}.title")
                    <p class="error invalid-feedback">{{ $message }}</p>
                @enderror
            @endif
        </div>

        <div class="mb-3">
            <span class="form-label d-block">내용 <em>*</em></span>

            <div class="form-check form-switch">
                <label class="form-check-label">
                    <input
                        type="checkbox"
                        name="content[][use_table]"
                        @class([
                            'form-check-input',
                            'form-check-input__use_table',
                        ])
                        @checked($useTable)
                    />
                    <span class="text-muted">표 사용여부</span>
                </label>
            </div><!-- .form-check -->
        </div>

        <div
            @class([
                'mb-0',
                'd-none' => $useTable,
            ])
        >
            <div class="jt-repeater" data-repeater-content="data-repeater-child-content" data-repeater-template="data-repeater-child" data-repeater-min="1">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody class="jt-handle-sort" data-repeater-child-content>
                            @forelse($content['array'] ?? [] as $childIdx => $value)
                                @load_partials('admin.guide.visitor.item-child', compact('idx', 'childIdx', 'value'))
                            @empty
                                @load_partials('admin.guide.visitor.item-child', compact('idx'))
                            @endforelse
                        </tbody>
                    </table>
                </div><!-- .table-responsive -->

                <div class="mt-3 text-end">
                    <button type="button" class="btn btn-secondary btn-sm" data-repeater-add>추가</button>
                </div>
            </div><!-- .jt-repeater -->
        </div>

        <div
            @class([
                'mb-3',
                'd-none' => !$useTable,
            ])
        >
            <textarea
                rows="10"
                name="content[][table]"
                @class([
                    'form-control',
                    'js-tinymce-editor-table',
                    'is-invalid' => isset($idx) && $errors->has("content.{$idx}.table"),
                ])
            >{{ isset($idx) ? old("content.{$idx}.table", $content['table'] ?? '') : null }}</textarea>

            @if(isset($idx))
                @error("content.{$idx}.table")
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
