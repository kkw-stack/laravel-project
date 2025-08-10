@extends('admin.partials.layout', [ 'type' => 'secondary', 'title' => '로그인' ])

@section('content')
    <div class="row w-100 wd-md-500-f mx-0">
        <div class="col">
            @foreach($errors->get('common') as $message)
                <div class="alert alert-danger" role="alert">{{ __($message) }}</div><!-- .alert -->
            @endforeach

            <div class="card">
                <div class="card-body">
                    <div class="px-1 py-4">
                        <h1 class="noble-ui-logo d-block mb-4">관리자 로그인</h1>

                        <form id="loginForm" method="post" novalidate>
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
                                    value="{{ old("email") }}"
                                />
                                @error('email')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="userPassword" class="form-label">비밀번호</label>
                                <input
                                    type="password"
                                    id="userPassword"
                                    name="password"
                                    @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('password'),
                                    ])
                                />

                                @error('password')
                                    <p class="error invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">로그인</button>
                            </div>
                        </form>
                    </div>
                </div><!-- .card-body -->
            </div><!-- .card -->

            @if(Route::has('admin.auth.forgot-password'))
                <a href="{{ route('admin.auth.forgot-password') }}" class="d-inline-block mt-3 text-muted">비밀번호 찾기</a>
            @endif
        </div><!-- .col -->
    </div><!-- .row -->
@endsection
