@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Edit Item: {{ $item->display_name }}</h1>
        <hr/>
        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required>
                    @foreach(\App\Enums\ItemTypeEnum::cases() as $type)
                        <option value="{{ $type->value }}" {{ old('type', $item->type) == $type ? 'selected' : '' }}>
                            {{ $type->value }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="display_name" class="form-label">Display Name</label>
                <input type="text" id="display_name" name="display_name" class="form-control @error('display_name') is-invalid @enderror"
                       value="{{ old('display_name', $item->display_name) }}" required>
                @error('display_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $item->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="thumbnail_path" class="form-label">Thumbnail</label>
                <input type="file" id="thumbnail_path" name="thumbnail_path" class="form-control @error('thumbnail_path') is-invalid @enderror">
                @if ($item->thumbnail_path)
                    <div class="mt-2">
                        <img src="{{ asset($item->thumbnail_path) }}" alt="Thumbnail" class="img-thumbnail" style="width: 150px; height: auto;">
                    </div>
                @endif
                @error('thumbnail_path')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="static_mesh_path" class="form-label">Static Mesh Path</label>
                <input type="text" id="static_mesh_path" name="static_mesh_path" class="form-control @error('static_mesh_path') is-invalid @enderror"
                       value="{{ old('static_mesh_path', $item->static_mesh_path) }}">
                @error('static_mesh_path')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="value">Value</label>
                <input type="text" id="value" name="value" class="form-control" value="{{ old('value', $item->value) }}">
                @error('value')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-info">Update Item</button>
                <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
