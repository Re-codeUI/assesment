@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card bg-white border-0">
            <div class="card-header bg-white">
                <h4 class="text-gray-700 fw-bold">Author Informations</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="namamapel">Nama Mapel</label>
                    <input type="text" name="namamapel" id="namamapel" class="form-control" value="{{ $question->namamapel }}" required>
                </div>
                <div class="form-group">
                    <label for="tahun_ajar">Tahun Ajar</label>
                    <input type="text" name="tahun_ajar" id="tahun_ajar" class="form-control" value="{{ $question->tahun_ajar }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="class_level">Kelas</label>
                            <input type="number" name="class_level" id="class_level" class="form-control" value="{{ $question->class_level }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jurusan">Jurusan</label>
                            <input type="text" name="jurusan" id="jurusan" class="form-control" value="{{ $question->jurusan }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div id="questions-container">
            @foreach ($questions as $index => $q)
            <div class="question-item">
                <div class="card border-0">
                    <div class="card-header border-0 bg-white border-top">
                        <h4 class="text-gray-700 fw-bold">Edit Question</h4>
                    </div>
                    <div class="card-body bg-white">
                        <div class="row">
                            <div class="col-md-6">
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
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="image-upload-container">
                                        <input type="file" name="questions[{{ $index }}][question_image]" 
                                        id="question_image_{{ $index }}" 
                                        onchange="previewImage(event, document.getElementById('imagePreview_{{ $index }}'))">
                                        <label for="question_image_0" class="text-gray-700">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
         </div>
         <div class="card border-0 bg-white">
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
         </div>
         
        
    </form>
</div>
@endsection
