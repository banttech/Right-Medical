@extends('layouts.admin.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Assign Service Request To Sales Agent</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            @include('layouts.partials.messages')
                            <form id="formAccountSettings"
                                action="{{ route('super_admin.allocate_to_sales_agent', $requestId) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="agent" class="form-label">Select Sales Agent *</label>
                                        <select class="form-select" id="agent" name="agent" required>
                                            <option value="">Select Sales Agent</option>
                                            @foreach ($agents as $agent)
                                                @if ($agent->status == 'inactive')
                                                    <option value="{{ $agent->id }}" class="text-muted" disabled>
                                                        {{ $agent->name }}
                                                        (Inactive)
                                                    </option>
                                                @else
                                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('agent'))
                                            <span class="text-danger">{{ $errors->first('agent') }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
