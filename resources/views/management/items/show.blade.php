@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Item Details</h1>
            <a href="{{ route('items.index') }}" class="btn btn-primary">Back</a>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h3>{{ $item->display_name }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Type:</strong> {{ $item->type }}</p>
                <p><strong>Description:</strong> {{ $item->description }}</p>

                @if($item->thumbnail_path)
                    <p><strong>Thumbnail:</strong></p>
                    <img src="{{ asset('storage/' . $item->thumbnail_path) }}" alt="{{ $item->display_name }}" class="img-fluid rounded">
                @endif

                <p><strong>Static Mesh Path:</strong> {{ $item->static_mesh_path }}</p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                <h4>Additional Details</h4>
            </div>
            <div class="card-body">
                <p><strong>Created At:</strong> {{ $item->created_at->format('F j, Y, g:i a') }}</p>
                <p><strong>Updated At:</strong> {{ $item->updated_at->format('F j, Y, g:i a') }}</p>
            </div>
        </div>
    </div>
@endsection
