@extends('layouts.frontend.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Welcome {{ Auth::user()->name }}</h1>
            </div>
        </div>
    </div>
@endsection
