@php
$scenery_id = $scenery ?? '';
@endphp

<tr class="align-middle">
    <td class="jt-handle-sort__grap text-center fs-5"><i class="mdi mdi-menu"></i></td>
    <td>
        <select class="js-select-primary form-select" data-width="100%" name="scenery_ids[]">
            <option selected disabled>게시글을 선택해주세요.</option>

            @if($sceneryGallery->count() > 0)
                <optgroup label="메덩골 풍경">
                    @foreach($sceneryGallery as $item)
                        <option value="{{ $item->id }}" @selected($scenery_id == $item->id)>{{ $item->title }}</option>
                    @endforeach
                </optgroup>
            @endif
        </select>
    </td>
    <td class="text-center"><button type="button" class="btn btn-xs btn-outline-danger" data-repeater-remove>삭제</button></td>
</tr>
