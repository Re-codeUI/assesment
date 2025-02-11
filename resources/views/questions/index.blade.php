@extends('layouts.app')

@section('content')

<div class="card border-0">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between">
            <h4 class="text-gray-700 fw-bold">Question</h4>
            <div>
                <a href="{{route('home')}}" class="btn bg-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                    </svg>
                </a>
                <a href="{{route('questions.create')}}" class="btn bg-blue-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                        <path
                            d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5" />
                        <path
                            d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body bg-white border-0">
        <div class="table-responsive">
            <table class="table table-stripe">
                <thead>
                    <tr>
                        <th>Jurusan</th>
                        <th>Kelas</th>
                        <th>Tahun Ajar</th>
                        <th>Nama Mapel</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($questions as $question)
                        <tr>
                            <td>{{$question->jurusan  }}</td>
                            <td>{{$question->class_level  }}</td>
                            <td>{{$question->tahun_ajar }}</td>
                            <td>{{$question->namamapel }}</td>
                            <td>{{$question->created_at }}</td>
                            <td>close</td>
                            <td>

                                <form id="delete-form-{{ $question->id }}" action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{route('questions.edit',$question->id)}}" class="btn btn-warning btn-sm">Edit soal</a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $question->id }})">Hapus soal</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Maaf Data Belum Ada
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        {{ $questions->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection
<script>
    function confirmDelete(questionId) {
        if (confirm("Apakah Anda yakin ingin menghapus soal ini?")) {
            document.getElementById(`delete-form-${questionId}`).submit();
        }
    }
</script>
