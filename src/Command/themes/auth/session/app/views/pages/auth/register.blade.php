@extends('layouts.auth')

@section('content')
    <div class="text-base max-w-96 w-full">
        <div class="mb-8">
            <a href="/" class="flex justify-center items-center shadow-md p-2 w-16 h-16 rounded-2xl mb-8 bg-gray-50/15">
                <img src="https://leafphp.dev/logo-circle.png" alt="{{ _env('APP_NAME') }}" class="h-8 w-auto sm:h-10">
            </a>
            <div>
                <p>Already have a {{ _env('APP_NAME', 'Leaf MVC') }} account?</p>
                <a href="/auth/login" class="text-green-600">Log in</a>
            </div>
        </div>

        <form action="/auth/register" method="POST" class="grid gap-6">
            <?php csrf()->form(); ?>

            <div class="grid">
                <label>Name</label>
                <input class="bg-[#F5F8F9] py-2 px-3 border border-gray-150 rounded-lg" placeholder="Your name" type="text" name="name" value="{{ $name ?? '' }}">
                <p class="text-red-900 text-sm">{{ $errors['name'] ?? null }}</p>
            </div>

            <div class="grid">
                <label>Email</label>
                <input class="bg-[#F5F8F9] py-2 px-3 border border-gray-150 rounded-lg" placeholder="example@example.com" type="email" name="email" value="{{ $email ?? '' }}">
                <p class="text-red-900 text-sm">{{ $errors['email'] ?? ($errors['auth'] ?? null) }}</p>
            </div>

            <div class="grid">
                <label>Password</label>
                <input class="bg-[#F5F8F9] py-2 px-3 border border-gray-150 rounded-lg" placeholder="••••••••" type="password" name="password" value="{{ $password ?? '' }}">
                <p class="text-red-900 text-sm">{{ $errors['password'] ?? null }}</p>
            </div>

            <div class="grid">
                <label>Confirm Password</label>
                <input class="bg-[#F5F8F9] py-2 px-3 border border-gray-150 rounded-lg" placeholder="••••••••" type="password" name="confirmPassword" value="{{ $confirmPassword ?? '' }}">
                <p class="text-red-900 text-sm">{{ $errors['confirmPassword'] ?? null }}</p>
            </div>

            <button
                type="submit"
                class="transition-all inline-flex justify-center rounded-lg text-sm font-semibold py-3 px-4 bg-green-600 hover:bg-green-500 text-white w-28"
                data-zero-component="Button"
            >
                Get started
            </button>
        </form>
    </div>
@endsection
