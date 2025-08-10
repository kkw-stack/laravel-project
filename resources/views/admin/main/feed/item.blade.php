@php
$feed_item = explode('_', $feed ?? '');
$feed_type = $feed_item[0] ?? '';
$feed_id = $feed_item[1] ?? '';
@endphp

<tr class="align-middle">
    <td class="jt-handle-sort__grap text-center fs-5"><i class="mdi mdi-menu"></i></td>
    <td>
        <select class="js-select-primary form-select" data-width="100%" name="feed_ids[]">
            <option selected disabled>게시글을 선택해주세요.</option>

            @if($notices->count() > 0)
                <optgroup label="공지">
                    @foreach($notices as $notice)
                        <option value="notice_{{ $notice->id }}" @selected($feed_type === 'notice' && $feed_id == $notice->id)>{{ $notice->title }}</option>
                    @endforeach
                </optgroup>
            @endif

            @if($newses->count() > 0)
                <optgroup label="언론뉴스">
                    @foreach($newses as $news)
                        <option value="news_{{ $news->id }}" @selected($feed_type === 'news' && $feed_id == $news->id)>{{ $news->title }}</option>
                    @endforeach
                </optgroup>
            @endif

            @if($events->count() > 0)
                <optgroup label="행사">
                    @foreach($events as $event)
                        <option value="event_{{ $event->id }}" @selected($feed_type === 'event' && $feed_id == $event->id)>{{ $event->title }}</option>
                    @endforeach
                </optgroup>
            @endif
        </select>
    </td>
    <td class="text-center"><button type="button" class="btn btn-xs btn-outline-danger" data-repeater-remove>삭제</button></td>
</tr>
