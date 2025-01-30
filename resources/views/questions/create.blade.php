@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-white">
            <h5>{{ $context === 'create' ? 'Tambah Soal' : 'Edit Soal' }}</h5>
        </div>
        <div class="card-body">
                <form id="question-form" action="{{ $context === 'create' ? route('questions.store') : route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($context === 'edit')
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="namamapel" class="form-control" placeholder="Nama Mapel" 
                                   value="{{ $context === 'edit' ? $question->namamapel : '' }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="tahun_ajar" class="form-control" placeholder="Tahun Ajaran" 
                                   value="{{ $context === 'edit' ? $question->tahun_ajar : '' }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="class_level" class="form-control" placeholder="Kelas" 
                                   value="{{ $context === 'edit' ? $question->class_level : '' }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="jurusan" class="form-control" placeholder="Jurusan" 
                                   value="{{ $context === 'edit' ? $question->jurusan : '' }}">
                        </div>
                    </div>
                    <div id="toolbar" class="mt-3 ">
                        <!-- Operator Aritmatika Dasar -->
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
                    <button type="submit" class="btn btn-success mt-3">{{ $context === 'create' ? 'Simpan Soal' : 'Perbarui Soal' }}</button>
                </form>
        </div>
    </div>
</div>
<script>
    const context = "{{ $context }}";
    const existingQuestions = @json($existingQuestions ?? []);
    console.log("Context:", context);
    console.log("Existing Questions:", existingQuestions);
</script>
@endsection