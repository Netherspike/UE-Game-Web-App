<table class="table mt-3">
    <thead>
    <tr>
        <th>Type</th>
        <th>Display Name</th>
        <th>Value</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
        @forelse($items as $item)
            <tr>
                <td>{{ $item->type }}</td>
                <td>{{ $item->display_name }}</td>
                <td>{{ $item->value }}</td>
                <td>
                    <a href="{{ route('items.show', $item->id) }}" class="btn btn-info ">View</a>
                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning ">Edit</a>
                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger " onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No items found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
