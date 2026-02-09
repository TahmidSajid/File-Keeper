@extends('admin.layout.app')

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Profile</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            @if (auth()->user()->image)
                                <img src="{{ asset('assets/frontend/user/' . auth()->user()->image) }}" class="card-img-top"
                                    alt="...">
                            @else
                                <img src="{{ asset('assets/frontend/default/user-default.jpg') }}" class="card-img-top"
                                    alt="...">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">Password Update</h5>
                                <form action="{{ route('user.profile.password.update') }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-lg=12">
                                            <label for="present-password" class="col-form-label">Current Password</label>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="password" id="present-password" class="form-control"
                                                name="current_password">
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-12">
                                            <label for="password" class="col-form-label">Password</label>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="password" id="password" class="form-control" name="password">
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-12">
                                            <label for="confirm-password" class="col-form-label">Confirm Password</label>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="password" id="confirm-password" class="form-control"
                                                name="password_confirmation">
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
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('user.profile.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="mb-3">
                                        <label for="profile-img" class="form-label">Profile Image</label>
                                        <input type="file" class="form-control" id="profile-img" name="profile_img">
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ auth()->user()->name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ auth()->user()->email }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
