@extends('layouts.frontend.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Tracking #: {{ $trackingNumberDetails->tracking_no }}</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form id="formAccountSettings">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="tracking_number" class="form-label">Tracking Number</label>
                                        <input class="form-control" type="text" id="tracking_number"
                                            value="{{ $trackingNumberDetails->tracking_no }}" readonly />
                                    </div>
                                    @php
                                        $requestDetails = DB::table('service_requests')
                                            ->where('id', $trackingNumberDetails->request_id)
                                            ->first();
                                    @endphp
                                    <div class="mb-3 col-md-6">
                                        <label for="machine_name" class="form-label">Machine Name</label>
                                        <input class="form-control" type="text" id="machine_name"
                                            value="{{ $requestDetails->machine_name }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="model_no" class="form-label">Model No</label>
                                        <input class="form-control" type="text" id="model_no"
                                            value="{{ $requestDetails->model_no }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="showroom_problem_description" class="form-label">Showroom Problem
                                            Description</label>
                                        <input class="form-control" type="text" id="showroom_problem_description"
                                            value="{{ $requestDetails->problem_description }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="problem_occured_on" class="form-label">Problem Occured On</label>
                                        <input class="form-control" type="text" id="problem_occured_on"
                                            value="{{ $requestDetails->problem_occured_date }}" readonly />
                                    </div>

                                    @php
                                        $showroomDetails = DB::table('showrooms')
                                            ->where('user_id', $requestDetails->posted_by)
                                            ->first();
                                    @endphp
                                    <div class="mb-3 col-md-6">
                                        <label for="location" class="form-label">Location</label>
                                        <input class="form-control" type="text" id="location"
                                            value="{{ $showroomDetails->country }}, {{ $showroomDetails->city }}"
                                            readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="agent_problem_description" class="form-label">Agent Problem
                                            Description</label>
                                        <input class="form-control" type="text" id="agent_problem_description"
                                            value="{{ $trackingNumberDetails->problem_description }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="agent_voice_note" class="form-label">Agent Voice Note</label>
                                        @if($trackingNumberDetails->agent_voice_note)
                                            <audio controls style="display: block; width: 100%; height: 42px;">
                                                <source src="{{ asset('voices/' . $trackingNumberDetails->agent_voice_note) }}"
                                                    type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                            @else
                                                <input class="form-control" type="text" id="agent_voice_note"
                                                    value="Not Found" readonly />
                                        @endif                                        
                                    </div>
                                    @php
                                        $problemPictures = explode(',', $trackingNumberDetails->problem_pictures);
                                    @endphp
                                    <div class="mb-3 col-md-6">
                                        <label for="problem_pictures" class="form-label">Agent Problem Images</label>
                                        <div class="row">
                                            @foreach ($problemPictures as $problemPicture)
                                                <div class="col-md-4">
                                                    <img src="{{ asset('admin_assets/img/problem_pictures/' . $problemPicture) }}"
                                                        alt="Problem Picture" class="img-fluid">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
