@extends('master')

@section('style')
    <style>
        .display-none {
            display: none;
        }
        .preview-image {
            max-width: 100%;
            max-height: 100px; /* Adjust as needed */
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .photo-capture {
            padding: 20px;
        }

        .title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .controls {
            margin-bottom: 20px;
        }

        .upload-label {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .upload-label input[type=file] {
            display: none;
        }

        .preview-container {
            margin-bottom: 10px;
        }

        .preview-title {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .photo-preview {
            width: 150px; /* Set width to desired size */
            height: 150px; /* Set height to desired size */
            object-fit: cover; /* Cover the entire area while maintaining aspect ratio */
            overflow: hidden; /* Hide any overflowing content */
            border: 1px solid #ddd;
            border-radius: 5px;
            display: none; /* Initially hide the container */
        }

        #previewImage {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Cover the entire area while maintaining aspect ratio */
            display: block; /* Display the image */
        }
        #fixedButtons {
            top: 11%; /* Adjust top value to position slightly below the original navbar */
        }

        #content {
            padding-top: 100px; /* Adjust padding-top to create space below the fixed buttons */
        }

        .popup {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #171113;
            border-radius: 10px;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .custom-label {
            font-size: 12px;
            color: white;
            font-family: monospace;
        }
        .white-border {
            border-radius: 10px; /* Adjust the radius as needed */
            background-color: #171113;
        }
        .white-border1 {
            border: 1px solid white;
            border-radius: 10px; /* Adjust the radius as needed */
            background-color: #171113;
        }
        .heightIncrease {
            height: 100%;
        }
    </style>
@endsection

@section('content')
<body style="background-color: #171113;">
    <div class="container" style="background-color: #171113">
        <h4 class="text text-center mt-6 mb-6" style="color: white;">Water Temperature</h4>
        @if (session('info_message'))
            <div class="container alert alert-info alert-dismissible mt-5">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session('info_message') }}
            </div>
        @endif
        <form class="form heightIncrease" method="POST" height="100" action="{{ route('water_temperature.store') }}">   
            @csrf
            <div class="row">
                <div class="col-3">
                    <label for="tank_1" class="custom-label">Tank 1 <span class="required">*</span></label>
                </div>
                <div class="col-9">
                    <input type="number" id="tank_1" name="tank_1" value="{{ old('tank_1') }}" required="required" class="form-control mt-2 mb-2 white-border">
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="tank_2" class="custom-label">Tank 2 <span class="required">*</span></label>
                </div>
                <div class="col-9">
                    <input type="number" id="tank_2" name="tank_2" value="{{old('tank_2')}}" required="required" class="form-control mt-2 mb-2 white-border">
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="tank_3" class="custom-label">Tank 3 <span class="required">*</span></label>
                </div>
                <div class="col-9">
                    <input type="number" id="tank_3" name="tank_3" value="{{old('tank_3')}}" required="required" class="form-control mt-2 mb-2 white-border">
                </div>
            </div>
            <div class="row mt-2 mb-2">
                <div class="col-2">
                    <label></label>
                </div>
                <div class="col-10">
                    <a id="showNoteButton" class="text-light mt-2" style="color: rgb(41, 118, 170) !important;">Additional Info</a>
                </div>
            </div>

            <div class="row">

                <div id="notePopup" class="popup">
                    <div class="popup-content">
                        <span class="close">&times;</span>
                        <label for="tank_3" class="custom-label">Note</label>
                        <textarea id="note" name="note" class="form-control mt-2 mb-2" style="height: 200px;"></textarea>
                        <hr class="popup-divider" color="white">
                        <div class="row mt-3">
                            <div class="col-9 float-left" >
                                <input type="file" accept="image/*" id="uploadInput" name="photo" style="display: none;">
                                <label for="uploadInput" class="btn btn-primary btn-sm">
                                    <span class="text-light custom-label">Upload</span>
                                </label>
                            </div>
                                <div class="col-3 float-right">
                                <label for="" class="btn btn-danger btn-sm closeBtn">
                                    <span class="text-light custom-label">close</span>
                                </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-3">
                    <label for="Note" class="custom-label">Note</label>
                </div> --}}
                {{-- <div class="col-9">
                    <!-- Button to show textarea in popup -->
                    <a id="showNoteButton" class="text-light mt-2 custom-label">Show Note</a>
                </div>
                <div id="notePopup" class="popup">
                    <div class="popup-content">
                        <span class="close">&times;</span>
                        <textarea id="note" name="note" class="form-control auto-expand mt-2 mb-2" style="height: 45px;"></textarea>
                    </div>
                </div> --}}

            </div>
            {{-- <div class="row mt-3">
                <div class="col-3">
                    <label for="uploadInput" class="custom-label" class="mt-2">Upload Photo :</label>
                </div>
                <div class="col-9">
                    <div class="photo-capture white-border1">
                        <input type="file" accept="image/*" id="uploadInput" name="photo" style="display: none;">
                        <label for="uploadInput" class="btn btn-primary btn-sm">
                            <span class="text-light custom-label">Upload</span>
                        </label>
                        <div class="preview-container">
                            <div class="row">
                                <div class="col-6 custom-label">Preview</div>
                                <div class="col-6 custom-label">
                                    <span class="close" onclick="clearImage()">&times;</span>
                                </div>
                            </div>
                        </div>
                        <div id="photoPreview" class="photo-preview">
                            <img id="previewImage" src="#" alt="Preview">
                        </div>
                    </div>
                </div>
            </div> --}}
            
            <div class="row justify-content-center">
                <div class="col-12 form-group mt-3 text-center">
                    <button type="submit" class="btn btn-success btn-sm text-light custom-label">Submit</button>
                    <button type="button" class="btn btn-danger btn-sm ml-2 custom-label" onclick="clearForm()">Clear</button>
                </div>
            </div>
            <div class="row ml-4">
                <label onclick="preview()" class="btn btn-primary btn-sm">
                    <span class="text-light custom-label">Preview</span>
                </label>
            </div>
            <div class="row" id="previewImages" style="display: none;">
                <div class="photo-capture white-border1">
                                 
                    <div class="preview-container">
                        <div class="row">
                            <div id="photoPreview" class="col-8 photo-preview showImages ml-4">
                                <img id="previewImage" src="#" alt="Preview">
                            </div>
                            <div class="col-3 custom-label mr-2">
                                <span class="close" onclick="clearImage()">&times;</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </form>
    </div>
</body>
@endsection

@section('script')
    <script>
      document.getElementById('uploadInput').addEventListener('change', function(event) {
        var file = event.target.files[0];
        var previewImage = document.getElementById('previewImage');
        
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';

                // Set the file data as the value of the hidden input field
                document.getElementById('photo').value = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            // Clear the preview image if no file is selected
            previewImage.src = '';
            previewImage.style.display = 'none';

            // Clear the value of the hidden input field
            document.getElementById('photo').value = '';
        }
    });

    function preview() {
        var previewImages = document.getElementById("previewImages");

        // Toggle the visibility of the previewImages div
        if (previewImages.style.display === "none" || previewImages.style.display === "") {
            previewImages.style.display = "block";
        } else {
            previewImages.style.display = "none";
        }
        
    }
    

    function clearImage() {
        var previewImage = document.getElementById('previewImage');
        
        // Clear the preview image
        previewImage.src = '';
        previewImage.style.display = 'none';

        // Clear the value of the hidden input field
        document.getElementById('photo').value = '';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Auto-expand textarea
            const textarea = document.getElementById('note');
            textarea.addEventListener('input', function() {
                // this.style.height = this.scrollHeight + 'px';
            });

            // Sending textarea content and photo to the backend
            const form = document.getElementById('form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(form);
                fetch('/submitForm', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Form submitted successfully:', data);
                    // Optionally, reset the form after successful submission
                    form.reset();
                })
                .catch(error => {
                    console.error('Error submitting form:', error);
                });
            });
        });

        function clearForm() {
            document.getElementById('tank_1').value = '';
            document.getElementById('tank_2').value = '';
            document.getElementById('tank_3').value = '';
            document.getElementById('note').value = '';
            document.getElementById('photo').value = '';
            document.getElementById('photoPreview').innerHTML = '';
        }

        // document.getElementById("showNoteButton").addEventListener("click", function() {
        //     event.preventDefault();
        //     document.getElementById("notePopup").style.display = "block";
            
        // });

        // document.getElementsByClassName("close")[0].addEventListener("click", function() {
        //     document.getElementById("notePopup").style.display = "none";
        // });
        document.getElementById("showNoteButton").addEventListener("click", function(event) {
            event.preventDefault();
            var notePopup = document.getElementById("notePopup");
            notePopup.style.display = "block";
        });

        document.getElementsByClassName("close")[0].addEventListener("click", function() {
            document.getElementById("notePopup").style.display = "none";
        });
        document.getElementsByClassName("closeBtn")[0].addEventListener("click", function() {
            document.getElementById("notePopup").style.display = "none";
        });

        // Move upload logic inside the popup
        document.getElementById("uploadInput").addEventListener("change", function() {
            var previewImage = document.getElementById("previewImage");
            var file = this.files[0];
            var reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            }
            
            reader.readAsDataURL(file);
        });


        function displayImagePreview() {
            var previewContainer = document.getElementById("photoPreview");
            var imageInput = document.getElementById("uploadInput");
            var imagePreview = document.getElementById("previewImage");

            // Check if an image is selected
            if (imageInput.files && imageInput.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.style.display = "block"; // Show the container when an image is uploaded
                }

                reader.readAsDataURL(imageInput.files[0]);
            }
        }

        // Event listener for changes in the image input
        document.getElementById("uploadInput").addEventListener("change", displayImagePreview);
        
    </script>
@endsection
