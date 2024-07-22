@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>Inventory Items</h3>  
        <button class="btn btn-primary mt-2">
            <a href="{{ route('home') }}">Back to Dashboard</a>
        </button>   
        <button class="btn btn-primary mt-2">
            <a href="{{ route('inventorycreate') }}">Add Item</a>
        </button>  
        <button class="btn btn-primary mt-2">
            <a href="{{ route('inventoryexport') }}">Export Inventory Data</a>
        </button>  
        <form action="{{ route('inventoryimport') }}" method="POST" enctype="multipart/form-data" style="margin-top: 20px;">
            @csrf
            <div class="form-group">
                <label for="file">Import Inventory Data:</label>
                <input type="file" name="file" id="file" class="form-control" required>
                <button type="submit" class="btn btn-primary" style="margin-left: 13px;">Import</button>
            </div>
        </form>
        <form action="{{ route('inventoryindex') }}" method="GET" style="margin-top: 20px;">
            <div class="form-group">                     
                <input type="text" class="form-control" name="search" id="search" placeholder="Search" value="{{ app('request')->get('search') }}">
                <button type="submit" class="btn btn-primary" style="margin-left: 13px;">Search</button>
            </div>
        </form>
        <div class="table-container inventory-table" id="inventory-table">
            <div class="table-row header">
                <div class="table-cell">Name</div>
                <div class="table-cell">Description</div>
                <div class="table-cell">Quantity in Stock</div>
                <div class="table-cell">Inventory Level</div>
                <div class="table-cell">Price</div>
                <div class="table-cell">Actions</div>
            </div>
            @foreach($inventoryItems as $item)
                <div class="table-row {{ $item->isLowStock() ? 'low-stock' : '' }}">
                    <div class="table-cell">{{ ucfirst($item->name) }}</div>
                    <div class="table-cell">{{ ucfirst($item->description) }}</div>
                    <div class="table-cell">{{ $item->quantity_in_stock }}</div>
                    <div class="table-cell">{{ ucfirst($item->inventory_level) }}</div>
                    <div class="table-cell">{{ $item->price }}</div>
                    <div class="table-cell">
                        <button class="btn btn-primary">
                            <a href="{{ route('inventoryedit', $item->id)}}" 
                            target="_blank">Edit</a>
                        </button>
                        <form action="{{ route('inventorydestroy', $item->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="btn btn-danger" 
                                onclick="return confirm('Are you sure you want to delete this Item?')">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

