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
    @vite(['resources/sass/ui.scss', 'resources/js/app.js'])
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

        let questionCount = 0; // Counter soal
        const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; // Untuk opsi jawaban

        // Fungsi membuat HTML opsi jawaban
        function createAnswerOptionHtml(index, optionIndex) {
            const label = alphabet[optionIndex]; // Opsi A, B, C, ...
            return `
                <div class="mb-3" id="option-${index}-${optionIndex}">
                    <label class="form-label" for="option${index}-${optionIndex}">Opsi ${label}</label>
                    <input type="text" class="form-control" name="questions[${index}][options][]" id="option${index}-${optionIndex}">
                </div>
            `;
        }

        // Fungsi menambah opsi jawaban
        function addOption(index) {
            const container = document.getElementById(`options-container-${index}`);
            const options = container.querySelectorAll(".form-control");
            const optionIndex = options.length;

            if (optionIndex < alphabet.length) {
                const newOptionHtml = createAnswerOptionHtml(index, optionIndex);
                const addOptionButton = container.querySelector(".add-option-btn");
                if (addOptionButton) {
                    addOptionButton.insertAdjacentHTML("beforebegin", newOptionHtml);
                } else {
                    container.insertAdjacentHTML("beforeend", newOptionHtml);
                }
            } else {
                alert("Jumlah opsi maksimal sudah tercapai!");
            }
        }

        // Fungsi membuat soal baru
        function createQuestionHtml(index) {
            return `
                <div class="row mt-3 question-item" id="question-${index}">
                    <div class="col-md-10">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <textarea name="questions[${index}][question]" cols="30" rows="3" class="form-control" placeholder="Tulis soal di sini"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="questions[${index}][question_image]" class="form-control" onchange="previewImage(event, 'imagePreview_${index}')">
                                    <img id="imagePreview_${index}" class="image-upload-preview" alt="Preview Gambar" style="display: none; max-height: 150px;">
                                </div>

                                <div class="col-md-6 mt-2" id="options-container-${index}">
                                    <button type="button" class="btn btn-secondary mt-2 add-option-btn" onclick="addOption(${index})">Tambah Opsi Baru</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary w-100 mt-2 add-question-btn" onclick="addQuestion()">Tambah Soal</button>
                        <button type="button" class="btn btn-danger w-100 mt-2" onclick="removeQuestion(${index})">Hapus Soal</button>
                    </div>
                </div>
            `;
        }

        // Fungsi menambah soal baru
        function addQuestion() {
            const container = document.getElementById("questions-container");
            container.querySelectorAll('.add-question-btn').forEach(btn => btn.remove());
            const newQuestionHtml = createQuestionHtml(questionCount);
            container.insertAdjacentHTML("beforeend", newQuestionHtml);
            questionCount++;
        }

        // Fungsi hapus soal
        function removeQuestion(index) {
            const questionElement = document.getElementById(`question-${index}`);
            if (questionElement) questionElement.remove();

            if (document.getElementById("questions-container").children.length === 0) {
                questionCount = 0;
                document.getElementById("questions-container").insertAdjacentHTML(
                    "beforeend",
                    `<div class="row mt-3">
                        <div class="col-md-2 offset-md-10">
                            <button type="button" class="btn btn-primary w-100 mt-2 add-question-btn" onclick="addQuestion()">Tambah Soal</button>
                        </div>
                    </div>`
                );
            }
        }
        // Fungsi untuk preview gambar
        function previewImage(event, previewId) {
            const file = event.target.files[0];
            const imgElement = document.getElementById(previewId);
            
            // Jika file ada, update preview gambar
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imgElement.src = e.target.result;  // Update src gambar
                    imgElement.style.display = 'block'; // Tampilkan gambar baru
                };
                reader.readAsDataURL(file);
            } else {
                imgElement.style.display = 'none';  // Jika tidak ada gambar, sembunyikan
            }
        }
    </script>
</body>
</html>
