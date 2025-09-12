@extends('layouts.app')

@section('title', 'View User')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>User Details</h1>

            <a href="{{ $previousUrl ?? route('users.index') }}" class="btn btn-primary">Back</a>
        </div>

        <!-- User Info -->
        <div class="card my-4">
            <div class="card-header">User Information</div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Created At:</strong> {{ $user->created_at }}</p>
            </div>
        </div>

        <!-- List of Characters -->
        <div class="card my-4">
            <div class="card-header">Associated Characters</div>
            <div class="card-body">
                @if ($user->characters->isEmpty())
                    <p>This user does not have any associated characters.</p>
                @else
                    <div id="characters-table-container">
                        @include('management.characters.partials.characters_table',
                            [
                                'characters' => $user->characters,
                                'from' => request()->fullUrl()
                            ]
                        )
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
