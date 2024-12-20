@extends('layouts.dashboard')

@section('content')
    <div class="mx-auto max-w-[85rem] w-full">
        <div>
            <h2 class="text-xl font-semibold">Hello 👋</h2>
            <div class="rounded-lg text-sm bg-gray-800 px-3 md:px-6 py-4 mb-6 mt-3 h-60 text-white">
                <p>Welcome to your dashboard. You are logged in as <span class="font-semibold">{{ auth()->user()->name }}</span>.</p>
            </div>
        </div>

        <a href="/auth/logout">Logout</a>
    </div>
@endsection
