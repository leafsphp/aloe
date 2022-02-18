<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - {{ getenv('APP_NAME') ?? "Leaf MVC" }}</title>
  <link rel="stylesheet" href="{{ PublicPath("assets/css/styles.css", true) }}">
  <link rel="shortcut icon" href="https://leafphp.dev/logo-circle.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>
  @include('components.topnav')

  <div class="row">
      <div class="col-12 col-md-6 d-none d-md-block">
        <img src="https://source.unsplash.com/random" alt="" class="w-100 h-screen">
      </div>
      <div class="col-12 col-md-6">
          <div id="app" class="w-100 h-screen py-5 d-flex flex-column justify-content-center align-items-center">
            @yield('content')
          </div>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>
