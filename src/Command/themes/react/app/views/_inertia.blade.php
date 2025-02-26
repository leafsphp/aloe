<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title inertia>{{ _env('APP_NAME', 'Leaf MVC') }}</title>
    @viteReactRefresh
    @vite(['/js/app.jsx', "/js/pages/{$page['component']}.jsx"])
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>
