@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card border-o bg-white">
        <div class="card-header ">
            <h3 class="text-center fw-bolder" >SOAL ASESMEN SUMATIF TENGAH SEMESTER (ASTS)</h3>
            <h3 class="text-center fw-bolder" >SMK AL-BAHRI TP. {{$question->tahun_ajar}}</h3>
            <section class="instructions">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="fw-bolder">Mapel</td>
                            <td>:</td>
                            <td>{{$question->namamapel}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">Kelas</td>
                            <td>:</td>
                            <td>{{$question->class_level}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">Tanggal</td>
                            <td>:</td>
                            <td>Kelas</td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">Waktu</td>
                            <td>:</td>
                            <td>Kelas</td>
                        </tr>
                        <tr>
                            <td class="fw-bolder">Guru</td>
                            <td>:</td>
                            <td>Kelas</td>
                        </tr>
                    </tbody>
                </table>
                <h2 class="fw-bolder">Petunjuk Pengisian</h2>
                <ol>
                  <li>Periksa dan bacalah soal dengan teliti sebelum anda menjawabnya.</li>
                  <li>Laporkan kepada pengawas ujian jika terdapat tulisan yang kurang jelas, rusak, atau jumlah soal kurang.</li>
                  <li>Jawaban ditulis di halaman belakang lembar soal.</li>
                  <li>Periksalah pekerjaan anda sebelum diserahkan kepada pengawas ujian.</li>
                </ol>
              </section>
        </div>
        <div class="card-body">
            <div class="card-body">
                @foreach ($questions as $index => $q)
                    <div class="form-group">
                        <!-- Gambar Soal -->
                        @if (!empty($q['question_image']))
                            <div class="image-upload-container mb-3">
                                <img id="imagePreview_{{ $index }}" 
                                     src="{{ asset('storage/' . $q['question_image']) }}" 
                                     class="image-upload-preview" 
                                     alt="Gambar Soal" 
                                     style="max-width: 100%; max-height: 300px;">
                            </div>
                        @endif
            
                        <!-- Pertanyaan -->
                        <div class="question d-flex ">
                            <label for="questions[{{ $index }}][question]" class="fw-bold me-3">{{ $loop->iteration }}.</label>
                            
                            <blockquote>
                                 {{ $q['question'] }}
                            </blockquote>
                        </div>
            
                        <!-- Text Area untuk Esai -->
                        @if (empty($q['options']))
                            <textarea name="questions[{{ $index }}][answer]" 
                                      rows="4" 
                                      class="form-control mb-3" 
                                      placeholder="Tulis jawaban Anda di sini..."></textarea>
                        @endif
            
                        <!-- Pilihan Ganda -->
                        @if (!empty($q['options']))
                            <ul class="options">
                                @if (!empty($q['options']))
                                    @foreach ($q['options'] as $optIndex => $option)
                                        @if (!empty($option))
                                            <li>
                                                <label>
                                                    {{$letters[$loop->index]}}.
                                                    {{ $option }}
                                                </label>
                                            </li>
                                        @endif
                                    @endforeach
                                @else
                                    <li><em>Tidak ada pilihan tersedia.</em></li>
                                @endif
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
            
        </div>
    </div>
    
  </div>

@endsection