@extends('layouts.dashboard')

@section('header')
    <section>
        <h3 class="text-3xl font-medium text-gray-700">Account</h3>
        <p>
            Edit your {{ _env('APP_NAME', 'Leaf MVC') }} account.
        </p>
    </section>
@endsection

@section('content')
    <ul style="margin-bottom:20px; margin-top:20px;">
        @foreach (array_keys($user->get()) as $key)
            <li>
                <b>{{ $key }}</b>: {{ $user->{$key} }}
            </li>
        @endforeach
    </ul>

    <a href="/dashboard/user/update"
        class="transition-all inline-flex justify-center rounded-lg text-sm font-semibold py-3 px-4 bg-green-600 hover:bg-green-500 text-white">Edit
        your account</a>
@endsection
