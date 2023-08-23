@extends('layouts.admin.app')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-2">Manage Surgical Showrooms</h4>

            @include('layouts.partials.messages')
            <form action="{{ route('super_admin.surgical_showrooms') }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control"
                        placeholder="Search by showroom name, contact name, contact number, email, address" name="search"
                        value="{{ request()->search }}">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                </div>
            </form>

            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('super_admin.add_surgical_showroom') }}" class="btn btn-primary">Add Surgical Showroom</a>
            </div>

            <div class="card">
                <div class="table-responsive text-nowrap mt-3">
                    <table class="table">
                        <thead>
                            <tr class="text-nowrap">
                                <th>SHOWROOM NAME</th>
                                <th>CONTANT NAME</th>
                                <th>CONTACT NUMBER</th>
                                <th>EMAIL</th>
                                <th>ADDRESS</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($showrooms) > 0)
                                @foreach ($showrooms as $key => $showroom)
                                    <tr>
                                        <td>{{ $showroom->showroom_name }}</td>
                                        <td>{{ $showroom->contact_name }}</td>
                                        <td>{{ $showroom->contact_number }}</td>
                                        <td>{{ $showroom->email }}</td>
                                        <td>{{ $showroom->address }}, {{ $showroom->city }}</td>
                                        <td>
                                            @if ($showroom->status == 'active')
                                                <span class="badge bg-label-success me-1">Active</span>
                                            @else
                                                <span class="badge bg-label-warning me-1">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('super_admin.edit_surgical_showroom', $showroom->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ route('super_admin.delete_surgical_showroom', $showroom->id) }}"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this showroom!');">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">No Showroom Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $showrooms->links() }}
            </div>
        </div>
    @endsection
