@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-white">
            <h5>Edit Soal</h5>
        </div>
        <div class="card-body">
            <form id="edit-question-form" action="{{ route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="namamapel" class="form-control" placeholder="Nama Mapel" value="{{ $question->namamapel }}" required>
                        <input type="hidden" name="user_id" lass="form-control" value="{{ Auth::user()->id }}" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="tahun_ajar" class="form-control" placeholder="Tahun Ajaran" value="{{ $question->tahun_ajar }}" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="class_level" class="form-control" placeholder="Kelas" value="{{ $question->class_level }}" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="jurusan" class="form-control" placeholder="Jurusan" value="{{ $question->jurusan }}" required>
                    </div>
                </div>

                <div id="questions-container" class="mt-3">
                    @foreach ($questions as $index => $q)
                        <div class="row mt-3 question-item" id="question-{{ $index }}">
                            <div class="col-md-10">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <textarea name="questions[{{ $index }}][question]" cols="30" rows="3" class="form-control" placeholder="Tulis soal di sini">{{ $q['question'] }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="file" name="questions[{{ $index }}][question_image]" class="form-control" onchange="previewImage(event, 'imagePreview_{{ $index }}')">
                                                @if (!empty($q['question_image']))
                                                    <img id="imagePreview_{{ $index }}" src="{{ asset('storage/' . $q['question_image']) }}" alt="Soal Image" class="img-thumbnail mt-2" style="max-height: 150px;">
                                                    <input type="hidden" name="questions[{{ $index }}][existing_image]" value="{{ $q['question_image'] }}">
                                                @else
                                                    <!-- Menampilkan gambar preview jika belum ada gambar lama -->
                                                    <img id="imagePreview_{{ $index }}" class="image-upload-preview" alt="Preview Gambar" style="display: none; max-height: 150px;">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2" id="options-container-{{ $index }}">
                                            @foreach ($q['options'] as $optIndex => $option)
                                                <div class="mb-3" id="option-{{ $index }}-{{ $optIndex }}">
                                                    <label class="form-label" for="option{{ $index }}-{{ $optIndex }}">Opsi {{ chr(65 + $optIndex) }}</label>
                                                    <input type="text" class="form-control" name="questions[{{ $index }}][options][]" id="option{{ $index }}-{{ $optIndex }}" value="{{ $option }}">
                                                </div>
                                            @endforeach
                                            <button type="button" class="btn btn-secondary mt-2 add-option-btn" onclick="addOption({{ $index }})">Tambah Opsi Baru</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger w-100 mt-2" onclick="removeQuestion({{ $index }})">Hapus Soal</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Tombol Tambah Soal -->
                <div class="row mt-3">
                    <div class="col-md-2 offset-md-10">
                        <button type="button" class="btn btn-primary w-100 add-question-btn" onclick="addQuestion()">Tambah Soal</button>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <button type="submit" class="btn btn-success mt-3">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

@endsection