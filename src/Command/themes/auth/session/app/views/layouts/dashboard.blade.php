<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ _env('APP_NAME', 'Leaf MVC') }}</title>
    <link rel="shortcut icon" href="https://leafphp.dev/logo-circle.png" type="image/x-icon">
    <link rel="stylesheet" href="{{ assets('css/styles.css') }}">

    {{-- @vite('css/app.css') --}}

    @alpine
</head>

<body>
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
        <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
            class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 h-screen w-screen"></div>

        <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
            class="flex flex-col fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-300 dark:bg-[#001e26] lg:translate-x-0 lg:static lg:inset-0 -translate-x-full ease-in">
            <div class="flex items-center justify-center mt-8">
                <span class="mx-2 text-2xl font-semibold dark:text-white">{{ _env('APP_NAME', 'Leaf MVC') }}</span>
            </div>

            <nav class="mt-10">
                <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-gray-700 bg-opacity-25" href="#">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    <span class="mx-3">Dashboard</span>
                </a>

                <a class="flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                    href="#">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="mx-3">Pages</span>
                </a>
            </nav>

            <div x-data="{ dropdownOpen: false }" class="px-6 relative mt-auto pb-6">
                <div @click="dropdownOpen = !dropdownOpen" @click.outside="dropdownOpen = false"
                    class="rounded-xl px-5 py-4 flex items-center gap-2 cursor-pointer bg-white dark:text-white dark:bg-[#001318]">
                    <div class="relative w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none bg-red-300 flex justify-center items-center">
                        {{ auth()->user()->name[0] }}
                    </div>

                    <p>{{ auth()->user()->name }}</p>
                </div>

                <div x-show="dropdownOpen"
                    class="absolute left-6 bottom-24 z-10 w-48 mt-2 overflow-hidden bg-white dark:text-white dark:bg-[#001318] rounded-md shadow-xl"
                    style="display: none;">
                    <a href="/dashboard/user"
                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-600 hover:text-white">Profile</a>
                    <a href="#"
                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-600 hover:text-white">Products</a>
                    <form method="POST" action="/auth/logout" role="none">
                        @csrf
                        <button type="submit" class="lock px-4 py-2 text-sm text-left text-gray-700 dark:text-gray-300 hover:bg-indigo-600 hover:text-white w-full"
                            role="menuitem" tabindex="-1" id="menu-item-3">Sign out</button>
                    </form>
                </div>
            </div>
        </div>

        @yield('content')
    </div>
</body>

</html>
