@extends('layouts.frontend.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Generate Tracking Number</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            @include('layouts.partials.messages')
                            <form id="generate_tracking_number_form"
                                action="{{ route('sales_agent.save-tracking-number', $requestId) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="problem_description" class="form-label">Problem
                                            Description *</label>
                                        <textarea class="form-control" type="text" id="problem_description" name="problem_description" rows="4"
                                            cols="50" placeholder="Agent Problem Description" required>{{ old('problem_description') }}</textarea>
                                        @if ($errors->has('problem_description'))
                                            <span class="text-danger">{{ $errors->first('problem_description') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="voice_note" class="form-label">Agent Voice Note *</label>
                                        <input type="file" id="audioFileInput" name="agent_voice_note"
                                            hidden />
                                        <audio class="form-control" id="audioPreview" class="mt-2" controls style="height: 42px"
                                            disabled></audio>
                                        <button type="button" id="micBtn" class="btn btn-primary mt-2">Start</button>
                                        <p class="text-danger mb-0">(Click on Start button to record a fresh Voice Note)</p>
                                        @if ($errors->has('agent_voice_note'))
                                            <span class="text-danger">{{ $errors->first('agent_voice_note') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="problem_pictures" class="form-label">Problem Pictures *</label>
                                        <input class="form-control" type="file" id="problem_pictures"
                                            name="problem_pictures[]" multiple accept="image/png, image/jpeg, image/jpg" required />
                                        @if ($errors->has('problem_pictures'))
                                            <span class="text-danger">{{ $errors->first('problem_pictures') }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2">Generate Tracking
                                            Number</button>
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


        const form = document.getElementById("generate_tracking_number_form");

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
