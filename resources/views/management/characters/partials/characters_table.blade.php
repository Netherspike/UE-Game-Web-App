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
    @forelse ($characters as $character)
        <tr>
            <td>{{ $character->id }}</td>
            <td>{{ $character->name }}</td>
            <td>{{ $character->class }}</td>
            <td>{{ ucfirst($character->gender) }}</td>
            <td>{{ $character->created_at }}</td>
            <td>
                <a href="{{ route('characters.show', $character->id) }}" class="btn btn-info">View</a>
                <a href="{{ route('characters.edit', $character->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('characters.destroy', $character->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="text-center">No characters found</td>
        </tr>
    @endforelse
    </tbody>
</table>

