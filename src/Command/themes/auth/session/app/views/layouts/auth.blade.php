<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ getenv('APP_NAME') ?? 'Leaf MVC' }}</title>
    <link rel="shortcut icon" href="https://leafphp.dev/logo-circle.png" type="image/x-icon">
    <link rel="stylesheet" href="@assets('css/styles.css')">

    {{-- @vite('css/app.css') --}}
</head>

<body>
    <main class="flex justify-center items-center h-screen dark:bg-[#001318] dark:text-white md:px-20 md:py-16">
        @yield('content')
    </main>
</body>

</html>
