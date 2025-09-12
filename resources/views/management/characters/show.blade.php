@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Character Details</h1>
            <a href="{{ $previousUrl ?? route('characters.index') }}" class="btn btn-primary">Back</a>
        </div>
        <!-- Character Information Card -->
        <div class="card my-4">
            <div class="card-header">
                Character Information
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $character->id }}</p>
                <p><strong>Name:</strong> {{ $character->name }}</p>
                <p><strong>Class:</strong> {{ $character->class }}</p>
                <p><strong>Gender:</strong> {{ $character->gender }}</p>
                <p>
                    <strong>Owner:</strong>
                        <a href="{{ route('users.show',
                            [
                                'user' => $character->user,
                                'from' => request()->fullUrl()
                            ]
                        ) }}">
                            {{ $character->user->name }}
                        </a>
                </p>
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
