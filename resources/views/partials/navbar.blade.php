<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ action('GameController@index') }}">Games</a>
                </li>
                @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ action('GameController@create') }}">Add Game</a>
                    </li>
                    @if (Auth::user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ action('GameController@pending') }}">Pending Games</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ action('AnnouncementController@create') }}">Announcement</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ action('LoginController@logout') }}">Log Out</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ action('LoginController@index') }}">Login</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>