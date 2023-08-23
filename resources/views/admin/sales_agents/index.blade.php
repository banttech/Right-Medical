@extends('layouts.admin.app')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-2">Manage Sales Agents</h4>

            @include('layouts.partials.messages')
            <form action="{{ route('super_admin.sales_agents') }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search by agent name, email, contact number, address" name="search"
                        value="{{ request()->search }}">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                </div>
            </form>

            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('super_admin.add_sales_agent') }}" class="btn btn-primary">Add Sales Agent</a>
            </div>

            <div class="card">
                <div class="table-responsive text-nowrap mt-3">
                    <table class="table">
                        <thead>
                            <tr class="text-nowrap">
                                <th>AGENT NAME</th>
                                <th>EMAIL</th>
                                <th>CONTACT NUMBER</th>
                                <th>ADDRESS</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($agents) > 0)
                                @foreach ($agents as $key => $agent)
                                    <tr>
                                        <td>{{ $agent->name }}</td>
                                        <td>{{ $agent->email }}</td>
                                        <td>{{ $agent->contact_number }}</td>
                                        <td>{{ $agent->address }}, {{ $agent->city }}</td>
                                        <td>
                                            @if ($agent->status == 'active')
                                                <span class="badge bg-label-success me-1">Active</span>
                                            @else
                                                <span class="badge bg-label-warning me-1">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('super_admin.edit_sales_agent', $agent->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ route('super_admin.delete_sales_agent', $agent->id) }}"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this sales agent!');">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">No Sales Agent Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $agents->links() }}
            </div>
        </div>
    @endsection
