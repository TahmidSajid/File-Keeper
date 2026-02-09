@extends('layouts.app')

@section('content')
    <div class="app app-auth-sign-up align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container">
            <div class="logo mb-4">
                <a href="index.html">File Keeper</a>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="auth-credentials m-b-xxl">
                    <label for="signUpUsername" class="form-label">Name</label>
                    <input type="email" class="form-control m-b-md" id="signUpUsername" aria-describedby="signUpUsername"
                        placeholder="Enter Name" name="name" value="{{ old('name') }}">

                    <label for="signUpEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control m-b-md" id="signUpEmail" aria-describedby="signUpEmail"
                        placeholder="example@neptune.com" name="email" value="{{ old('email') }}">

                    <label for="signUpPassword" class="form-label">Password</label>
                    <input type="password" class="form-control m-b-md" id="signUpPassword" aria-describedby="signUpPassword"
                        name="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">

                    <label for="signUpPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="signUpPassword" aria-describedby="signUpPassword"
                        name="password_confirmation" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                </div>

                <div class="auth-submit">
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </div>
            </form>
            <div class="divider"></div>

            <p class="auth-description">Please enter your credentials to create an account.<br>Already have an account? <a
                    href="{{ route('login') }}">Sign In</a></p>
        </div>
    </div>
@endsection
