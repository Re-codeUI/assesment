@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card border-0">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between">
                <h4 class="text-gray-700 fw-bold">Role Management</h4>
                @can('role-create')
                <a class="btn btn-success btn-sm mb-2" href="{{ route('roles.create') }}"><i class="fa fa-plus"></i> Create
                    New Role</a>
                @endcan
            </div>
        </div>
        <div class="card-body bg-white">
            @session('success')
            <div class="alert alert-success" role="alert">
                {{ $value }}
            </div>
            @endsession

            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('roles.show',$role->id) }}"><i class="fa-solid fa-list"></i>
                            Show</a>
                        @can('role-edit')
                        <a class="btn btn-primary btn-sm" href="{{ route('roles.edit',$role->id) }}"><i
                                class="fa-solid fa-pen-to-square"></i> Edit</a>
                        @endcan

                        @can('role-delete')
                        <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display:inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </table>

            {!! $roles->links('pagination::bootstrap-5') !!}
        </div>
    </div>
</div>
@endsection