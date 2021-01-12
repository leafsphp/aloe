@extends('layouts.auth')

@section('content')
  <section>
    <h1>Sign Up</h1>
    <p>
      Create your {{ getenv('APP_NAME') ?? "Leaf MVC" }} account.
    </p>
  </section>
  <form action="/auth/register" method="post">
    <div class="form-group">
      <input class="form-control" type="text" name="username" placeholder="username" value="{{ $username ?? '' }}">
      <p>{{ $errors['username'] ?? $errors['auth'] ?? null }}</p>
    </div>
    <div class="form-group">
      <input class="form-control" type="email" name="email" placeholder="email" value="{{ $email ?? '' }}">
      <p>{{ $errors['email'] ?? $errors['auth'] ?? null }}</p>
    </div>
    <div class="form-group">
      <input class="form-control" type="password" name="password" placeholder="password" value="{{ $password ?? '' }}">
      <p>{{ $errors['password'] ?? null }}</p>
    </div>
    <button class="btn btn-primary">Register</button>
  </form>
  <div class="mt-4">
    <a href="{{ authConfig('GUARD_LOGIN') }}">Login instead</a>
  </div>
@endsection
