@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Create New Item</h1>
        <hr/>
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Dropdown for Type --}}
            <div class="form-group mb-3">
                <label for="type">Type</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="" disabled selected>Select Type</option>
                    @foreach (\App\Enums\ItemTypeEnum::cases() as $type)
                        <option value="{{ $type->value }}" {{ old('type') === $type->value ? 'selected' : '' }}>
                            {{ $type->value }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="display_name">Display Name</label>
                <input type="text" id="display_name" name="display_name" class="form-control" value="{{ old('display_name') }}" required>
                @error('display_name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="thumbnail_path">Thumbnail Path</label>
                <input type="file" id="thumbnail_path" name="thumbnail_path" class="form-control">
                @error('thumbnail_path')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="static_mesh_path">Static Mesh Path</label>
                <input type="text" id="static_mesh_path" name="static_mesh_path" class="form-control" value="{{ old('static_mesh_path') }}">
                @error('static_mesh_path')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="value">Value</label>
                <input type="text" id="value" name="value" class="form-control" value="{{ old('value') }}">
                @error('value')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Create Item</button>
            <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
