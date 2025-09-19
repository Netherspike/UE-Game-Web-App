<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Left: Home -->
        <a class="navbar-brand" href="{{ route('home') }}">Home</a>

        <!-- Expand Button for Mobile (Hamburger icon) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Right: Conditional Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @guest
                    <!-- If the user is not logged in -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @else
                    <!-- If the user is logged in -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            My Account
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <!-- Nested Dropdown Links -->
                            <a class="dropdown-item" href="{{ route('account.show') }}">
                                Settings
                            </a>
                            <a class="dropdown-item" href="{{ route('mycharacters.index') }}">
                                Characters
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>

                    @if(auth()->user()->is_admin) <!-- Check if user is an admin -->
                    <!-- Administration Dropdown for Admin-Only Links -->
                    <li class="nav-item dropdown">
                        <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Administration
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                            <a class="dropdown-item" href="{{ route('items.index') }}">Item Management</a>
                            <a class="dropdown-item" href="{{ route('users.index') }}">User Management</a>
                            <a class="dropdown-item" href="{{ route('characters.index') }}">Character Management</a>
                        </div>
                    </li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>
