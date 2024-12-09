@extends('layouts.app')

@section('content')
<div class="card bg-white border-0">
    <div class="card-header d-flex align-item-center bg-white border-0">
        <h5>
            {{ __('Dashboard') }} 
        </h5>
        
    </div>

    <div class="card-body bg-white">
        
        @if(Route::has('login'))
            @role('admin')
                <div class="row">
                    <div class="col-md-3">
                        <div class="card border-0">
                            <div class="card-body bg-info-subtle">
                                <p class="d-flex">
                                   {{ $timeOfDay }}, 
                                    <p class="text-sky-500">{{Auth::user()->name}}</p>
                                </p> 
                            </div>
                        </div>
                    </div>
                </div>
            @endrole

        @endif
        
    </div>
</div>
@endsection
