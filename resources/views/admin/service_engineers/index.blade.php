@extends('layouts.admin.app')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-2">Manage Service Engineers</h4>

            @include('layouts.partials.messages')
            <form action="{{ route('super_admin.service_engineers') }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search by engineer name, email, contact number, address"
                        name="search" value="{{ request()->search }}">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                </div>
            </form>

            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('super_admin.add_service_engineer') }}" class="btn btn-primary">Add Service Engineer</a>
            </div>

            <div class="card">
                <div class="table-responsive text-nowrap mt-3">
                    <table class="table">
                        <thead>
                            <tr class="text-nowrap">
                                <th>ENGINEER NAME</th>
                                <th>EMAIL</th>
                                <th>CONTACT NUMBER</th>
                                <th>ADDRESS</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($engineers) > 0)
                                @foreach ($engineers as $key => $engineer)
                                    <tr>
                                        <td>{{ $engineer->name }}</td>
                                        <td>{{ $engineer->email }}</td>
                                        <td>{{ $engineer->contact_number }}</td>
                                        <td>{{ $engineer->address }}, {{ $engineer->city }}</td>
                                        <td>
                                            @if ($engineer->status == 'active')
                                                <span class="badge bg-label-success me-1">Active</span>
                                            @else
                                                <span class="badge bg-label-warning me-1">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('super_admin.edit_service_engineer', $engineer->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ route('super_admin.delete_service_engineer', $engineer->id) }}"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this service engineer!');">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">No Service Engineer Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $engineers->links() }}
            </div>
        </div>
    @endsection
