@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    <div class="container mt-5">
        <!-- Flexbox container for alignment -->
        <div class="d-flex justify-content-between align-items-center">
            <!-- H1 on the left -->
            <h1>User Management</h1>

            <!-- Create New User button on the right -->
            <a href="{{ route('users.create') }}" class="btn btn-primary">Create New User</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Search Form -->
        <div class="row mb-4">
            <div class="col-md-8">
                <input
                    type="text"
                    id="search-box"
                    class="form-control"
                    placeholder="Search users by name or email..."
                    value="{{ request('search') }}">
            </div>
        </div>

        <!-- Users Table Container -->
        <div id="users-table-container">
            @include('management.users.partials.users_table', ['users' => $users])
        </div>

        <!-- Pagination Links -->
        <div id="pagination-c" class="d-flex justify-content-end mt-4">
            {{ $users->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM fully loaded'); // Ensure the DOM is ready

            const pagination = document.getElementById('pagination-c'); // Select pagination element
            const searchBox = document.getElementById('search-box'); // Search box
            let timeout = null; // Used for debouncing
            let isSearching = false; // Used to check if a request is in progress

            if (!searchBox) {
                console.error('Search box not found');
                return;
            }

            // Listen for input in the search box
            searchBox.addEventListener('input', function () {
                const query = searchBox.value;
                console.log('Typing detected:', query);

                // If input is cleared, reload the full table
                if (query.trim() === '') {
                    console.log('Input is empty, reloading full table...');
                    performSearch('');
                    pagination.style.visibility = 'visible';
                    return;
                } else {
                    pagination.style.visibility = 'hidden';
                }

                // Only proceed if the query length is 3 or more
                if (query.length >= 3) {
                    // Debounce the input to prevent multiple requests
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        performSearch(query);
                    }, 300);
                }
            });

            function performSearch(query) {
                if (isSearching) {
                    return; // Prevent multiple simultaneous requests
                }

                console.log('Performing search for:', query);
                isSearching = true; // Indicate that a request is in progress

                // Show spinner icon and disable input
                searchBox.disabled = true;
                searchBox.classList.add('is-loading');

                const url = "{{ route('users.index') }}?search=" + encodeURIComponent(query);

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Mark as an AJAX request
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not OK');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const container = document.getElementById('users-table-container');

                        if (data.html) {
                            container.innerHTML = data.html; // Replace table with new HTML
                        } else {
                            console.error('No HTML found in response');
                        }
                    })
                    .catch(error => console.error(error))
                    .finally(() => {
                        isSearching = false; // Mark request as complete
                        searchBox.disabled = false; // Re-enable input
                        searchBox.classList.remove('is-loading'); // Remove spinner
                    });
            }
        });
    </script>
@endsection
