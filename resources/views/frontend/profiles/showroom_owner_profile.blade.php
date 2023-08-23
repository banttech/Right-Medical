@extends('layouts.frontend.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Profile Information</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form id="formAccountSettings">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="showroom_name" class="form-label">Showroom Name</label>
                                        <input class="form-control" type="text" id="showroom_name"
                                            value="{{ $showroom->showroom_name }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="whatsapp_number" class="form-label">Whatsapp Number</label>
                                        <input class="form-control" type="text" id="whatsapp_number"
                                            value="{{ $showroom->whatsapp_number }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="contact_name">Contact Name</label>
                                        <input class="form-control" type="text" id="contact_name"
                                            value="{{ $showroom->contact_name }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="contact_number">Contact Number</label>
                                        <input class="form-control" type="text" id="contact_number"
                                            value="{{ $showroom->contact_number }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="address">Address</label>
                                        <input class="form-control" type="text" id="address"
                                            value="{{ $showroom->address }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="city">City</label>
                                        <input class="form-control" type="text" id="city"
                                            value="{{ $showroom->city }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="state">State</label>
                                        <input class="form-control" type="text" id="state"
                                            value="{{ $showroom->state }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="country">Country</label>
                                        <input class="form-control" type="text" id="country"
                                            value="{{ $showroom->country }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email">Email</label>
                                        <input class="form-control" type="text" id="email"
                                            value="{{ $showroom->email }}" readonly />
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
