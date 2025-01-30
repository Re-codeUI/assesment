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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.min.js"></script>
    <!-- Tambahkan MathQuill CSS -->
    <script type="text/javascript" async
        src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
    </script>
    
    <!-- Scripts -->
    @vite([
    'resources/js/createQuestion.js',   // Pastikan ini dimuat lebih dulu
    'resources/js/app.js',
    'resources/js/toolbarLatext.js',
    'resources/js/imagePreview.js',
    'resources/js/removeQuestion.js',
    'resources/js/submitForm.js',
    'resources/sass/ui.scss',
])
    <style>
        #toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-bottom: 10px;
        }
        #toolbar button {
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
            border: 1px solid #000;
            border-radius: 3px;
            background-color: #000;
        }
        #toolbar button:hover {
            background-color: #000;
        }
        .math-question-display {
            display: inline-block; /* Agar sesuai dengan elemen Latex */
            font-size: 1.2em; /* Ukuran font lebih besar agar mudah dibaca */
            font-family: 'Cambria Math', 'Times New Roman', serif; /* Gunakan font matematika */
            padding: 10px; /* Ruang sekitar teks */
            margin: 10px 0; /* Jarak antar elemen */
            background-color: #f9f9f9; /* Warna latar belakang lembut */
            border: 1px solid #ddd; /* Tambahkan border tipis */
            border-radius: 5px; /* Sudut border membulat */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Tambahkan efek bayangan */
            text-align: center; /* Pusatkan teks */
            color: #333; /* Warna teks */
            overflow-x: auto; /* Tambahkan scrollbar horizontal jika konten terlalu panjang */
        }
        

    </style>
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
        document.addEventListener("DOMContentLoaded", () => {
            console.log("Halaman dimuat");

            if (context === "edit") {
                console.log("Mode edit aktif");
                console.log("Soal yang ada:", existingQuestions);

                // Loop data soal dan tambahkan form soal ke dalam kontainer
                existingQuestions.forEach((question, index) => {
                    const questionHtml = createQuestionHtml(index, question); // Hasilkan HTML untuk soal
                    document.getElementById("questions-container").insertAdjacentHTML("beforeend", questionHtml);
                });
            } else if (context === "create") {
                console.log("Mode create aktif");
            }
        });


    </script>
</body>
</html>
