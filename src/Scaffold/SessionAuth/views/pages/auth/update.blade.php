<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="{{ PublicPath("assets/css/styles.css", true) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
    @include('components.topnav')

    <div class="w-25 container" style="margin-top: 85px;">
        <section>
            <h1>Update User</h1>
            <p>
                Edit your {{ _env("APP_NAME", "Leaf MVC") }} account.
            </p>
        </section>
        <form action="/user/update" method="post" class="mb-4">
            <div class="form-group">
                <input class="form-control" type="text" name="username" placeholder="username" value="{{ $username ?? '' }}">
                <p>{{ $errors['username'] ?? $errors['auth'] ?? null }}</p>
            </div>
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="email" value="{{ $email ?? '' }}">
                <p>{{ $errors['email'] ?? $errors['auth'] ?? null }}</p>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="name" placeholder="name" value="{{ $name ?? '' }}">
                <p>{{ $errors['name'] ?? null }}</p>
            </div>
            <button class="btn btn-primary">Update Account</button>
        </form>

        <a href="/user">Back to account</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
