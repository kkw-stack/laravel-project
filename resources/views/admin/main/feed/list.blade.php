@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '메덩골 소식' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">메덩골 소식</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    @load_partials('admin.partials.locale-menu', [...compact('locale'), 'route' => 'admin.main.feed.list'])

    <div class="tab-content position-relative">
        <div class="tab-pane show active" id="langKorea">
            <div class="row">
                <form method="post">
                    @csrf

                    @error('feed_ids.*')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror

                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="card-title mb-0">메덩골 소식 관리</h2>
                            </div><!-- .card-header -->

                            <div class="card-body">
                                <p class="card-text text-muted mb-3">최대 3개까지 등록 가능하며, 등록된 게시글이 없는 경우 노출되지 않습니다.</p>

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
                                                @foreach(old('feed_ids', $feeds ?? []) as $feed)
                                                    @load_partials('admin.main.feed.item', compact('notices', 'newses', 'events', 'feed'))
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div><!-- .table-responsive -->

                                    <div class="mt-3 text-end">
                                        <button
                                            type="button"
                                            class="btn btn-secondary btn-sm"
                                            data-repeater-add
                                            @disabled(count($feeds ?? []) == 3)
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
        @load_partials('admin.main.feed.item', [...compact('notices', 'newses', 'events'), 'feed' => ''])
    </template>
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
<script src="/assets/admin/js/repeater.js"></script>
@endPush
