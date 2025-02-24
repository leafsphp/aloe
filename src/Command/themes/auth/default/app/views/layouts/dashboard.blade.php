@php
    $sidebarLinks = [
        [
            'link' => '/dashboard',
            'name' => 'Dashboard',
            'icon' => '<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>',
        ],
        [
            'link' => '#',
            'name' => 'Pages',
            'icon' => '<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z">
                        </path>
                    </svg>',
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ _env('APP_NAME', 'Leaf MVC') }}</title>
    <link rel="shortcut icon" href="https://leafphp.dev/logo-circle.png" type="image/x-icon">
    <link rel="stylesheet" href="@assets('css/styles.css')">

    {{-- @vite('css/app.css') --}}

    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&display=swap"
        rel="stylesheet">

    @alpine
</head>

<body>
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
        <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
            class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 h-screen w-screen"></div>

        <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
            class="flex flex-col fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-100 dark:bg-[#001e26] lg:translate-x-0 lg:static lg:inset-0 -translate-x-full ease-in">
            <div class="flex items-center justify-center mt-8">
                <span class="mx-2 text-2xl font-semibold dark:text-white">{{ _env('APP_NAME', 'Leaf MVC') }}</span>
            </div>

            <nav class="mt-10">
                @foreach ($sidebarLinks as $link)
                    <a class="flex items-center px-6 py-2 mt-4 dark:text-gray-100 hover:bg-green-600/50 hover:text-gray-100"
                        :class="{ 'bg-green-600/70 text-gray-100': {{ request()->getPath() === $link['link'] }} }"
                        href="{{ $link['link'] }}">
                        {!! $link['icon'] !!}
                        <span class="mx-3">{{ $link['name'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div x-data="{ dropdownOpen: false }" class="px-6 relative mt-auto pb-6">
                <div @click="dropdownOpen = !dropdownOpen"
                    class="rounded-xl px-5 py-4 flex items-center gap-2 cursor-pointer bg-white dark:text-white dark:bg-[#001318]">
                    <div
                        class="relative w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none bg-red-300 flex justify-center items-center">
                        {{ auth()->user()->name[0] }}
                    </div>

                    <p>{{ auth()->user()->name }}</p>
                </div>

                <div x-show="dropdownOpen" @click.outside="dropdownOpen = false"
                    class="absolute left-6 bottom-24 z-10 w-48 mt-2 overflow-hidden bg-white dark:text-white dark:bg-[#001318] rounded-md shadow-xl border dark:border-gray-800"
                    style="display: none;">
                    <a href="/dashboard/user"
                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-[#001e26]">Profile</a>
                    <a href="#"
                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-[#001e26]">Products</a>
                    <form method="POST" action="/auth/logout" role="none">
                        @csrf
                        <button type="submit"
                            class="lock px-4 py-2 text-sm text-left text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-[#001e26] w-full"
                            role="menuitem" tabindex="-1" id="menu-item-3">Sign out</button>
                    </form>
                </div>
            </div>
        </div>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-white">
            <div class="container px-6 py-8 mx-auto">
                <header class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg @click="sidebarOpen = !sidebarOpen" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 lg:hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.499 8.248h15m-15 7.501h15" />
                        </svg>
                        @yield('header')
                    </div>

                    <div x-data="{ notificationOpen: false }" class="relative">
                        <button @click="notificationOpen = !notificationOpen"
                            class="flex mx-4 text-gray-600 focus:outline-none">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                            </svg>
                        </button>

                        <div x-show="notificationOpen" @click.outside="notificationOpen = false"
                            class="absolute right-0 z-10 mt-2 overflow-hidden bg-white rounded-lg shadow-xl w-80"
                            style="width: 20rem; display: none;">
                            <a href="#"
                                class="grid grid-cols-[32px_1fr] gap-1 items-center px-4 py-3 -mx-2 text-gray-600 hover:bg-green-50">
                                <img class="object-cover size-8 mx-1 rounded-full"
                                    src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=334&amp;q=80"
                                    alt="avatar">
                                <p class="mx-2 text-sm">
                                    <span class="font-bold" href="#">Sara Salah</span> replied on the <span
                                        class="font-bold text-green-600" href="#">Upload Image</span> artical .
                                    2m
                                </p>
                            </a>
                            <a href="#"
                                class="grid grid-cols-[32px_1fr] gap-1 items-center px-4 py-3 -mx-2 text-gray-600 hover:bg-green-50">
                                <img class="object-cover size-8 mx-1 rounded-full"
                                    src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=634&amp;q=80"
                                    alt="avatar">
                                <p class="mx-2 text-sm">
                                    <span class="font-bold" href="#">Slick Net</span> start following you . 45m
                                </p>
                            </a>
                        </div>
                    </div>
                </header>

                @yield('content')
            </div>
        </main>
    </div>

    @toastContainer
</body>

</html>
