@extends('user.auth.layouts.app')

@section('content')
    <div class="app app-auth-sign-up align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container">
            <div class="logo mb-4">
                <a href="index.html">File Keeper</a>
            </div>

            <form method="POST" action="{{ route('user.register') }}">
                @csrf
                <div class="auth-credentials m-b-xxl">
                    <label for="signUpUsername" class="form-label">{{ __('First Name') }}</label>
                    <input type="name" class="form-control m-b-md" id="signUpUsername" aria-describedby="signUpUsername"
                        placeholder="Enter Name" name="firstname" value="{{ old('firstname') }}">

                    <label for="signUpUsername" class="form-label">{{ __('Last Name') }}</label>
                    <input type="name" class="form-control m-b-md" id="signUpUsername" aria-describedby="signUpUsername"
                        placeholder="Enter Name" name="lastname" value="{{ old('lastname') }}">

                    <label for="signUpEmail" class="form-label">{{ __('Email address') }}</label>
                    <input type="email" class="form-control m-b-md" id="signUpEmail" aria-describedby="signUpEmail"
                        placeholder="example@neptune.com" name="email" value="{{ old('email') }}">

                    <label for="signUpPassword" class="form-label">{{ __('Password') }}</label>
                    <input type="password" class="form-control m-b-md" id="signUpPassword" aria-describedby="signUpPassword"
                        name="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">

                    <label for="signUpPassword" class="form-label">{{ __('Confirm Password') }}</label>
                    <input type="password" class="form-control" id="signUpPassword" aria-describedby="signUpPassword"
                        name="password_confirmation" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                </div>

                <div class="auth-submit">
                    <button type="submit" class="btn btn-primary">{{ __('Sign Up') }}</button>
                </div>
            </form>
            <div class="divider"></div>

            <p class="auth-description">{{ __('Please enter your credentials to create an account.') }}<br>{{ __('Already have an account?') }} <a
                    href="{{ route('login') }}">{{ __('Sign In') }}</a></p>
        </div>
    </div>
@endsection
