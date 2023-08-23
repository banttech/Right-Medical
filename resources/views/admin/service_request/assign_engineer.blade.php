@extends('layouts.admin.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Assign Service Request To Service Engineer</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            @include('layouts.partials.messages')
                            <form id="formAccountSettings"
                                action="{{ route('super_admin.allocate_to_service_engineer', $requestId) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="engineer" class="form-label">Select Service Engineer *</label>
                                        <select class="form-select" id="engineer" name="engineer" required>
                                            <option value="">Select Service Engineer</option>
                                            @foreach ($engineers as $engineer)
                                                @if ($engineer->status == 'inactive')
                                                    <option value="{{ $engineer->id }}" class="text-muted" disabled>
                                                        {{ $engineer->name }}
                                                        (Inactive)
                                                    </option>
                                                @else
                                                    <option value="{{ $engineer->id }}">{{ $engineer->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('engineer'))
                                            <span class="text-danger">{{ $errors->first('engineer') }}</span>
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
