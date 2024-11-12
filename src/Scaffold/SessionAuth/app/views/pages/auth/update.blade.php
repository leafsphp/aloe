@extends('layouts.dashboard')

@section('content')
    <div>
        <section>
            <h1 class="text-xl font-semibold">Update User</h1>
            <p>
                Edit your {{ _env('APP_NAME', 'Leaf MVC') }} account.
            </p>
        </section>

        <form action="/dashboard/user/update" method="post" class="mb-4">
            {{ csrf()->form() }}
            <div class="grid">
                <label>Name</label>
                <input class="bg-[#F5F8F9] py-2 px-3 border border-gray-150 rounded-lg" type="text" name="name" placeholder="name" value="{{ $name ?? '' }}">
                <small class="text-red-700 text-sm">{{ $errors['name'] ?? ($errors['auth'] ?? null) }}</small>
            </div>
            <div class="grid">
                <label>Email</label>
                <input class="bg-[#F5F8F9] py-2 px-3 border border-gray-150 rounded-lg" type="email" name="email" placeholder="email" value="{{ $email ?? '' }}">
                <small class="text-red-700 text-sm">{{ $errors['email'] ?? ($errors['auth'] ?? null) }}</small>
            </div>

            <button class="transition-all inline-flex justify-center rounded-lg text-sm font-semibold py-3 px-4 bg-green-600 hover:bg-green-500 text-white">Update Account</button>
        </form>
    </div>
@endsection
