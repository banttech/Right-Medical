@extends('layouts.frontend.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-2">Service Requests</h4>

            @include('layouts.partials.messages')
            <form action="{{ route('sales_agent.service_requests') }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search by machine name, model number" name="search"
                        value="{{ request()->search }}">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                </div>
            </form>

            <div class="card">
                <div class="table-responsive text-nowrap mt-3">
                    <table class="table">
                        <thead>
                            <tr class="text-nowrap">
                                <th>Machine NAME</th>
                                <th>Model Number</th>
                                <th>Showroom Problem Description</th>
                                <th>Problem Occured On</th>
                                <th>Location</th>
                                <th>Showroom Problem Image</th>
                                <th>Device Receiving Status</th>
                                <th>Tracking Number</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($serviceRequests) > 0)
                                @foreach ($serviceRequests as $key => $serviceRequest)
                                    <tr>
                                        <td>{{ $serviceRequest->machine_name }}</td>
                                        <td>{{ $serviceRequest->model_no }}</td>
                                        <td>{{ $serviceRequest->problem_description }}</td>
                                        <td>{{ date('d M Y', strtotime($serviceRequest->problem_occured_date)) }}</td>
                                        @php
                                            $PostedBy = $serviceRequest->posted_by;
                                            $showroomDetails = DB::table('showrooms')
                                                ->where('user_id', $PostedBy)
                                                ->first();
                                        @endphp

                                        <td>{{ $showroomDetails->address }}, {{ $showroomDetails->city }}</td>
                                        <td>
                                            @if ($serviceRequest->showroom_problem_image != null)
                                                <img src="{{ asset('admin_assets/img/problem_pictures/' . $serviceRequest->showroom_problem_image) }}"
                                                    alt="No Image" width="50" height="50" class="cursor-pointer"
                                                    onclick="showLargeImage(this)">
                                            @else
                                                <img src="{{ asset('storage/images/no_image.png') }}" alt="No Image"
                                                    width="50" height="50">
                                            @endif
                                        </td>
                                        <td>
                                            @if($serviceRequest->device_receiving_status == 'received')
                                                <span class="badge bg-label-success me-1">Received</span>
                                            @else
                                                <span class="badge bg-label-danger me-1">Not Received</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($serviceRequest->tracking_no)
                                                <a
                                                    href="{{ route('sales_agent.tracking-number-details', $serviceRequest->id) }}">
                                                    {{ $serviceRequest->tracking_no }}
                                                </a>
                                            @elseif($serviceRequest->machine_collect_method == 'pickup')
                                                <a href="{{ route('sales_agent.generate-tracking-number', $serviceRequest->id) }}"
                                                    class="btn btn-primary">Generate Tracking Number</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($serviceRequest->status == 'repaired')
                                                <span class="badge bg-success">{{ $serviceRequest->status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $serviceRequest->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">No Service Requests Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $serviceRequests->links() }}
            </div>
        </div>
    </div>
@endsection
