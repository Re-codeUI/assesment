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
                                onclick="removeQuestion({{ $questionIndex }})">Hapus Soal</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Update Semua Soal</button>
        </form>
    </div>

@endsection