@extends('layouts.auth')

@section('content')
    <div
        class="flex relative top-0 z-20 flex-col justify-center items-stretch px-10 py-8 w-full h-screen bg-white dark:bg-[#111] border-gray-200 dark:border-none sm:top-auto sm:h-full sm:border sm:rounded-xl">
        <div class="flex flex-col sm:mx-auto sm:w-full mb-5 sm:max-w-md items-center text-black dark:text-white">
            <a href="/">
                <img src="https://leafphp.dev/logo-circle.png" alt="{{ _env('APP_NAME') }}" class="size-10">
            </a>
            <h1 class="mt-4 mb-1 text-2xl lg:text-3xl font-semibold">Get started</h1>
            <h2 class="text-sm">Create your account</h2>
        </div>

        <form class="space-y-5 text-black dark:text-white" action="/auth/register" method="POST">
            @csrf

            <div class="w-full flex relative flex-col justify-center">
                <input name="name" required="required" placeholder="Name" value="{{ $name ?? '' }}"
                    class="flex w-full h-11 px-3.5 text-sm border rounded-md border-gray-300 ring-offset-background placeholder:text-gray-500 focus:outline-none focus:ring-1 focus:ring-zinc-800 disabled:cursor-not-allowed disabled:opacity-50">
                <small class="text-red-900 text-sm">{{ $errors['name'] ?? null }}</small>
            </div>

            <div class="w-full flex relative flex-col justify-center">
                <input name="email" type="email" required="required" placeholder="Email" value="{{ $email ?? '' }}"
                    class="flex w-full h-11 px-3.5 text-sm border rounded-md border-gray-300 ring-offset-background placeholder:text-gray-500 focus:outline-none focus:ring-1 focus:ring-zinc-800 disabled:cursor-not-allowed disabled:opacity-50"
                    value="{{ $email ?? '' }}">
                <small class="text-red-900 text-sm">{{ $errors['email'] ?? ($errors['auth'] ?? null) }}</small>
            </div>


            <div class="w-full flex relative flex-col justify-center">
                <input name="password" type="password" required="required" value="{{ $password ?? '' }}"
                    placeholder="Password"
                    class="flex w-full h-11 px-3.5 text-sm border rounded-md border-gray-300 ring-offset-background placeholder:text-gray-500 focus:outline-none focus:ring-1 focus:ring-zinc-800 disabled:cursor-not-allowed disabled:opacity-50 ">
                <small class="text-red-900 text-sm">{{ $errors['password'] ?? null }}</small>
            </div>

            <div class="w-full flex relative flex-col justify-center">
                <input name="confirmPassword" type="password" required="required" value="{{ $confirmPassword ?? '' }}"
                    placeholder="Confirm Password"
                    class="flex w-full h-11 px-3.5 text-sm border rounded-md border-gray-300 ring-offset-background placeholder:text-gray-500 focus:outline-none focus:ring-1 focus:ring-zinc-800 disabled:cursor-not-allowed disabled:opacity-50 ">
                <small class="text-red-900 text-sm">{{ $errors['confirmPassword'] ?? null }}</small>
            </div>

            <button type="submit"
                class="transition-all inline-flex justify-center rounded-lg text-sm font-semibold py-3 px-4 bg-green-600 hover:bg-green-500 text-white w-full"
                data-zero-component="Button">
                Get started
            </button>
        </form>

        <div class="mt-3 space-x-0.5 text-sm leading-5 text-left text-[#00173d] dark:text-white">
            <span class="opacity-[50%]">Already have an account?</span>
            <a class="underline cursor-pointer opacity-[67%] hover:opacity-[80%]" href="/auth/login">
                Sign in
            </a>
        </div>

        <div class="flex justify-center items-center w-full text-zinc-400 uppercase text-xs my-6">
            <span class="w-full h-px bg-zinc-300"></span>
            <span class="px-2 w-auto">or</span>
            <span class="w-full h-px bg-zinc-300"></span>
        </div>

        <div class="relative space-y-2 w-full">
            <a href="/auth/google"
                class="flex  items-center px-4 py-3 space-x-2.5 w-full h-auto text-sm rounded-md border border-zinc-200 text-zinc-600 hover:bg-zinc-100">
                <span class="w-5 h-5">
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none">
                        <path fill="#4285F4"
                            d="M24 19.636v9.295h12.916c-.567 2.989-2.27 5.52-4.822 7.222l7.79 6.043c4.537-4.188 7.155-10.341 7.155-17.65 0-1.702-.152-3.339-.436-4.91H24Z">
                        </path>
                        <path fill="#34A853"
                            d="m10.55 28.568-1.757 1.345-6.219 4.843C6.524 42.59 14.617 48 24 48c6.48 0 11.913-2.138 15.884-5.804l-7.79-6.043c-2.138 1.44-4.865 2.313-8.094 2.313-6.24 0-11.541-4.211-13.44-9.884l-.01-.014Z">
                        </path>
                        <path fill="#FBBC05"
                            d="M2.574 13.244A23.704 23.704 0 0 0 0 24c0 3.883.938 7.527 2.574 10.756 0 .022 7.986-6.196 7.986-6.196A14.384 14.384 0 0 1 9.796 24c0-1.593.284-3.12.764-4.56l-7.986-6.196Z">
                        </path>
                        <path fill="#EA4335"
                            d="M24 9.556c3.534 0 6.676 1.222 9.185 3.579l6.873-6.873C35.89 2.378 30.48 0 24 0 14.618 0 6.523 5.39 2.574 13.244l7.986 6.196c1.898-5.673 7.2-9.884 13.44-9.884Z">
                        </path>
                    </svg>
                </span>
                <span>Continue with Google</span>
            </a>

            <a href="/auth/github"
                class="flex  items-center px-4 py-3 space-x-2.5 w-full h-auto text-sm rounded-md border border-zinc-200 text-zinc-600 hover:bg-zinc-100">
                <span class="w-5 h-5">
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none">
                        <path fill="#24292F" fill-rule="evenodd"
                            d="M24.02 0C10.738 0 0 10.817 0 24.198 0 34.895 6.88 43.95 16.424 47.154c1.193.241 1.63-.52 1.63-1.161 0-.561-.039-2.484-.039-4.488-6.682 1.443-8.073-2.884-8.073-2.884-1.074-2.805-2.665-3.525-2.665-3.525-2.187-1.483.16-1.483.16-1.483 2.425.16 3.698 2.484 3.698 2.484 2.147 3.686 5.607 2.644 7 2.003.198-1.562.834-2.644 1.51-3.245-5.329-.56-10.936-2.644-10.936-11.939 0-2.644.954-4.807 2.466-6.49-.239-.6-1.074-3.085.239-6.41 0 0 2.028-.641 6.6 2.484 1.959-.53 3.978-.8 6.006-.802 2.028 0 4.095.281 6.005.802 4.573-3.125 6.601-2.484 6.601-2.484 1.313 3.325.477 5.81.239 6.41 1.55 1.683 2.465 3.846 2.465 6.49 0 9.295-5.607 11.338-10.976 11.94.876.76 1.63 2.202 1.63 4.486 0 3.245-.039 5.85-.039 6.65 0 .642.438 1.403 1.63 1.163C41.12 43.949 48 34.895 48 24.198 48.04 10.817 37.262 0 24.02 0Z"
                            clip-rule="evenodd"></path>
                    </svg>
                </span>
                <span>Continue with Github</span>
            </a>
        </div>
    </div>
@endsection
