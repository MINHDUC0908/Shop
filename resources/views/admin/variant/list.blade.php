@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Variants List</h1>
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <a href="{{ route('variants.create') }}" class="btn btn-primary mb-3">Create New Variant</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Product</th>
                <th scope="col">Attribute</th>
                <th scope="col">Colors</th>
                <th scope="col">Price</th>
                <th scope="col">Discount Price</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($variants as $variant)
            <tr>
                <td>{{ $variant->product_name }}</td>
                @if (!empty($variant->attribute))
                    <td>{{ $variant->attribute }}</td> 
                @else
                    <td>N/A</td>
                @endif
                <td>{{ implode(', ', json_decode($variant->colors)) }}</td> 
                <td>{{ number_format($variant->price, 2) }}₫</td> 
                <td>
                    @if($variant->discount_price)
                        {{ number_format($variant->discount_price, 2) }}%
                    @else
                        N/A
                    @endif
                </td> 
                <td>{{ ucfirst($variant->status) }}</td> 
                <td>
                    <a href="{{ route('variants.show', ['variant' => $variant->id]) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-edit"></i> Show
                    </a>
                    <a href="{{ route('variants.edit', $variant->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('variants.destroy', $variant->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this variant?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
