@extends('layouts.app')

@section('title', 'My Account Details')

@section('content')
    <div class="container mt-5">
        <h2>My Account</h2>

        <!-- User Details -->
        <ul class="list-group mb-5">
            <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
            <li class="list-group-item"><strong>Created At:</strong> {{ $user->created_at->format('F j, Y, g:i a') }}</li>
            <li class="list-group-item"><strong>Updated At:</strong> {{ $user->updated_at->format('F j, Y, g:i a') }}</li>
        </ul>

        <a href="{{ route('account.edit') }}" class="btn btn-dark mt-3">Edit Account</a>
        <form method="POST" action="{{ route('account.destroy') }}" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your account and associated characters?')">Delete Account</button>
        </form>
    </div>
@endsection
