@extends('admin.auth.layouts.app')

@section('content')
    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="{{ route('admin.login') }}">File Keeper</a>
            </div>

            <h4 class="mt-4 mb-4">{{ __('Forgot Password') }}</h4>

            <form method="POST" action="{{ route('admin.password.email') }}">
                @csrf

                <div class="auth-credentials m-b-xxl">
                    <label for="signInEmail" class="form-label">{{ __('Email Address') }}</label>
                    <input type="email" class="form-control m-b-md" id="signInEmail" aria-describedby="signInEmail"
                        placeholder="example@neptune.com" name="email" value="{{ old('email') }}">
                </div>

                <div class="auth-submit">
                    <button type="submit" class="btn btn-primary">{{ __('Send Password Reset Link') }}</button>
                </div>
            </form>
            <div class="divider"></div>
        </div>
    </div>
@endsection
