@extends('layouts.app')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between">
            <h4 class="text-gray-700 fw-bold">Users</h4>
            <div>
                <a href="{{route('users')}}" class="btn btn-outline-light">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('users.create') }}" class="btn btn-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                        <path
                            d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5" />
                        <path
                            d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z" />
                    </svg>
                    Tambah Pengguna
                </a>
            </div>
        </div>
    </div>
    <div class="card-body bg-white border-0">
        @session('success')
            <div class="alert alert-success" role="alert">
                {{ $value }}
            </div>
        @endsession
        <table class="table table-striped">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($data as $key => $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                    <label class="badge bg-success">{{ $v }}</label>
                    @endforeach
                    @endif
                </td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}"><i class="fa-solid fa-list"></i>
                        Show</a>
                    <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}"><i
                            class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>

        {!! $data->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection