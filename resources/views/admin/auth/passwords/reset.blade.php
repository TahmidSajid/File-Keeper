@extends('admin.auth.layouts.app')

@section('content')

    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="{{ route('admin.login') }}">File Keeper</a>
            </div>
            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="auth-credentials m-b-xxl">
                    <label for="signInEmail" class="form-label">{{ __('Email Address') }}</label>
                    <input type="email" class="form-control m-b-md" id="signInEmail" aria-describedby="signInEmail"
                        placeholder="example@neptune.com" name="email" value="{{ $email ?? old('email') }}">

                </div>

                <div class="auth-credentials m-b-xxl">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input type="password" class="form-control" id="password" aria-describedby="password"
                        name="password">
                </div>

                <div class="auth-credentials m-b-xxl">
                    <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                    <input type="password" class="form-control" id="password-confirm" aria-describedby="password-confirm"
                        name="password_confirmation">
                </div>

                <div class="auth-submit">
                    <button type="submit" class="btn btn-primary">{{ __('Reset Password') }}</button>
                </div>
            </form>
            <div class="divider"></div>
        </div>
    </div>
@endsection
