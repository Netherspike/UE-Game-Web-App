@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Character Details</h1>
            <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        </div>

        <div class="card my-4">
            <div class="card-header">
                Character Information
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $character->name }}</p>
                <p><strong>Class:</strong> {{ $character->class }}</p>
                <p><strong>Gender:</strong> {{ ucfirst($character->gender) }}</p>
                <p><strong>Created At:</strong> {{ $character->created_at }}</p>
            </div>
        </div>

        <!-- Additional Sections, if needed -->
        @if (!empty($character->additional_data))
            <div class="card my-4">
                <div class="card-header">
                    Additional Information
                </div>
                <div class="card-body">
                    <p>{{ $character->additional_data }}</p>
                </div>
            </div>
        @endif
    </div>
@endsection
