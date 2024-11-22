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
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('users') }}">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill"
                                    viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                    </svg>
                                </span>
                                {{ __('Users') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('roles') }}">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill"
                                        viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                    </svg>
                                </span>
                                {{ __('Roles') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('questions') }}">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-raised-hand"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M6 6.207v9.043a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H6.236a1 1 0 0 1-.447-.106l-.33-.165A.83.83 0 0 1 5 2.488V.75a.75.75 0 0 0-1.5 0v2.083c0 .715.404 1.37 1.044 1.689L5.5 5c.32.32.5.754.5 1.207" />
                                        <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                                    </svg>
                                </span>
                                {{ __('questions') }}
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
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
            console.log('Image preview updated:', e.target.result); // Debugging
        };
        reader.readAsDataURL(file);
    } else {
        console.log('No file selected.');
    }
}

    // Function to remove question
    function removeQuestion(button) {
        button.closest('.question-item').remove();
    }

    </script>
</body>
</html>
