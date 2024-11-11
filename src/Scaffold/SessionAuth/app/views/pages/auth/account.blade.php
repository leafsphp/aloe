@extends('layouts.dashboard')

@section('content')
    <div class="container" style="margin-top: 35px;">
        <h2>Account</h2>
        <p>This is the Account page.</p>
        {{-- <ul>
            @foreach (array_keys($user) as $key)
                <li>
                    <b>{{ $key }}</b>: {{ $user[$key] }}
                </li>
            @endforeach
        </ul> --}}
        <br>
        <a href="/dashboard/user/update">Edit your account</a>
        <br>
        <a href="/auth/logout">Logout</a>
    </div>
@endsection
