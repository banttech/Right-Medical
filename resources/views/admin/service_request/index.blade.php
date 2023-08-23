@extends('layouts.admin.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-2">Service Requests</h4>

            @include('layouts.partials.messages')
            <form action="{{ route('super_admin.service_requests') }}" method="GET">
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
                                <th>Showroom Voice Note</th>
                                <th>Collect Device</th>
                                <th>Problem Occured On</th>
                                <th>Location</th>
                                <th>Showroom Problem Image</th>
                                <th>Device Receiving Status</th>
                                <th>Tracking Number</th>
                                <th>Assign Agent</th>
                                <th>Assign Service Engineer</th>
                                <th>Service Engineer Report</th>
                                <th>Showroom Approval</th>
                                <th>Work Status</th>
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
                                        <td>
                                            @if ($serviceRequest->showroom_voice_note != null)
                                                <audio controls style="height: 42px;">
                                                    <source src="{{ asset('voices/' . $serviceRequest->showroom_voice_note) }}" type="audio/webm">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            @else
                                                not found
                                            @endif
                                        </td>
                                        <td>{{ $serviceRequest->machine_collect_method }}</td>
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
                                        <td class="form-switch">
                                            @if($serviceRequest->device_receiving_status == 'received')
                                                <input class="form-check-input m-0" type="checkbox" checked onchange="changeDeviceReceivingStatus({{ $serviceRequest->id }})" />
                                            @else
                                                <input class="form-check-input m-0" type="checkbox" onchange="changeDeviceReceivingStatus({{ $serviceRequest->id }})" />
                                            @endif
                                        </td>
                                        <td>
                                            @if ($serviceRequest->machine_collect_method == 'courier' && $serviceRequest->tracking_no == null)
                                                <a href="{{ route('super_admin.save_tracking_number', $serviceRequest->id) }}"
                                                    class="btn btn-primary btn-sm">Generate Tracking Number</a>
                                            @else
                                                <a
                                                    href="{{ route('super_admin.tracking_number_details', $serviceRequest->id) }}">
                                                    {{ $serviceRequest->tracking_no }}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($serviceRequest->sales_agent == null && $serviceRequest->machine_collect_method == 'pickup')
                                                <a href="{{ route('super_admin.assign_agent', $serviceRequest->id) }}"
                                                    class="btn btn-primary btn-sm">Allocate to Sales Agent</a>
                                            @else
                                                @php
                                                    $agent = DB::table('sales_agents')
                                                        ->where('id', $serviceRequest->sales_agent)
                                                        ->first();
                                                @endphp
                                                @if ($agent != null)
                                                    {{ $agent->name }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($serviceRequest->service_engineer == null && $serviceRequest->tracking_no == null)
                                                <a href="#" class="btn btn-primary btn-sm disabled">
                                                    Allocate to Service Engineer
                                                </a>
                                            @elseif ($serviceRequest->service_engineer == null && $serviceRequest->tracking_no != null)
                                                <a href="{{ route('super_admin.assign_engineer', $serviceRequest->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    Allocate to Service Engineer
                                                </a>
                                            @else
                                                @php
                                                    $engineer = DB::table('service_engineers')
                                                        ->where('id', $serviceRequest->service_engineer)
                                                        ->first();
                                                @endphp
                                                @if ($engineer != null)
                                                    {{ $engineer->name }}
                                                @endif
                                            @endif
                                        </td>

                                        <td>
                                            @php
                                                $serviceEngineerReport = DB::table('service_engineer_reports')
                                                    ->where('request_id', $serviceRequest->id)
                                                    ->first();
                                            @endphp
                                            @if ($serviceEngineerReport)
                                                <a
                                                    href="{{ route('super_admin.service_engineer_report', $serviceRequest->id) }}">View Report</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($serviceRequest->showroom_approval !== null)
                                                @if ($serviceRequest->showroom_approval == 'approved')
                                                    <span class="badge bg-label-success me-1">Approved</span>
                                                @elseif($serviceRequest->showroom_approval == 'disapproved')
                                                    <span class="badge bg-label-danger me-1">Disapproved</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($serviceRequest->showroom_approval == 'approved')
                                                @if ($serviceRequest->work_status == 'started')
                                                    <span class="badge bg-label-success me-1">Work is in progress</span>
                                                @elseif($serviceRequest->work_status == 'completed')
                                                    <span class="badge bg-label-success me-1">Work is completed</span>
                                                @endif
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

    <script>
        function changeDeviceReceivingStatus(requestId) {
            $.ajax({
                url: "{{ route('super_admin.change_device_receiving_status') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "requestId": requestId,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(response) {
                    toastr.error(response.message);
                }
            });
        }
    </script>
@endsection
