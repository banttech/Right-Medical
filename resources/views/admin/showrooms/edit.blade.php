@extends('layouts.admin.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Edit Surgical Showroom</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            @include('layouts.partials.messages')
                            <form id="formAccountSettings" method="POST"
                                action="{{ route('super_admin.update_showroom', $showroom->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="showroom_name" class="form-label">Showroom Name *</label>
                                        <input class="form-control" type="text" id="showroom_name" name="showroom_name"
                                            placeholder="Showroom Name" value="{{ $showroom->showroom_name }}" />
                                        @if ($errors->has('showroom_name'))
                                            <span class="text-danger">{{ $errors->first('showroom_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="whatsapp_number" class="form-label">Whatsapp Number *</label>
                                        <input class="form-control" type="text" id="whatsapp_number"
                                            name="whatsapp_number" value="{{ $showroom->whatsapp_number }}"
                                            placeholder="Whatsapp Number" />
                                        @if ($errors->has('whatsapp_number'))
                                            <span class="text-danger">{{ $errors->first('whatsapp_number') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="contact_name" class="form-label">Contact Name *</label>
                                        <input class="form-control" type="text" id="contact_name" name="contact_name"
                                            value="{{ $showroom->contact_name }}" placeholder="Contact Name" />
                                        @if ($errors->has('contact_name'))
                                            <span class="text-danger">{{ $errors->first('contact_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="contact_number" class="form-label">Contact Number *</label>
                                        <input class="form-control" type="text" id="contact_number" name="contact_number"
                                            placeholder="Contact Number" value="{{ $showroom->contact_number }}" />
                                        @if ($errors->has('contact_number'))
                                            <span class="text-danger">{{ $errors->first('contact_number') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Address *</label>
                                        <input class="form-control" type="text" id="address" name="address"
                                            placeholder="Address" value="{{ $showroom->address }}" />
                                        @if ($errors->has('address'))
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="city" class="form-label">City *</label>
                                        <select class="form-select" id="city" name="city">
                                            <option value="">Select City</option>
                                            <option value="Alappuzha"
                                                {{ $showroom->city == 'Alappuzha' ? 'selected' : '' }}>
                                                Alappuzha
                                            </option>
                                            <option value="Ernakulam"
                                                {{ $showroom->city == 'Ernakulam' ? 'selected' : '' }}>
                                                Ernakulam
                                            </option>
                                            <option value="Idukki" {{ $showroom->city == 'Idukki' ? 'selected' : '' }}>
                                                Idukki
                                            </option>
                                            <option value="Kannur" {{ $showroom->city == 'Kannur' ? 'selected' : '' }}>
                                                Kannur
                                            </option>
                                            <option value="Kasaragod"
                                                {{ $showroom->city == 'Kasaragod' ? 'selected' : '' }}>
                                                Kasaragod
                                            </option>
                                            <option value="Kollam" {{ $showroom->city == 'Kollam' ? 'selected' : '' }}>
                                                Kollam
                                            </option>
                                            <option value="Kottayam" {{ $showroom->city == 'Kottayam' ? 'selected' : '' }}>
                                                Kottayam
                                            </option>
                                            <option value="Kozhikode"
                                                {{ $showroom->city == 'Kozhikode' ? 'selected' : '' }}>
                                                Kozhikode
                                            </option>
                                            <option value="Malappuram"
                                                {{ $showroom->city == 'Malappuram' ? 'selected' : '' }}>
                                                Malappuram
                                            </option>
                                            <option value="Palakkad" {{ $showroom->city == 'Palakkad' ? 'selected' : '' }}>
                                                Palakkad
                                            </option>
                                            <option value="Pathanamthitta"
                                                {{ $showroom->city == 'Pathanamthitta' ? 'selected' : '' }}>
                                                Pathanamthitta
                                            </option>
                                            <option value="Thiruvananthapuram"
                                                {{ $showroom->city == 'Thiruvananthapuram' ? 'selected' : '' }}>
                                                Thiruvananthapuram
                                            </option>
                                            <option value="Thrissur" {{ $showroom->city == 'Thrissur' ? 'selected' : '' }}>
                                                Thrissur
                                            </option>
                                            <option value="Wayanad" {{ $showroom->city == 'Wayanad' ? 'selected' : '' }}>
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
                                            <option value="1" {{ $showroom->status == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="0"
                                                {{ $showroom->status == 'inactive' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <hr />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">Email ID *</label>
                                        <input class="form-control" type="email" id="email" name="email"
                                            placeholder="Email ID" value="{{ $showroom->email }}" />
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3 form-password-toggle">
                                        <label for="u_password" class="form-label">Password *</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="u_password" class="form-control"
                                                name="u_password" placeholder="Enter your password"
                                                aria-describedby="password" value="{{ $showroom->simple_password }}" />
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
                                                aria-describedby="password" value="{{ $showroom->simple_password }}" />
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                        @if ($errors->has('confirm_password'))
                                            <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2">Update Surgical
                                            Showroom</button>
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
