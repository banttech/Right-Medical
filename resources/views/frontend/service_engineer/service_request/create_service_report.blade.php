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
                                action="{{ route('service_engineer.save-service-report', $requestId) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="problem_description" class="form-label">Service Engineer Problem
                                            Description *</label>
                                        <textarea class="form-control" type="text" id="problem_description" name="problem_description" rows="4"
                                            cols="50" placeholder="Agent Problem Description" required>{{ old('problem_description') }}</textarea>
                                        @if ($errors->has('problem_description'))
                                            <span class="text-danger">{{ $errors->first('problem_description') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="spare_parts_needed" class="form-label">Spare Parts Needed *</label>
                                        <input class="form-control" type="text" id="spare_parts_needed"
                                            name="spare_parts_needed" placeholder="Write Comma Separated Spare Parts"
                                            value="{{ old('spare_parts_needed') }}" required />
                                        @if ($errors->has('spare_parts_needed'))
                                            <span class="text-danger">{{ $errors->first('spare_parts_needed') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="damage_machine_photos" class="form-label">Damaged Machine Photos
                                            *</label>
                                        <input class="form-control" type="file" id="damage_machine_photos"
                                            name="damage_machine_photos[]" multiple
                                            accept="image/png, image/jpeg, image/jpg" required />
                                        @if ($errors->has('damage_machine_photos'))
                                            <span class="text-danger">{{ $errors->first('damage_machine_photos') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="repaired_machine_photos" class="form-label">Repaired Machine
                                            Photos</label>
                                        <input class="form-control" type="file" id="repaired_machine_photos"
                                            name="repaired_machine_photos[]" multiple
                                            accept="image/png, image/jpeg, image/jpg" disabled />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="voice_note" class="form-label">Service Engineer Voice Note *</label>
                                        <input type="file" id="audioFileInput" name="engineer_voice_note"
                                            hidden />
                                        <audio class="form-control" id="audioPreview" class="mt-2" controls style="height: 42px"
                                            disabled></audio>
                                        <button type="button" id="micBtn" class="btn btn-primary mt-2">Start</button>
                                        <p class="text-danger mb-0">(Click on Start button to record a fresh Voice Note)</p>
                                        @if ($errors->has('engineer_voice_note'))
                                            <span class="text-danger">{{ $errors->first('engineer_voice_note') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="repaire_status" class="form-label">Repair Status *</label>
                                        <select class="form-select" id="repaire_status" name="repaire_status">
                                            <option value="unrepaired">Unrepaired</option>
                                            <option value="repaired">Repaired</option>
                                        </select>
                                        @if ($errors->has('repaire_status'))
                                            <span class="text-danger">{{ $errors->first('repaire_status') }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2">Submit Service Report</button>
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

                form.submit();
            } else {
                alert("Please record your voice note!");
            }
        });
    </script>
@endsection
