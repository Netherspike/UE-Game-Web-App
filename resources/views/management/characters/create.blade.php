@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h1>Create New Character</h1>
        <hr/>
        <form action="{{ route('characters.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">User ID</label>
                <input type="number" class="form-control" id="user_id" name="user_id" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="class" class="form-label">Character Type</label>
                <?php use App\Enums\CharacterClassEnum; ?>
                <select class="form-select" id="class" name="class">
                    @foreach (CharacterClassEnum::cases() as $key => $value)
                        <option value="{{$value}}">{{$value}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Character Gender</label>
                <select id="gender" name="gender" class="form-select">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Create</button>
        </form>
    </div>
@endsection
