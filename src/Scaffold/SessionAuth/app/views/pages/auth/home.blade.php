<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Name</title>
    <link rel="stylesheet" href="{{ PublicPath("assets/css/styles.css", true) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
    @include('components.topnav')

    <div class="container" style="margin-top: 85px;">
        <h2>Home</h2>
        <p>This is the Home page.</p>
        <p>You can edit your auth routes in <code>app/routes/_auth.php</code></p>
        <p>Auth controllers are in <code>app/controllers/Auth/</code></p>
        <a href="/user">Go to account page</a> <br>
        <a href="/auth/logout">Logout</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
