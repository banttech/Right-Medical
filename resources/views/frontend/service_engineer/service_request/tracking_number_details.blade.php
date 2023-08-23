@extends('layouts.frontend.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Tracking #: {{ $serviceRequest->tracking_no }}</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form id="formAccountSettings">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="tracking_number" class="form-label">Tracking Number</label>
                                        <input class="form-control" type="text" id="tracking_number"
                                            value="{{ $serviceRequest->tracking_no }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="machine_name" class="form-label">Machine Name</label>
                                        <input class="form-control" type="text" id="machine_name"
                                            value="{{ $serviceRequest->machine_name }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="model_no" class="form-label">Model No</label>
                                        <input class="form-control" type="text" id="model_no"
                                            value="{{ $serviceRequest->model_no }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="showroom_problem_description" class="form-label">Showroom Problem
                                            Description</label>
                                        <input class="form-control" type="text" id="showroom_problem_description"
                                            value="{{ $serviceRequest->problem_description }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="problem_occured_on" class="form-label">Problem Occured On</label>
                                        <input class="form-control" type="text" id="problem_occured_on"
                                            value="{{ $serviceRequest->problem_occured_date }}" readonly />
                                    </div>

                                    @php
                                        $showroomDetails = DB::table('showrooms')
                                            ->where('user_id', $serviceRequest->posted_by)
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
                                            value="{{ $serviceRequest->machine_collect_method == 'pickup' ? $agentGeneratedReport->problem_description : 'Not Found' }}"
                                            readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="agent_voice_note" class="form-label">Agent Voice Note</label>
                                        @if($serviceRequest->machine_collect_method == 'pickup')
                                            @if($agentGeneratedReport->agent_voice_note)
                                                <audio controls style="display: block; width: 100%; height: 42px;">
                                                    <source src="{{ asset('voices/' . $agentGeneratedReport->agent_voice_note) }}"
                                                        type="audio/mpeg">
                                                    Your browser does not support the audio element.
                                                </audio>
                                                @else
                                                    <input class="form-control" type="text" id="agent_voice_note"
                                                        value="Not Found" readonly />
                                            @endif        
                                            @else 
                                            <input type="text" class="form-control" value="Not Found" disabled>
                                        @endif
                                    </div>
                                    @if ($serviceRequest->machine_collect_method == 'pickup')
                                        @php
                                            $problemPictures = explode(',', $agentGeneratedReport->problem_pictures);
                                        @endphp
                                    @endif
                                    <div class="mb-3 col-md-6">
                                        <label for="problem_pictures" class="form-label">Agent Problem Images</label>
                                        <div class="row">
                                            @if ($serviceRequest->machine_collect_method == 'pickup')
                                                @foreach ($problemPictures as $problemPicture)
                                                    <div class="col-md-4">
                                                        <img src="{{ asset('admin_assets/img/problem_pictures/' . $problemPicture) }}"
                                                            alt="Problem Picture" class="img-fluid">
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" value="Not Found" disabled>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @php
                                $serviceEngineerReport = DB::table('service_engineer_reports')
                                    ->where('request_id', $serviceRequest->id)
                                    ->first();
                            @endphp
                            @if ($serviceEngineerReport)
                                <a href="{{ route('service_engineer.edit-service-report', $serviceRequest->id) }}"
                                    class="btn btn-primary">
                                    Edit Report
                                </a>
                            @else
                                <a href="{{ route('service_engineer.create-service-report', $serviceRequest->id) }}"
                                    class="btn btn-primary">
                                    Submit Service Report
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
