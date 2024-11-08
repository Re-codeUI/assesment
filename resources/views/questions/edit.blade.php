@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Soal Ujian</h2>
        <form action="{{  route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div id="questions-container">
                @foreach($questionsData as $questionIndex => $myquestion)
                <div class="question-item">
                    <div class="card border-0 mb-3">
                        <div class="card-header bg-light">
                            <h4 class="text-gray-700 fw-bold">Edit Soal {{ $questionIndex + 1 }}</h4>
                        </div>
                        <div class="card-body">
                            <!-- Pertanyaan -->
                            <div class="form-group">
                                <label for="question_text_{{ $questionIndex }}">Pertanyaan</label>
                                <textarea name="questions[{{ $questionIndex }}][question]" class="form-control"
                                    rows="3" required>{{ $myquestion['question'] ?? '' }}</textarea>
                            </div>

                            <!-- Pilihan Jawaban -->
                            <div class="form-group">
                                <label>Pilihan Jawaban:</label>
                                @foreach($myquestion['options'] ?? [] as $optionIndex => $option)
                                <input type="text" name="questions[{{ $questionIndex }}][options][]"
                                    class="form-control mb-2" value="{{ $option }}" >
                                @endforeach
                            </div>

                            <!-- Upload Gambar (jika ada) -->
                            <div class="form-group image-upload-container">
                                <label for="question_image_{{ $questionIndex }}">Gambar Pertanyaan</label>
                                <input type="file" name="questions[{{ $questionIndex }}][question_image]"
                                    id="question_image_{{ $questionIndex }}"
                                    onchange="previewImage(event, 'imagePreview_{{ $questionIndex }}')">
                                <img id="imagePreview_{{ $questionIndex }}"
                                    src="{{ isset($myquestion['question_image']) ? asset('storage/' . $myquestion['question_image']) : '' }}"
                                    alt="Preview Gambar" class="image-upload-preview"
                                    style="{{ isset($myquestion['question_image']) ? 'display: block;' : 'display: none;' }}">
                            </div>

                            <!-- Tombol Hapus Soal -->
                            <button type="button" class="btn btn-danger remove-question mt-2"
                                onclick="removeQuestion({{ $questionIndex }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Tombol Simpan -->
            <div class="card-body">
                <button type="submit" class="btn mb-2 bg-green-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download"
                        viewBox="0 0 16 16">
                        <path
                            d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                        <path
                            d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

@endsection