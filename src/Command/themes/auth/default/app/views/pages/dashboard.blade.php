@extends('layouts.app-layout', [
    'title' => 'Dashboard',
    'breadcrumbs' => [
        [
            'title' => 'Dashboard',
            'href' => '/dashboard',
        ]
    ]
])

@section('content')
    <div class="py-4 px-4">
        <div class="overflow-hidden shadow-sm sm:rounded-lg bg-black">
            <div class="p-6 text-gray-100">You're logged in!</div>
        </div>
    </div>
@endsection
