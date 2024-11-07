@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card bg-white border-0">
        <div class="card-body">
            <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card border-0 bg-white">
                    <div class="card-header bg-white">
                        <h4 class="text-gray-700 fw-bold">Author Informations</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="namamapel">Nama Mapel</label>
                            <input type="text" name="namamapel" class="form-control" placeholder="Nama Mapel" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="class_level">Kelas</label>
                                    <select name="class_level" class="form-control" required>
                                        <option value="1">Kelas 1</option>
                                        <option value="2">Kelas 2</option>
                                        <option value="3">Kelas 3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jurusan">Jurusan</label>
                                    <select name="jurusan" class="form-control" required>
                                        <option value="TKJ">TKJ</option>
                                        <option value="RPL">RPL</option>
                                        <option value="DKV">DKV</option>
                                        <option value="AK">AK</option>
                                        <option value="AP">AP</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajar" id="" class="form-control" placeholder="2024-2025">
                        </div>
                    </div>
                </div>
                <div id="questions-container">
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
                                            <textarea name="questions[0][question]" class="form-control" rows="3" placeholder="Masukkan pertanyaan"
                                                required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                Pilihan Jawaban:
                                                <label class="text-danger">(Opsional)</label>
                                            </label>
                                            <div>
                                                <input type="text" name="questions[0][options][]" class="form-control mb-2" placeholder="Pilihan A">
                                                <input type="text" name="questions[0][options][]" class="form-control mb-2" placeholder="Pilihan B">
                                                <input type="text" name="questions[0][options][]" class="form-control mb-2" placeholder="Pilihan C">
                                                <input type="text" name="questions[0][options][]" class="form-control mb-2" placeholder="Pilihan D">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="image-upload-container">
                                            <input type="file" name="questions[0][question_image]" id="question_image_0"
                                                onchange="previewImage(event, document.getElementById('imagePreview_0'))">
                                            <label for="question_image_0" class="text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill"
                                                    viewBox="0 0 16 16">
                                                    <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                                    <path
                                                        d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0" />
                                                </svg>
                                            </label>
                                            <img id="imagePreview_0" class="image-upload-preview" alt="Preview Gambar" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn mb-2 bg-red-300 remove-question">
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

                        </div>
                    </div>
                </div>

                <!-- Buttons to add new question and submit -->
                <div class="card-body">
                    <button type="button" class="btn mb-2 bg-blue-300" onclick="addQuestion()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5" />
                            <path
                                d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z" />
                        </svg>
                    </button>
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
    </div>
</div>

@endsection