@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Inventory Item') }}</div>
                <button class="btn btn-primary" style="margin-top:15px">
                    <a href="{{ route('inventoryindex') }}">Back to Inventory List</a>
                </button> 
                <div class="card-body create-body">
                    <form method="POST" action="{{ route('inventoryupdate', $inventory->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                name="name" 
                                value="{{ $inventory->name}}" 
                                required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea id="description" 
                                class="form-control @error('description') is-invalid @enderror" 
                                name="description">{{$inventory->description}}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="quantity_in_stock">{{ __('Quantity in Stock') }}</label>
                            <input id="quantity_in_stock" 
                                type="number" 
                                class="form-control @error('quantity_in_stock') is-invalid @enderror" 
                                name="quantity_in_stock" 
                                value="{{$inventory->quantity_in_stock}}" required>
                            @error('quantity_in_stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="inventory_level">{{ __('Inventory Level') }}</label>
                            <select 
                                class="@error('inventory_level') is-invalid @enderror"
                                name="inventory_level" id="inventory_level" required>
                                <option value="">Selcet Inventory Level</option>
                                <option value="received" {{$inventory->inventory_level == "received"? "selected" : "" }}>Received</option>
                                <option value="sold" {{$inventory->inventory_level == "sold"? "selected" : "" }}>Sold</option>
                            </select>
                            @error('inventory_level')
                                <span class="inventory_level" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price">{{ __('Price') }}</label>
                            <input id="price" 
                                type="text" 
                                class="form-control @error('price') is-invalid @enderror" 
                                name="price" 
                                value="{{ $inventory->price}}" required>
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary update-btn">
                                {{ __('Update Item') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
