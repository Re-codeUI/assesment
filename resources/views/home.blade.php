@extends('layouts.app')

@section('content')
<div class="card bg-white border-0 shadow-sm">
    <div class="card-header d-flex align-item-center bg-white border-0">
        <h5>
            {{ __('Hallo Selamat') }} {{ $timeOfDay }}, 
            <h4 class="text-sky-500">{{Auth::user()->name}}</h4>
        </h5>
        
    </div>

    <div class="card-body bg-white">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if(Route::has('login'))
            @role('admin')
                <div class="row">
                    <div class="col-md-6">
                        <h5>
                            
                            {{__('Jumlah Pengguna')}}
                        </h5>
                    </div>
                </div>
            @endrole

        @endif
        
    </div>
</div>
@endsection
