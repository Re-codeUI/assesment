@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-white">
            <h5>Form Edit Soal</h5>
        </div>
        <div class="card-body">
            <form id="question-form" action="{{ route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="namamapel" class="form-control" placeholder="Nama Mapel" value="{{ old('namamapel', $question->namamapel) }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="tahun_ajar" class="form-control" placeholder="Tahun Ajaran" value="{{ old('tahun_ajar', $question->tahun_ajar) }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="class_level" class="form-control" placeholder="Kelas" value="{{ old('class_level', $question->class_level) }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="jurusan" class="form-control" placeholder="Jurusan" value="{{ old('jurusan', $question->jurusan) }}">
                    </div>
                </div>
                
                <div id="questions-container" class="mt-3">
                    <!-- Soal Dinamis Akan Ditambahkan di Sini -->
                    @foreach($questions as $index => $questionItem)
                        <script>
                            const questionData = {
                                question: @json($questionItem['question']),
                                question_image: @json($questionItem['question_image']),
                                options: @json($questionItem['options'] ?? []),
                            };
                            createQuestion({{ $index }}, questionData);
                        </script>
                    @endforeach
                </div>

                <!-- Tombol Simpan -->
                <button type="submit" class="btn btn-success mt-3">Simpan Soal</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/createQuestion.js') }}"></script>
@endpush
