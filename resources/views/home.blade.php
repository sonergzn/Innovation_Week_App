@extends('layouts.app')

@section('content')
@if (session()->has('info')) 
    <div class="w-4/5 m-auto mt-10 pl-2">
        <p class="w-3/6 mb-4 text-gray-40 text-center bg-yellow-300 rounded-1xl py-4"> {{session()->get('info')}} </p>
    </div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
