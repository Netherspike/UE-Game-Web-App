@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h1>Create New Character</h1>
        <form action="{{ route('mycharacters.store') }}" method="POST">
            @csrf
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
                <select class="form-select" id="gender" name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Create</button>
        </form>
    </div>
@endsection
