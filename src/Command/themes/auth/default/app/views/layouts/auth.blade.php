<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ getenv('APP_NAME') ?? 'Leaf MVC' }}</title>
    <link rel="shortcut icon" href="https://leafphp.dev/logo-circle.png" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&display=swap"
        rel="stylesheet">

    @vite('css/app.css')
</head>

<body class="bg-background">
    <div class="flex relative z-30 flex-col justify-center w-screen min-h-screen items-stretch sm:items-center sm:py-10">
        <div class="relative w-full sm:max-w-md sm:mx-auto">
            @yield('content')
        </div>
    </div>
</body>

</html>
