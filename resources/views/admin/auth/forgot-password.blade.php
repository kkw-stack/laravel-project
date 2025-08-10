@extends('admin.partials.layout', [ 'type' => 'secondary', 'title' => '비밀번호 재설정' ])

@section('content')
    <div class="row w-100 wd-md-500-f mx-0">
        <div class="col">
            @foreach ($errors->get('common') as $message)
                <div class="alert alert-danger" role="alert">{{ $message }}</div><!-- .alert -->
            @endforeach

            <div class="card">
                <div class="card-body">
                    <div class="px-1 py-4">
                        <h1 class="noble-ui-logo d-block mb-4">비밀번호 재설정</h1>

                        @if(Route::is('admin.auth.forgot-password-complete'))
                            <hr />
                            <p class="card-text fs-5 mt-4">
                                비밀번호 재설정 메일이 발송되었습니다. <br />
                                이메일을 확인 하신 후 비밀번호를 재설정 하시기 바랍니다.
                            </p>
                        @else
                            <form id="pwForm" method="POST" novalidate>
                                @csrf

                                <div class="mb-3">
                                    <label for="userEmail" class="form-label">아이디 (이메일 주소)</label>
                                    <input
                                        type="email"
                                        id="userEmail"
                                        name="email"
                                        @class([
                                            'form-control',
                                            'is-invalid' => $errors->has('email'),
                                        ])
                                        value="{{ old('email' )}}"
                                    />
                                    @error('email')
                                        <p class="error invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">비밀번호 재설정</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div><!-- .card-body -->
            </div><!-- .card -->

            @if(Route::has('admin.auth.login'))
                <a href="{{ route('admin.auth.login') }}" class="d-inline-block mt-3 text-muted">로그인 화면으로</a>
            @endif
        </div><!-- .col -->
    </div><!-- .row -->
@endsection
