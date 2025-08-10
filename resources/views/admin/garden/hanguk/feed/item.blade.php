@php
$feed_id = isset($feed_id) ? $feed_id : '';
@endphp

<tr class="align-middle">
    <td class="jt-handle-sort__grap text-center fs-5"><i class="mdi mdi-menu"></i></td>
    <td>
        <select class="js-select-primary form-select" data-width="100%" name="feed_ids[]">
            <option selected disabled>게시글을 선택해주세요.</option>

            @if($events->count() > 0)
                @foreach($events as $event)
                    <option value="{{ $event->id }}" @selected($feed_id == $event->id)>{{ $event->title }}</option>
                @endforeach
            @endif
        </select>
    </td>
    <td class="text-center"><button type="button" class="btn btn-xs btn-outline-danger" data-repeater-remove>삭제</button></td>
</tr>
