<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-sky-50">
    <div id="app">
       @include('layouts.part.navbar')
        <main class="py-4">
            <div class="container">
                @include('flash::message')
                @include('layouts._errors')
                @yield('content')
            </div>
            
        </main>
    </div>
    <script>
        // Helper to create answer options
    function createAnswerOptions(index) {
        return `
            <input type="text" name="questions[${index}][options][]" class="form-control mb-2" placeholder="Pilihan A">
            <input type="text" name="questions[${index}][options][]" class="form-control mb-2" placeholder="Pilihan B">
            <input type="text" name="questions[${index}][options][]" class="form-control mb-2" placeholder="Pilihan C">
            <input type="text" name="questions[${index}][options][]" class="form-control mb-2" placeholder="Pilihan D">
        `;
    }

    // Helper to create image upload label
    function createImageUploadLabel(index) {
        return `
            <label for="question_image_${index}" class="text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                    <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                    <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0" />
                </svg>
            </label>
        `;
    }

    // Function to create question HTML
    function createQuestionHtml(index) {
        return `
            <div class="question-item">
                <div class="card border-0">
                    <div class="card-header border-0 bg-white border-top">
                        <h4 class="text-gray-700 fw-bold">Create New Soal</h4>
                    </div>
                    <div class="card-body bg-white">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="question">Pertanyaan</label>
                                    <textarea name="questions[${index}][question]" class="form-control" rows="3" placeholder="Masukkan pertanyaan" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Pilihan Jawaban: <span class="text-danger">(Opsional)</span></label>
                                    <div>${createAnswerOptions(index)}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="image-upload-container">
                                    <input type="file" name="questions[${index}][question_image]" id="question_image_${index}" 
                                        onchange="previewImage(event, document.getElementById('imagePreview_${index}'))">
                                    ${createImageUploadLabel(index)}
                                    <img id="imagePreview_${index}" class="image-upload-preview" alt="Preview Gambar" style="display: none;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn mb-2 bg-red-300 remove-question" onclick="removeQuestion(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
    }

    // Function to add a new question
    function addQuestion() {
        const container = document.getElementById("questions-container");
        const questionCount = container.childElementCount;
        const newQuestionHtml = createQuestionHtml(questionCount);

        container.insertAdjacentHTML("beforeend", newQuestionHtml);
    }

    // Function to preview image
    function previewImage(event, imgElement) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imgElement.src = e.target.result;
                imgElement.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imgElement.style.display = 'none';
        }
    }
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', event => {
            const file = event.target.files[0];
            const previewId = event.target.dataset.previewId;
            const previewImage = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Menampilkan gambar lama jika ada
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.image-upload-preview').forEach(previewImage => {
            if (previewImage.src === '') {
                previewImage.style.display = "none";
            }
        });
    });


    // Function to remove question
    function removeQuestion(button) {
        button.closest('.question-item').remove();
    }

    </script>
</body>
</html>
