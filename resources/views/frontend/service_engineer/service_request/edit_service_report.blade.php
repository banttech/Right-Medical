@extends('layouts.frontend.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Submit Service Report</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            @include('layouts.partials.messages')
                            <form id="engineer_report_form"
                                action="{{ route('service_engineer.update-service-report', $requestId) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="problem_description" class="form-label">Service Engineer Problem
                                            Description *</label>
                                        <textarea class="form-control" type="text" id="problem_description" name="problem_description" rows="4"
                                            cols="50" placeholder="Agent Problem Description">{{ $serviceReport->problem_description }}</textarea>
                                        @if ($errors->has('problem_description'))
                                            <span class="text-danger">{{ $errors->first('problem_description') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="spare_parts_needed" class="form-label">Spare Parts Needed *</label>
                                        <input class="form-control" type="text" id="spare_parts_needed"
                                            name="spare_parts_needed" placeholder="Write Comma Separated Spare Parts"
                                            value="{{ $serviceReport->spare_parts_needed }}" />
                                        @if ($errors->has('spare_parts_needed'))
                                            <span class="text-danger">{{ $errors->first('spare_parts_needed') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="damage_machine_photos" class="form-label">Damaged Machine Photos
                                            *</label>
                                        <input class="form-control" type="file" id="damage_machine_photos"
                                            name="damage_machine_photos[]" multiple
                                            accept="image/png, image/jpeg, image/jpg" />
                                        @php
                                            $damagePhotos = explode(',', $serviceReport->damage_machine_photos);
                                        @endphp
                                        <div class="mt-1" id="damage_photos">
                                            @if ($serviceReport->damage_machine_photos)
                                                @foreach ($damagePhotos as $image)
                                                    <img src="{{ asset('admin_assets/img/problem_pictures/' . $image) }}"
                                                        alt="Problem Picture" height="100px" width="100px">
                                                @endforeach
                                            @endif
                                        </div>
                                        @if ($errors->has('damage_machine_photos'))
                                            <span class="text-danger">{{ $errors->first('damage_machine_photos') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="repaired_machine_photos" class="form-label">Repaired Machine
                                            Photos</label>
                                        <input class="form-control" type="file" id="repaired_machine_photos"
                                            name="repaired_machine_photos[]" multiple
                                            accept="image/png, image/jpeg, image/jpg" />
                                        @php
                                            $repairedPhotos = explode(',', $serviceReport->repaired_machine_photos);
                                        @endphp
                                        <div class="mt-1" id="repaired_photos">
                                            @if ($serviceReport->repaired_machine_photos)
                                                @foreach ($repairedPhotos as $image)
                                                    <img src="{{ asset('admin_assets/img/repaired_machine_pictures/' . $image) }}"
                                                        alt="Problem Picture" height="100px" width="100px">
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="voice_note" class="form-label">Service Engineer Voice Note *</label>
                                        <input type="file" id="audioFileInput" name="engineer_voice_note"
                                            hidden />
                                        <audio class="form-control" id="audioPreview" class="mt-2" src="{{ asset('voices/' . $serviceReport->engineer_voice_note) }}" type="audio/webm" controls
                                            style="height: 42px"></audio>
                                        <button type="button" id="micBtn" class="btn btn-primary mt-2">Start</button>
                                        <p class="text-danger mb-0">(Click on Start button to record a fresh Voice Note)</p>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="repaire_status" class="form-label">Repair Status *</label>
                                        <select class="form-select" id="repaire_status" name="repaire_status">
                                            <option value="unrepaired" @if ($serviceReport->repaire_status == 'unrepaired') selected @endif>
                                                Unrepaired</option>
                                            <option value="repaired" @if ($serviceReport->repaire_status == 'repaired') selected @endif>
                                                Repaired</option>
                                        </select>
                                        @if ($errors->has('repaire_status'))
                                            <span class="text-danger">{{ $errors->first('repaire_status') }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2">Update Service Report</button>
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
        document.getElementById('damage_machine_photos').addEventListener('change', function() {
            var damage_photos = document.getElementById('damage_photos');
            damage_photos.innerHTML = '';
            for (var i = 0; i < this.files.length; i++) {
                var img = document.createElement('img');
                img.src = URL.createObjectURL(this.files[i]);
                img.height = 100;
                img.width = 100;
                img.style.margin = '5px';
                img.onload = function() {
                    URL.revokeObjectURL(this.src);
                }
                damage_photos.appendChild(img);
            }
        });

        document.getElementById('repaired_machine_photos').addEventListener('change', function() {
            var repaired_photos = document.getElementById('repaired_photos');
            repaired_photos.innerHTML = '';
            for (var i = 0; i < this.files.length; i++) {
                var img = document.createElement('img');
                img.src = URL.createObjectURL(this.files[i]);
                img.height = 100;
                img.width = 100;
                img.style.margin = '5px';
                img.onload = function() {
                    URL.revokeObjectURL(this.src);
                }
                repaired_photos.appendChild(img);
            }
        });

        const micBtn = document.getElementById("micBtn");
        const audioPreview = document.getElementById("audioPreview");

        let chunks = [];
        let mediaRecorder;
        let isRecording = false;
        let audioFile = null;

        const toggleRecording = async () => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                });

                if (!isRecording) {
                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.addEventListener("dataavailable", (e) => {
                        chunks.push(e.data);
                    });
                    mediaRecorder.addEventListener("stop", async () => {
                        const audioBlob = new Blob(chunks, {
                            type: "audio/webm"
                        });
                        const audioUrl = URL.createObjectURL(audioBlob);
                        console.log(audioUrl);
                        // add audionBlob to audioFile
                        audioFile = audioBlob;

                        chunks = [];

                        const audioURL = URL.createObjectURL(audioBlob);
                        audioPreview.src = audioURL;
                        audioPreview.controls = true;
                        audioPreview.disabled = false;

                        micBtn.textContent = "Start";
                        isRecording = false;
                    });
                    mediaRecorder.start();
                    micBtn.textContent = "Stop";
                    isRecording = true;
                } else {
                    mediaRecorder.stop();
                    audioPreview.load();
                }
            } catch (err) {
                console.error(err);
            }
        };
        micBtn.addEventListener("click", toggleRecording);

        const form = document.getElementById("engineer_report_form");
        // add event listener to form submit
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            if (audioFile) {
                const convertedAudioFile = new File([audioFile], "audio.webm");
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(convertedAudioFile);

                const audioFileInput = document.getElementById("audioFileInput");
                audioFileInput.files = dataTransfer.files;
            }
            form.submit();
        });
    </script>
@endsection
