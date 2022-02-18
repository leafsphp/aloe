<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="{{ PublicPath("assets/css/styles.css", true) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body class="d-flex justify-content-center align-items-center mt-5">
    @include('components.topnav')

    <div class="container" style="margin-top: 35px;">
        <h2>Account</h2>
        <p>This is the Account page.</p>
        <ul>
            @foreach (array_keys($user) as $key)
                <li>
                    <b>{{ $key }}</b>: {{ $user[$key] }}
                </li>
            @endforeach
        </ul>
        <br>
        <a href="/user/update">Edit your account</a>
        <br>
        <a href="{{ AuthConfig('GUARD_LOGOUT') }}">Logout</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
