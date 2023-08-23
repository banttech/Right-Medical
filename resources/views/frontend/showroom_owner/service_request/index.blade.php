@extends('layouts.frontend.app')

@section('content')
    <style>
        .bxs-comment-edit {
            font-size: 23px;
            cursor: pointer;
            color: #696cff;
        }
    </style>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-2">Service Requests</h4>

            @include('layouts.partials.messages')
            <form action="{{ route('showroom_owner.service_requests') }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search by machine name, model number" name="search"
                        value="{{ request()->search }}">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                </div>
            </form>

            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('showroom_owner.add-service-request') }}" class="btn btn-primary">Add Service Request</a>
            </div>

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
                                <th>Showroom Problem Image</th>
                                <th>Device Receiving Status</th>
                                <th>Tracking Number</th>
                                <th>Location</th>
                                <th>Sales Agent</th>
                                <!-- <th>Service Engineer</th> -->
                                <th>Super Admin CHARGES</th>
                                <!-- <th>Showroom Cost</th> -->
                                <th>Showroom Approval</th>
                                <th>Work Status</th>
                                <th>ACTIONS</th>
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
                                            @if (isset($serviceRequest->tracking_no))
                                                <a
                                                    href="{{ route('showroom_owner.tracking-number-details', $serviceRequest->id) }}">
                                                    {{ $serviceRequest->tracking_no }}
                                                </a>
                                            @else
                                                {{ $serviceRequest->tracking_no }}
                                            @endif
                                        </td>

                                        @php
                                            $PostedBy = $serviceRequest->posted_by;
                                            $showroomDetails = DB::table('showrooms')
                                                ->where('user_id', $PostedBy)
                                                ->first();
                                        @endphp

                                        <td>{{ $showroomDetails->address }}, {{ $showroomDetails->city }}</td>
                                        @if (isset($serviceRequest->sales_agent))
                                            @php
                                                $salesAgentDetails = DB::table('sales_agents')
                                                    ->where('id', $serviceRequest->sales_agent)
                                                    ->first();
                                            @endphp
                                            <td>{{ $salesAgentDetails->name }}</td>
                                        @else
                                            <td></td>
                                        @endif

                                        <!-- @if (isset($serviceRequest->service_engineer))
    @php
        $serviceEngineerDetails = DB::table('service_engineers')
            ->where('id', $serviceRequest->service_engineer)
            ->first();
    @endphp
                                                                                                                                                                                                                                <td>{{ $serviceEngineerDetails->name }}</td>
@else
    <td></td>
    @endif -->

                                        <td>
                                            @if ($serviceRequest->spare_parts_cost && $serviceRequest->showroom_service_charges)
                                                {{ $serviceRequest->spare_parts_cost + $serviceRequest->showroom_service_charges }} INR
                                            @endif
                                        </td>

                                        <td id="showroom_approval_{{ $serviceRequest->id }}">
                                            @if ($serviceRequest->spare_parts_cost && $serviceRequest->showroom_service_charges)
                                                @if ($serviceRequest->showroom_approval == null)
                                                    <a href="{{ route('showroom_owner.approve-service-request', $serviceRequest->id) }}"
                                                        class="btn btn-success btn-sm"
                                                        onclick="return confirm('Are you sure you want to approve?');">
                                                        Approve
                                                    </a>
                                                    <a href="{{ route('showroom_owner.disapprove-service-request', $serviceRequest->id) }}"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to disapprove?');">
                                                        Disapprove
                                                    </a>
                                                @else
                                                    @if ($serviceRequest->showroom_approval == 'approved')
                                                        <span class="badge bg-label-success me-1">Approved</span>
                                                    @elseif($serviceRequest->showroom_approval == 'disapproved')
                                                        <span class="badge bg-label-danger me-1">Disapproved</span>
                                                    @endif
                                                    @if ($serviceRequest->status != 'repaired' && $serviceRequest->work_status == null)
                                                        <a onclick="updateShowRoomDecision({{ $serviceRequest->id }})">
                                                            <i class='bx bxs-comment-edit'></i>
                                                        </a>
                                                    @endif
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
                                            @if ($serviceRequest->work_status == 'started' || $serviceRequest->work_status == 'completed')
                                                <a href="" class="btn btn-primary btn-sm disabled">Edit</a>
                                                <a href="" class="btn btn-danger btn-sm disabled">Delete</a>
                                            @else
                                                <a href="{{ route('showroom_owner.edit-service-request', $serviceRequest->id) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <a href="{{ route('showroom_owner.delete-service-request', $serviceRequest->id) }}"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this service request!');">Delete</a>
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
        function updateShowRoomDecision(id) {
            var approveUrl = "/surgical-showroom/approve-service-request/" + id;
            var disapproveUrl = "/surgical-showroom/disapprove-service-request/" + id;

            var html = `
                <a href="${approveUrl}" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to approve?');">
                Approve
                </a>
                <a href="${disapproveUrl}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to disapprove?');">
                Disapprove
                </a>
            `;
            $('#showroom_approval_' + id).html(html);
        }
    </script>
@endsection
