@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => '관람권 관리' ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">관람권 관리</h1>
        </div><!-- .col -->
        <div class="col-auto">
            <a href="{{ route('admin.ticket.create') }}" class="btn btn-primary">관람권 등록</a>
        </div><!-- .col -->
    </div><!-- .row -->

    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">목록</h2>
                </div><!-- .card-header -->

                <div class="card-body">
                    <form method="post">
                        @csrf

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="wd-50-f text-center">순서</th>
                                        <th class="wd-100-f">상태</th>
                                        <th>관람권명</th>
                                        <th class="wd-150-f">작성자</th>
                                        <th class="wd-150-f">등록일</th>
                                    </tr>
                                </thead>
                                <tbody class="jt-handle-sort">
                                    @foreach($tickets as $ticket)
                                        <tr>
                                            <td class="jt-handle-sort__grap text-center fs-5">
                                                <i class="mdi mdi-menu"></i>
                                                <input type="hidden" name="ticket_ids[]" value="{{ $ticket->id }}" />
                                            </td>
                                            <td>{{ $ticket->status ? '공개' : '비공개' }}</td>
                                            <td>
                                                <a class="text-decoration-underline" href="{{ route('admin.ticket.detail', compact('ticket')) }}">{{ $ticket->title['ko'] }}</a>
                                            </td>
                                            <td>{{ $ticket->author->name }}</td>
                                            <td>{{ $ticket->created_at->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- .table-responsive -->

                        <div class="mt-3">
                            <button type="submit" class="btn btn-secondary btn-sm">순서 저장</button>
                        </div>
                    </form>
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col -->
    </div><!-- row -->
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
@endPush
