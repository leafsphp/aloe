<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ getenv('APP_NAME') ?? 'Leaf MVC' }}</title>
    <link rel="shortcut icon" href="https://leafphp.dev/logo-circle.png" type="image/x-icon">
    <link rel="stylesheet" href="{{ assets('css/styles.css') }}">

    {{-- {{ vite('css/app.css') }} --}}

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    @include('components.topnav')

    <main class="mx-auto max-w-[85rem] w-full mt-8">
        @yield('content')
    </main>
</body>

</html>
