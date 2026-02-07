@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('assets/frontend/user-default.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ auth()->user()->name }}</h5>
                        <p class="card-text">{{ auth()->user()->email }}</p>
                        <form action="{{ route('user.profile.password.update') }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="present-password" class="col-form-label">Current Password</label>
                                </div>
                                <div class="col-auto">
                                    <input type="password" id="present-password" class="form-control" name="current_password">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="password" class="col-form-label">Password</label>
                                </div>
                                <div class="col-auto">
                                    <input type="password" id="password" class="form-control" name="password">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="confirm-password" class="col-form-label">Confirm Password</label>
                                </div>
                                <div class="col-auto">
                                    <input type="password" id="confirm-password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <button class="btn btn-primary mt-3" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
