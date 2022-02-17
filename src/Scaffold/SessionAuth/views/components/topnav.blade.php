<nav class="navbar navbar-expand-lg navbar-dark fixed-top {{ !auth()->status() ? '' : 'shadow' }}">
  <div class="container-fluid container-md">
    <a class="navbar-brand" href="/">
        <img src="https://leafphp.dev/logo-circle.png" style="width: 40px; height: 40px;" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto"></ul>
      <ul class="navbar-nav">
        @if (!auth()->status())
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
