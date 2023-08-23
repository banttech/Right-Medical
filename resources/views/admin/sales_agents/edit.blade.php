@extends('layouts.admin.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Edit Sales Agent</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            @include('layouts.partials.messages')
                            <form id="formAccountSettings" method="POST"
                                action="{{ route('super_admin.update_sales_agent', $agent->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Sales Agent Name *</label>
                                        <input class="form-control" type="text" id="name" name="name"
                                            placeholder="Sales Agent Name" value="{{ $agent->name }}" />
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="contact_number" class="form-label">Contact Number *</label>
                                        <input class="form-control" type="text" id="contact_number" name="contact_number"
                                            placeholder="Contact Number" value="{{ $agent->contact_number }}" />
                                        @if ($errors->has('contact_number'))
                                            <span class="text-danger">{{ $errors->first('contact_number') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Address *</label>
                                        <input class="form-control" type="text" id="address" name="address"
                                            placeholder="Address" value="{{ $agent->address }}" />
                                        @if ($errors->has('address'))
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="city" class="form-label">City *</label>
                                        <select class="form-select" id="city" name="city">
                                            <option value="">Select City</option>
                                            <option value="Alappuzha" {{ $agent->city == 'Alappuzha' ? 'selected' : '' }}>
                                                Alappuzha
                                            </option>
                                            <option value="Ernakulam" {{ $agent->city == 'Ernakulam' ? 'selected' : '' }}>
                                                Ernakulam
                                            </option>
                                            <option value="Idukki" {{ $agent->city == 'Idukki' ? 'selected' : '' }}>
                                                Idukki
                                            </option>
                                            <option value="Kannur" {{ $agent->city == 'Kannur' ? 'selected' : '' }}>
                                                Kannur
                                            </option>
                                            <option value="Kasaragod" {{ $agent->city == 'Kasaragod' ? 'selected' : '' }}>
                                                Kasaragod
                                            </option>
                                            <option value="Kollam" {{ $agent->city == 'Kollam' ? 'selected' : '' }}>
                                                Kollam
                                            </option>
                                            <option value="Kottayam" {{ $agent->city == 'Kottayam' ? 'selected' : '' }}>
                                                Kottayam
                                            </option>
                                            <option value="Kozhikode" {{ $agent->city == 'Kozhikode' ? 'selected' : '' }}>
                                                Kozhikode
                                            </option>
                                            <option value="Malappuram"
                                                {{ $agent->city == 'Malappuram' ? 'selected' : '' }}>
                                                Malappuram
                                            </option>
                                            <option value="Palakkad" {{ $agent->city == 'Palakkad' ? 'selected' : '' }}>
                                                Palakkad
                                            </option>
                                            <option value="Pathanamthitta"
                                                {{ $agent->city == 'Pathanamthitta' ? 'selected' : '' }}>
                                                Pathanamthitta
                                            </option>
                                            <option value="Thiruvananthapuram"
                                                {{ $agent->city == 'Thiruvananthapuram' ? 'selected' : '' }}>
                                                Thiruvananthapuram
                                            </option>
                                            <option value="Thrissur" {{ $agent->city == 'Thrissur' ? 'selected' : '' }}>
                                                Thrissur
                                            </option>
                                            <option value="Wayanad" {{ $agent->city == 'Wayanad' ? 'selected' : '' }}>
                                                Wayanad
                                            </option>
                                        </select>
                                        @if ($errors->has('city'))
                                            <span class="text-danger">{{ $errors->first('city') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="state" class="form-label">State *</label>
                                        <input class="form-control" type="text" id="state" name="state"
                                            placeholder="State" value="Kerala" readonly />
                                        @if ($errors->has('state'))
                                            <span class="text-danger">{{ $errors->first('state') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="country" class="form-label">Country *</label>
                                        <input class="form-control" type="text" id="country" name="country"
                                            placeholder="Country" value="India" readonly />
                                        @if ($errors->has('country'))
                                            <span class="text-danger">{{ $errors->first('country') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="status" class="form-label">Status *</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="1" {{ $agent->status == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="0" {{ $agent->status == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <hr />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">Email *</label>
                                        <input class="form-control" type="email" id="email" name="email"
                                            placeholder="Email ID" value="{{ $agent->email }}" />
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3 form-password-toggle">
                                        <label for="u_password" class="form-label">Password *</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="u_password" class="form-control"
                                                name="u_password" placeholder="Enter your password"
                                                aria-describedby="password" value="{{ $agent->simple_password }}" />
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                        @if ($errors->has('u_password'))
                                            <span class="text-danger">{{ $errors->first('u_password') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3 form-password-toggle">
                                        <label for="confirm_password" class="form-label">Confirm Password *</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="confirm_password" class="form-control"
                                                name="confirm_password" placeholder="Enter your confirm password"
                                                aria-describedby="password" value="{{ $agent->simple_password }}" />
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                        @if ($errors->has('confirm_password'))
                                            <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2">Update Sales Agent</button>
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
