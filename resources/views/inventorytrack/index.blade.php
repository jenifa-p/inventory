@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>Inventory Tracking</h3>    
        <button class="btn btn-primary mt-2">
            <a href="{{ route('home') }}">Back to Dashboard</a>
        </button>   
        <div class="table-container">
            <div class="table-row header">
                <div class="table-cell">Name</div>
                <div class="table-cell">Quantity</div>
                <div class="table-cell">Action</div>
                <div class="table-cell">Activity By</div>
                <div class="table-cell">Activity At</div>
            </div>
            @foreach($inventoryactions as $action)
                <div class="table-row">
                    <div class="table-cell">{{ ucfirst($action->inventory->name) }}</div>
                    <div class="table-cell">{{ ucfirst($action->quantity) }}</div>
                    <div class="table-cell">{{ ucfirst($action->action) }}</div>
                    <div class="table-cell">{{ ucfirst($action->user->name) }}</div>
                    <div class="table-cell">{{ $action->updated_at }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection