@extends('layouts.admin.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Manage Profile</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            @include('layouts.partials.messages')
                            <form id="formAccountSettings" method="POST" action="{{ route('super_admin.update_profile') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input class="form-control" type="text" id="email" name="email"
                                            value="{{ $superAdmin->email }}" placeholder="E-mail" readonly disabled />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="old_password" class="form-label">Old Password</label>
                                        <input class="form-control" type="password" id="old_password" name="old_password"
                                            placeholder="Enter your old password" required />
                                        @if ($errors->has('old_password'))
                                            <span class="text-danger">{{ $errors->first('old_password') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input class="form-control" type="password" id="new_password" name="new_password"
                                            placeholder="Enter your new password" required />
                                        @if ($errors->has('new_password'))
                                            <span class="text-danger">{{ $errors->first('new_password') }}</span>
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
