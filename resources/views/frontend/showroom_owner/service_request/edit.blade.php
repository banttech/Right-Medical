@extends('layouts.frontend.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Add Service Request</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            @include('layouts.partials.messages')
                            <form id="showroom_service_request_form" method="post"
                                action="{{ route('showroom_owner.update-service-request', $serviceRequest->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="machine_name" class="form-label">Machine Name *</label>
                                        <input class="form-control" type="text" id="machine_name" name="machine_name"
                                            placeholder="Machine Name" value="{{ $serviceRequest->machine_name }}"
                                            required />
                                        @if ($errors->has('machine_name'))
                                            <span class="text-danger">{{ $errors->first('machine_name') }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="model_no" class="form-label">Model No *</label>
                                        <input class="form-control" type="text" id="model_no" name="model_no"
                                            placeholder="Model No" value="{{ $serviceRequest->model_no }}" required />
                                        @if ($errors->has('model_no'))
                                            <span class="text-danger">{{ $errors->first('model_no') }}</span>
                                        @endif
                                    </div>


                                    <div class="mb-3 col-md-6">
                                        <label for="problem_description" class="form-label">Showroom Problem Description
                                            *</label>
                                        <textarea class="form-control" type="text" id="problem_description" name="problem_description" rows="4"
                                            cols="50" required>{{ $serviceRequest->problem_description }}</textarea>
                                        @if ($errors->has('problem_description'))
                                            <span class="text-danger">{{ $errors->first('problem_description') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="voice_note" class="form-label">Showroom Voice Note *</label>

                                        <input type="file" id="audioFileInput" name="showroom_voice_note"
                                            hidden />
                                        <audio class="form-control" id="audioPreview" class="mt-2" src="{{ asset('voices/' . $serviceRequest->showroom_voice_note) }}" type="audio/webm" controls style="height: 42px"
                                            disabled></audio>
                                        <button type="button" id="micBtn" class="btn btn-primary mt-2">Start</button>
                                        <p class="text-danger mb-0">(Click on Start button to record a fresh Voice Note)</p>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="machine_collect_method" class="form-label">Collect Device *</label>
                                        <select class="form-select" id="machine_collect_method"
                                            name="machine_collect_method" required>
                                            <option value="pickup" @if ($serviceRequest->machine_collect_method == 'pickup') selected @endif>
                                                Pickup
                                            </option>
                                            <option value="courier" @if ($serviceRequest->machine_collect_method == 'courier') selected @endif>
                                                Courier
                                            </option>
                                        </select>
                                        @if ($errors->has('machine_collect_method'))
                                            <span class="text-danger">{{ $errors->first('machine_collect_method') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="showroom_problem_image" class="form-label">Showroom Problem
                                            Image *</label>
                                        <input class="form-control" type="file" id="showroom_problem_image"
                                            name="showroom_problem_image" placeholder="Showroom Problem Image"
                                            accept="image/png, image/jpeg, image/jpg" />
                                        <img class="mt-1"
                                            src="{{ asset('admin_assets/img/problem_pictures/' . $serviceRequest->showroom_problem_image) }}"
                                            alt="Problem Picture" height="100px" width="100px" id="problem_picture">
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2">Update Service Request</button>
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
        document.getElementById('showroom_problem_image').addEventListener('change', function() {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('problem_picture');
                output.src = reader.result;
            };
            reader.readAsDataURL(this.files[0]);
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

        const form = document.getElementById("showroom_service_request_form");
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
