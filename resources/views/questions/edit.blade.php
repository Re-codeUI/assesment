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
                    <input type="hidden" name="user_id" lass="form-control" value="{{ Auth::user()->id }}" required>
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
                                        <input type="file" 
                                       name="questions[{{ $index }}][question_image]" 
                                       id="question_image_{{ $index }}" 
                                       onchange="previewImage(event, document.getElementById('imagePreview_{{ $index }}'))">
                                <input type="hidden" name="questions[{{ $index }}][existing_image]" value="{{ isset($q['question_image']) ? $q['question_image'] : '' }}">
                                <label for="question_image_{{ $index }}" class="text-gray-700">
                                    <img id="imagePreview_{{ $index }}" 
                                         src="{{ isset($q['question_image']) && !empty($q['question_image']) ? asset('storage/' . $q['question_image']) : '' }}" 
                                         class="image-upload-preview" 
                                         alt="Preview Gambar" 
                                         style="{{ isset($q['question_image']) && !empty($q['question_image']) ? 'max-width: 200px;' : 'display: none;' }}">

                                    @if (!isset($q['question_image']) || empty($q['question_image']))
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                            <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0" />
                                        </svg>
                                    @endif
                                </label>
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