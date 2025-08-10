@extends('admin.partials.layout', [ 'type' => 'primary' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">통계</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mb-0">사이트 방문자수</h2>
                </div><!-- .card-header -->

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <b class="text-nowrap">총 방문자 수</b>
                        <span class="text-primary text-nowrap">{{ number_format($total_visitors ?? 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <b class="text-nowrap">오늘 방문자 수</b>
                        <span class="text-primary text-nowrap">{{ number_format($today_visitors ?? 0) }}</span>
                    </div>
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->

        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mb-0">회원 가입자 수</h2>
                </div><!-- .card-header -->

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <b class="text-nowrap">총 가입자 수</b>
                        <span class="text-primary text-nowrap">{{ number_format($total_users ?? 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <b class="text-nowrap">국문 가입자 수</b>
                        <span class="text-primary text-nowrap">{{ number_format($ko_users ?? 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <b class="text-nowrap">영문 가입자 수</b>
                        <span class="text-primary text-nowrap">{{ number_format($en_users ?? 0) }}</span>
                    </div>
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->

        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mb-0">SNS 연동 가입자 수</h2>
                </div><!-- .card-header -->

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <b class="text-nowrap">총 가입자 수</b>
                        <span class="text-primary text-nowrap">{{ number_format($sns_users ?? 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <b class="text-nowrap">카카오 가입자 수</b>
                        <span class="text-primary text-nowrap">{{ number_format($kakao_users ?? 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <b class="text-nowrap">네이버 가입자 수</b>
                        <span class="text-primary text-nowrap">{{ number_format($naver_users ?? 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <b class="text-nowrap">구글 가입자 수</b>
                        <span class="text-primary text-nowrap">{{ number_format($google_users ?? 0) }}</span>
                    </div>
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->

        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mb-0">회원 연령대</h2>
                </div><!-- .card-header -->

                <div class="card-body">
                    <div class="js-apex js-apex--years" data-json="{{ json_encode($age_counts) }}"></div>
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->

        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mb-0">남여 성비</h2>
                </div><!-- .card-header -->

                <div class="card-body">
                    <div class="js-apex js-apex--gender" data-json="{{ json_encode($gender_counts) }}"></div>
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mb-0">거주지역</h2>
                </div><!-- .card-header -->

                <div class="card-body">
                    <div class="js-apex js-apex--area" data-json="{{ json_encode($location_counts) }}"></div>
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->
    </div><!-- .row -->
@endsection

@push('scripts')
<script>
'use strict';

$('.js-apex').each(function(){

    let options = { // Default options
        chart: {
            type: 'bar',
            height: 480,
            toolbar: {
                show: false
            }
        },
        fill: {
            colors: 'var(--bs-primary)'
        },
        plotOptions: {
            bar: {
                horizontal: false,
                distributed: false,
                columnWidth: '60%',
                barHeight: '60%'
            }
        },
        legend: {
            show: false
        },
        series: []
    };

    let data = [];

    try {
        data = JSON.parse(this.dataset.json);
    } catch (e) {

    }

    console.log(data);

    if( $(this).hasClass('js-apex--years') ){ // 회원 연령대

        options.series.push({
            name: '회원수',
            data: data
        });

    } else if( $(this).hasClass('js-apex--gender') ){ // 냠여 성비

        options.fill.colors = [ 'var(--bs-blue)', 'var(--bs-red)' ];
        options.plotOptions.bar.distributed = true;
        options.series.push({
            name: '회원수',
            data: data
        });

    } else if( $(this).hasClass('js-apex--area') ){ // 거주지역
        options.chart.height = 800;
        options.fill.colors = 'var(--bs-teal)';
        options.plotOptions.bar.horizontal = true;
        options.series.push({
            name: '회원수',
            data: data
        });

    }

    const apexBarChart = new ApexCharts(this, options);
    apexBarChart.render();

});

</script>
@endpush
