@extends('layouts.auth')

@section('content')
  <section>
    <h1>Login</h1>
    <p>
      Sign into {{ getenv('APP_NAME') ?? "Leaf MVC" }}
    </p>
  </section>
  <form action="/auth/login" method="post">
    <div class="form-group">
      <input class="form-control" type="text" name="username" placeholder="username" value="{{ $username ?? '' }}">
      <small class="mb-1">{{ $errors['username'] ?? $errors['auth'] ?? null }}</small>
    </div>
    <div class="form-group">
      <input class="form-control" type="password" name="password" placeholder="password" value="{{ $password ?? '' }}">
      <small class="mb-1">{{ $errors['password'] ?? null }}</small>
    </div>
    <button class="btn btn-primary">Login</button>
  </form>
  <div class="mt-4">
    <a href="{{ authConfig('GUARD_REGISTER') }}">Create an account</a>
  </div>
@endsection
