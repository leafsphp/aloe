@extends('layouts.dashboard')

@section('content')
    <div class="container" style="margin-top: 35px;">
        <h2 class="text-xl font-semibold">Account</h2>
        <p>This is the Account page.</p>

        <ul style="margin-bottom:20px; margin-top:20px;">
            @foreach (array_keys($user->get()) as $key)
                <li>
                    <b>{{ $key }}</b>: {{ $user->{$key} }}
                </li>
            @endforeach
        </ul>

        <a href="/dashboard/user/update" class="transition-all inline-flex justify-center rounded-lg text-sm font-semibold py-3 px-4 bg-green-600 hover:bg-green-500 text-white">Edit your account</a>
    </div>
@endsection
