@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '한국정원 소식' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">한국정원 소식</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    @load_partials('admin.partials.locale-menu', [...compact('locale'), 'route' => 'admin.garden.hanguk.feed.list'])

    <div class="tab-content position-relative">
        <div class="tab-pane show active" id="langKorea">
            <div class="row">
                <form method="post">
                    @csrf

                    @error('feed_ids')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror

                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="card-title mb-0">한국정원 소식 관리</h2>
                            </div><!-- .card-header -->

                            <div class="card-body">
                                <p class="card-text text-muted mb-3">최대 3개까지 선택 가능하며, 선택 게시글이 없는 경우 공지의 최신 등록글을 자동으로 가져와 노출합니다.</p>

                                <div class="jt-repeater" data-repeater-content="data-repeater-content" data-repeater-template="data-repeater-item" data-repeater-max="3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="wd-50-f text-center">순서</th>
                                                    <th>게시글</th>
                                                    <th class="wd-100-f"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="jt-handle-sort" data-repeater-content>
                                                @if($feed?->firstItem?->exists)
                                                    @load_partials('admin.garden.hanguk.feed.item', array_merge(compact('events'), ['feed_id' => $feed->first_post_id]))
                                                @endif
                                                @if($feed?->secondItem?->exists)
                                                    @load_partials('admin.garden.hanguk.feed.item', array_merge(compact('events'), ['feed_id' => $feed->second_post_id]))
                                                @endif
                                                @if($feed?->thirdItem?->exists)
                                                    @load_partials('admin.garden.hanguk.feed.item', array_merge(compact('events'), ['feed_id' => $feed->third_post_id]))
                                                @endif
                                            </tbody>
                                        </table>
                                    </div><!-- .table-responsive -->

                                    <div class="mt-3 text-end">
                                        <button
                                            type="button"
                                            class="btn btn-secondary btn-sm"
                                            data-repeater-add
                                            @disabled(!is_null($feed?->firstItem) && !is_null($feed?->secondItem) && !is_null($feed?->thirdItem))
                                        >추가</button>
                                    </div>
                                </div><!-- .jt-repeater -->
                            </div><!-- .card-body -->
                        </div><!-- .card -->
                    </div><!-- .col -->

                    <div class="col-md-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">업데이트</button>
                                    </div><!-- .col -->
                                </div><!-- .rwo -->
                            </div><!-- .card-body -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                </form>
            </div><!-- .row -->
        </div><!-- .tab-pane -->
    </div><!-- .tab-content -->

    <template data-repeater-item>
        @load_partials('admin.garden.hanguk.feed.item', compact('events'))
    </template>
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
<script src="/assets/admin/js/repeater.js"></script>
@endPush
