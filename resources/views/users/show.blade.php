@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card border-0 bg-white">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between">
                <h4 class="text-gray-700 fw-bold">Detail User</h4>
                <a class="btn btn bg-gray-300 btn-sm mb-2" href="{{ route('users') }}"><i class="fa fa-arrow-left"></i>
                    Back
                </a>
            </div>
        </div>
        <div class="card-body bg-white">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {{ $user->name }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        {{ $user->email }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Roles:</strong>
                        @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                            <label class="badge badge-success">{{ $v }}</label>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection