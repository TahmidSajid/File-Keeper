@extends('layouts.app')

@section('content')
    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="{{ route('login') }}">File Keeper</a>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="auth-credentials m-b-xxl">
                    <label for="signInEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control m-b-md" id="signInEmail" aria-describedby="signInEmail"
                        placeholder="example@neptune.com" name="email" value="{{ old('email') }}">

                    <label for="signInPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="signInPassword" aria-describedby="signInPassword"
                        name="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                </div>

                <div class="auth-submit">
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
            </form>
            <div class="divider"></div>

            <div class="row d-flex justify-content-center">
                <div class="col-lg-6 text-center">
                    <a href="{{ route('register') }}">SignUp</a>
                </div>
            </div>
        </div>
    </div>
@endsection
