@extends('layouts.app-layout', [
    'title' => 'Dashboard',
    'breadcrumbs' => [
        [
            'title' => 'Profile settings',
            'href' => '/settings/profile',
        ],
    ],
])

@section('content')
    <div class="space-y-6 px-4 py-4">
        @include('components.shared.heading-small', [
            'title' => 'Update Profile',
            'description' => 'Update your account information.',
        ])

        <div>
            <form action="/settings/profile" method="post" class="space-y-6 max-w-xl">
                @csrf
                @method('patch')

                <div class="grid">
                    <label>Name</label>
                    <input class="bg-[#F5F8F9] py-2 px-3 border border-gray-150 rounded-lg" type="text" name="name"
                        placeholder="name" value="{{ $name ?? '' }}">
                    <small class="text-red-700 text-sm">{{ $errors['name'] ?? ($errors['auth'] ?? null) }}</small>
                </div>
                <div class="grid">
                    <label>Email</label>
                    <input class="bg-[#F5F8F9] py-2 px-3 border border-gray-150 rounded-lg" type="email" name="email"
                        placeholder="email" value="{{ $email ?? '' }}">
                    <small class="text-red-700 text-sm">{{ $errors['email'] ?? ($errors['auth'] ?? null) }}</small>
                </div>

                <button
                    class="transition-all inline-flex justify-center rounded-lg text-sm font-semibold py-3 px-4 bg-green-600 hover:bg-green-500 text-white">Update
                    Account</button>
            </form>
        </div>
    </div>
@endsection
