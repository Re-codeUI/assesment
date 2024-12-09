@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-white">
            <h5>Form Soal</h5>
        </div>
        <div class="card-body">
            <form id="question-form" action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="namamapel" class="form-control" placeholder="Nama Mapel" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="tahun_ajar" class="form-control" placeholder="Tahun Ajaran" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="class_level" class="form-control" placeholder="Kelas" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="jurusan" class="form-control" placeholder="Jurusan" required>
                    </div>
                </div>

                <div id="questions-container" class="mt-3">
                    <!-- Soal Dinamis Akan Ditambahkan di Sini -->
                    <div class="row mt-3">
                        <div class="col-md-2 offset-md-10">
                            <button type="button" class="btn btn-primary w-100 mt-2 add-question-btn" onclick="addQuestion()">Tambah Soal</button>
                        </div>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <button type="submit" class="btn btn-success mt-3">Simpan Soal</button>
            </form>
        </div>
    </div>
</div>
@endsection