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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
