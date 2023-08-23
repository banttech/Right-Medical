@extends('layouts.admin.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Service Engineer Report</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form id="formAccountSettings"
                                action="{{ route('super_admin.update_service_request', $requestId) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="problem_description" class="form-label">Service Engineer Problem
                                            Description</label>
                                        <textarea class="form-control" type="text" id="problem_description" rows="4" cols="50"
                                            placeholder="Agent Problem Description" disabled>{{ $serviceEngineerReport->problem_description }}</textarea>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="spare_parts_needed" class="form-label">Spare Parts Needed</label>
                                        <input class="form-control" type="text" id="spare_parts_needed"
                                            placeholder="Write Comma Separated Spare Parts"
                                            value="{{ $serviceEngineerReport->spare_parts_needed }}" disabled />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="damage_machine_photos" class="form-label">Damaged Machine Photos</label>
                                        <input class="form-control" type="file" id="damage_machine_photos" multiple
                                            accept="image/png, image/jpeg, image/jpg" disabled />
                                        @php
                                            $damagePhotos = explode(',', $serviceEngineerReport->damage_machine_photos);
                                        @endphp
                                        <div class="mt-1" id="damage_photos">
                                            @if ($serviceEngineerReport->damage_machine_photos)
                                                @foreach ($damagePhotos as $image)
                                                    <img src="{{ asset('admin_assets/img/problem_pictures/' . $image) }}"
                                                        alt="Problem Picture" height="100px" width="100px">
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="repaired_machine_photos" class="form-label">Repaired Machine
                                            Photos</label>
                                        <input class="form-control" type="file" id="repaired_machine_photos" multiple
                                            accept="image/png, image/jpeg, image/jpg" disabled />
                                        @php
                                            $repairedPhotos = explode(',', $serviceEngineerReport->repaired_machine_photos);
                                        @endphp
                                        <div class="mt-1" id="repaired_photos">
                                            @if ($serviceEngineerReport->repaired_machine_photos)
                                                @foreach ($repairedPhotos as $image)
                                                    <img src="{{ asset('admin_assets/img/repaired_machine_pictures/' . $image) }}"
                                                        alt="Problem Picture" height="100px" width="100px">
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="voice_note" class="form-label">Service Engineer Voice Note</label>
                                        @if($serviceEngineerReport->engineer_voice_note)
                                            <audio controls style="display: block; width: 100%; height: 42px;">
                                                <source src="{{ asset('voices/' . $serviceEngineerReport->engineer_voice_note) }}"
                                                    type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                            @else
                                                <input class="form-control" type="text" id="agent_voice_note"
                                                    value="Not Found" readonly />
                                        @endif    
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="repaire_status" class="form-label">Repair Status *</label>
                                        <select class="form-select" id="repaire_status" disabled>
                                            <option value="unrepaired" @if ($serviceEngineerReport->repaire_status == 'unrepaired') selected @endif>
                                                Unrepaired</option>
                                            <option value="repaired" @if ($serviceEngineerReport->repaire_status == 'repaired') selected @endif>
                                                Repaired</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="spare_parts_cost" class="form-label">Spare Parts Cost *</label>
                                        <input class="form-control" type="number" id="spare_parts_cost"
                                            placeholder="Spare Parts Cost" name="spare_parts_cost"
                                            value="{{ $serviceRequest->spare_parts_cost }}" />
                                        @if ($errors->has('spare_parts_cost'))
                                            <span class="text-danger">{{ $errors->first('spare_parts_cost') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="showroom_service_charges" class="form-label">Service
                                            Charges *</label>
                                        <input class="form-control" type="number" id="showroom_service_charges"
                                            placeholder="Service Charges" name="showroom_service_charges"
                                            value="{{ $serviceRequest->showroom_service_charges }}" />
                                        @if ($errors->has('showroom_service_charges'))
                                            <span
                                                class="text-danger">{{ $errors->first('showroom_service_charges') }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('spare_parts_cost').addEventListener('input', function(e) {
            var value = this.value;
            var dotIndex = value.indexOf('.');
            if (dotIndex > -1) {
                var decimalPart = value.substring(dotIndex + 1);
                if (decimalPart.length > 2) {
                    this.value = value.substring(0, dotIndex + 3);
                }
            }
        });

        document.getElementById('showroom_service_charges').addEventListener('input', function(e) {
            var value = this.value;
            var dotIndex = value.indexOf('.');
            if (dotIndex > -1) {
                var decimalPart = value.substring(dotIndex + 1);
                if (decimalPart.length > 2) {
                    this.value = value.substring(0, dotIndex + 3);
                }
            }
        });
    </script>

@endsection
