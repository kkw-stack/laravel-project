@php
$pageTitle = '관리자 ' . (isset($manager) ? '수정' : '등록');

if (Route::is('admin.profile')) {
    $pageTitle = '프로필';
}
@endphp

@extends('admin.partials.layout', [ 'type' => 'primary', 'title' => $pageTitle ])

@section('content')
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col-auto">
            <h1 class="page-title fs-4">{{ $pageTitle }}</h1>
        </div><!-- .col -->
    </div><!-- .row -->

    @foreach($errors->get('common') as $message)
        <div class="alert alert-danger" role="alert">{{ $message }}</div><!-- .alert -->
    @endforeach

    <form method="POST" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">관리자 정보</h2>
                    </div><!-- .card-header -->

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="userName" class="form-label">이름 <em>*</em></label>
                            <input
                                type="text"
                                id="userName"
                                name="name"
                                maxlength="8"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('name'),
                                ])
                                value="{{ old('name', isset($manager) ? $manager->name : '') }}"
                            />
                            @error('name')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="userEmail" class="form-label">아이디 (이메일) <em>*</em></label>
                            <input
                                type="email"
                                id="userEmail"
                                name="email"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('email'),
                                ])
                                @readonly(isset($manager))
                                value="{{ old('email', isset($manager) ? $manager->email : '') }}"
                            />
                            @error('email')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="userTel" class="form-label">휴대폰번호 <em>*</em></label>
                            <input
                                type="tel"
                                id="userTel"
                                name="phone"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('phone'),
                                ])
                                value="{{ old('phone', isset($manager) ? $manager->phone : '') }}"
                            />
                            @error('phone')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="userPassword" class="form-label">
                                비밀번호
                                @if(!isset($manager))
                                    <em>*</em>
                                @endif
                            </label>
                            <p class="mt-n1 mb-2 text-muted">{{ __('jt.IN-07') }}</p>
                            <input
                                type="password"
                                id="userPassword"
                                name="password"
                                autocomplete="new-password"
                                @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('password'),
                                ])
                            />
                            @error('password')
                                <p class="error invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                                <div class="d-flex gap-1">
                                    @if(isset($manager))
                                        <button type="submit" class="btn btn-primary">수정</button>
                                    @else
                                        <button type="submit" class="btn btn-primary">등록</button>
                                    @endif
    
                                    <a href="{{ route('admin.manager.list', request()->query()) }}" class="btn btn-light">취소</a>
                                </div>
                            </div><!-- .col -->

                            @if(isset($manager) && $manager->is_super === false)
                                <div class="col-auto">
                                    <button type="button" type="button" class="btn btn-outline-danger" id="managerDelete">탈퇴</button>
                                </div><!-- .col -->
                            @endif
                        </div><!-- .rwo -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div><!-- .row -->
    </form>

    @if(isset($manager) && false === $manager->is_super)
        <form method="POST" id="managerDeleteForm">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('scripts')
<script src="/assets/admin/js/notification.js"></script>
@endpush

@pushIf(isset($manager) && false === $manager->is_super, 'scripts')
<script>
$(function () {
    'use strict';

    $('#managerDelete').on('click', function () {
        if (confirm('{{ __('jt.AL-06') }}')) {
            $('#managerDeleteForm').submit();
        }
    });
});
</script>
@endPushIf
