@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Soal</h1>
    <form action="{{ route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="namamapel">Nama Mapel</label>
            <input type="text" name="namamapel" id="namamapel" class="form-control" value="{{ $question->namamapel }}" required>
        </div>

        <div class="form-group">
            <label for="tahun_ajar">Tahun Ajar</label>
            <input type="text" name="tahun_ajar" id="tahun_ajar" class="form-control" value="{{ $question->tahun_ajar }}" required>
        </div>

        <div class="form-group">
            <label for="class_level">Kelas</label>
            <input type="number" name="class_level" id="class_level" class="form-control" value="{{ $question->class_level }}" required>
        </div>

        <div class="form-group">
            <label for="jurusan">Jurusan</label>
            <input type="text" name="jurusan" id="jurusan" class="form-control" value="{{ $question->jurusan }}" required>
        </div>

        <div id="questions-container">
            @foreach ($questions as $index => $q)
            <div class="question-item">
                <div class="form-group">
                    <label for="questions[{{ $index }}][question]">Pertanyaan</label>
                    <textarea name="questions[{{ $index }}][question]" class="form-control" rows="3" required>{{ $q['question'] }}</textarea>
                </div>

                <div class="form-group">
                    <label>Pilihan Jawaban</label>
                    @foreach ($q['options'] as $optIndex => $option)
                    <input type="text" name="questions[{{ $index }}][options][{{ $optIndex }}]" class="form-control mb-2" value="{{ $option }}">
                    @endforeach
                </div>

                <div class="form-group">
                    <label>Gambar Soal</label>
                    <input type="file" name="questions[{{ $index }}][question_image]" 
                        id="question_image_{{ $index }}" 
                        onchange="previewImage(event, document.getElementById('imagePreview_{{ $index }}'))">
                        @if (!empty($q['question_image']))
                        <img id="imagePreview_{{ $index }}" 
                             src="{{ asset('storage/' . $q['question_image']) }}" 
                             class="image-upload-preview" 
                             alt="Preview Gambar" 
                             style="max-width: 200px;">
                    @else
                        <img id="imagePreview_{{ $index }}" 
                             class="image-upload-preview" 
                             alt="Preview Gambar" 
                             style="display: none;">
                    @endif
                    
                </div>
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Update Soal</button>
    </form>
</div>
@endsection
