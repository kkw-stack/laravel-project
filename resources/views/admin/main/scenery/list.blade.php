@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '메덩골 풍경' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">메덩골 소식</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    @load_partials('admin.partials.locale-menu', [...compact('locale'), 'route' => 'admin.main.scenery.list'])

    <div class="tab-content position-relative">
        <div class="tab-pane show active" id="langKorea">
            <div class="row">
                <form method="post">
                    @csrf

                    @error('scenery_ids.*')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror

                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="card-title mb-0">메덩골 풍경 관리</h2>
                            </div><!-- .card-header -->

                            <div class="card-body">
                                <p class="card-text text-muted mb-3">최대 10개 까지 선택 가능하며, 선택 게시글이 1개도 없을 경우 해당 영역은 노출되지 않습니다.</p>

                                <div class="jt-repeater" data-repeater-content="data-repeater-content" data-repeater-template="data-repeater-item" data-repeater-max="10">
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
                                                @foreach(old('scenery_ids', $sceneriesSlide ?? []) as $scenery)
                                                    @load_partials('admin.main.scenery.item', compact('sceneriesSlide', 'sceneryGallery', 'scenery'))
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div><!-- .table-responsive -->

                                    <div class="mt-3 text-end">
                                        <button
                                            type="button"
                                            class="btn btn-secondary btn-sm"
                                            data-repeater-add
                                            @disabled(count($sceneriesSlide ?? []) == 10)
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
        @load_partials('admin.main.scenery.item', [...compact('sceneriesSlide', 'sceneryGallery'), 'scenery' => ''])
    </template>
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
<script src="/assets/admin/js/repeater.js"></script>
@endPush
