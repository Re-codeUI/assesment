@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card border-0">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between">
                <h4 class="text-gray-700 fw-bold">Create New Role</h4>
                <a class="btn btn bg-gray-300 btn-sm mb-2" href="{{ route('roles') }}"><i class="fa fa-arrow-left"></i>
                    Back
                </a>
            </div>
        </div>
        <div class="card-body bg-white">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('roles.store') }}">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            <input type="text" name="name" placeholder="Name" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permission:</strong>
                            <br />
                            @foreach($permission as $value)
                            <label><input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}" class="name">
                                {{ $value->name }}</label>
                            <br />
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary btn-sm mb-3"><i class="fa-solid fa-floppy-disk"></i>
                            Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection