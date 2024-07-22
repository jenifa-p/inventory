@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (Auth::user()->hasRole('super-admin'))
                        <p>Welcome, Admin!</p>
                    @else
                        <p>Welcome, {{ucfirst(Auth::user()->name)}}</p>
                    @endif
                    <div class="mt-3">
                        <button class="btn btn-primary mt-2">
                            <a href="{{ route('inventoryindex') }}">Inventory Item </a>
                        </button>
                        @if(Auth::user()->hasRole('super-admin'))
                            <button class="btn btn-primary mt-2">
                                <a href="{{ route('trackingindex') }}">Inventory Tracking</a>
                            </button>
                        @endif
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection
