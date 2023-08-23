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
                                        <label for="name" class="form-label">Name</label>
                                        <input class="form-control" type="text" id="name"
                                            value="{{ $sales_agent->name }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email">Email</label>
                                        <input class="form-control" type="text" id="email"
                                            value="{{ $sales_agent->email }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="address">Address</label>
                                        <input class="form-control" type="text" id="address"
                                            value="{{ $sales_agent->address }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="city">City</label>
                                        <input class="form-control" type="text" id="city"
                                            value="{{ $sales_agent->city }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="state">State</label>
                                        <input class="form-control" type="text" id="state"
                                            value="{{ $sales_agent->state }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="country">Country</label>
                                        <input class="form-control" type="text" id="country"
                                            value="{{ $sales_agent->country }}" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="contact_number">Contact Number</label>
                                        <input class="form-control" type="text" id="contact_number"
                                            value="{{ $sales_agent->contact_number }}" readonly />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
