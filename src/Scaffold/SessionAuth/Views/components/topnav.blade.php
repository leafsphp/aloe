<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto"></ul>
      <ul class="navbar-nav">
        @if (!auth('session'))
          <li class="nav-item">
            <a class="nav-link" href="{{ AuthConfig('GUARD_LOGIN') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ AuthConfig('GUARD_REGISTER') }}">Register</a>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link" href="{{ AuthConfig('GUARD_HOME') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user">User</a>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
