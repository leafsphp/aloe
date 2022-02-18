@extends('layouts.auth')

@section('content')
    <div class="register-container w-75">
        <section>
            <h1>Sign Up</h1>
            <p>
                Create your {{ _env('APP_NAME', 'Leaf MVC') }} account.
            </p>
        </section>
        <form action="/auth/register" method="post">
            <div class="form-group">
                <input class="form-control" type="text" name="name" placeholder="name" value="{{ $name ?? '' }}">
                <p class="text-danger">{{ $errors['name'] ?? null }}</p>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="username" placeholder="username"
                    value="{{ $username ?? '' }}">
                <p class="text-danger">{{ $errors['username'] ?? ($errors['auth'] ?? null) }}</p>
            </div>
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="email" value="{{ $email ?? '' }}">
                <p class="text-danger">{{ $errors['email'] ?? ($errors['auth'] ?? null) }}</p>
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="password"
                    value="{{ $password ?? '' }}">
                <p class="text-danger">{{ $errors['password'] ?? null }}</p>
            </div>
            <button class="btn btn-primary">Register</button>
        </form>
        <div class="mt-4">
            <a href="{{ AuthConfig('GUARD_LOGIN') }}">Login instead</a>
        </div>
    </div>
@endsection
