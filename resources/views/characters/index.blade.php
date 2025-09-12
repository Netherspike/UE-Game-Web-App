@extends('layouts.app')

@section('title', 'My Characters')
@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>My Characters</h1>
            <a href="{{ route('mycharacters.create') }}" class="btn btn-primary">Create New Character</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($characters->isNotEmpty())
            <table class="table mt-3">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Gender</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($characters as $character)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $character->name }}</td>
                        <td>{{ $character->class }}</td>
                        <td>{{ ucfirst($character->gender) }}</td>
                        <td>{{ $character->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('mycharacters.show', $character->id) }}" class="btn btn-info ">View</a>
                            <a href="{{ route('mycharacters.edit', $character->id) }}" class="btn btn-warning ">Edit</a>
                            <form action="{{ route('mycharacters.destroy', $character->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger " onclick="return confirm('Are you sure you want to delete this character?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No characters found!</p>
        @endif
    </div>
@endsection
