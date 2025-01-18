@extends('layouts.auth')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-[1fr_2fr] xl:gap-16 h-screen w-screen items-center justify-center">
        <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px] px-2">
            <div class="flex flex-col space-y-2 text-center">
                <img src="https://staging.leafphp.dev/logo.svg" class="size-8 mx-auto" alt="{{ _env('APP_NAME') }}">
                <h1 class="text-2xl font-semibold tracking-tight">Welcome back</h1>
                <p class="text-sm text-gray-500">Enter your email to sign in to your account</p>
            </div>

            <form action="/auth/login" method="POST" class="grid gap-5">
                @csrf

                <div class="grid">
                    <label>Email</label>
                    <input class="bg-[#F5F8F9] py-2 px-3 border border-gray-150 rounded-lg" placeholder="example@example.com"
                        type="email" name="email" value="{{ $email ?? '' }}">
                    <p class="text-red-700 text-sm">{{ $errors['email'] ?? ($errors['auth'] ?? null) }}</p>
                </div>

                <div class="grid">
                    <label>Password</label>
                    <input class="bg-[#F5F8F9] py-2 px-3 border border-gray-150 rounded-lg" placeholder="••••••••"
                        type="password" name="password">
                    <p class="text-red-700 text-sm">{{ $errors['password'] ?? null }}</p>
                </div>

                <button type="submit"
                    class="transition-all inline-flex justify-center rounded-lg text-sm font-semibold py-3 px-4 bg-green-600 hover:bg-green-500 text-white w-full"
                    data-zero-component="Button">
                    Get started
                </button>
            </form>

            <div class="mx-auto mt-3 flex justify-center gap-1 text-sm text-gray-500"><p>Don' have an account?</p><a href="/auth/register" class="font-medium text-black dark:text-white">Sign up</a></div>
        </div>

        <div class="py-20 pr-20 h-full hidden lg:block">
            <img src="https://picsum.photos/1920/1080" alt="" class="rounded-2xl h-full">
        </div>
    </div>
@endsection
