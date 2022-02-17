<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaf Debugger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body class="container">
    <header>
        <div class="d-flex align-items-center py-5">
            <img src="https://leafphp.dev/logo-circle.png" alt="" style="margin-right: 20px; width: 100px; height: 100px;">
            <div>
                <h2>Leaf Debugger</h2>
                <p>Leaf debug is a simple tool included in aloe that gives you an overview of all that's going on in your Leaf App.</p>
            </div>
        </div>
    </header>
    <div class="row p-1">
        <div class="col-12 col-md-6" style="overflow-y: scroll; max-height: calc(100vh - 300px); border: 1px solid #cecece; border-radius: 4px;padding: 20px;">
            <h3>App Routes ({{ count($routes) }})</h3>
            @foreach ($routes as $route)
                <section class="mb-5">
                    <h5><i>{{ $route['pattern'] }}</i></h5>
                    <p>
                        @foreach ($route['methods'] as $method)
                            <span class="badge bg-secondary">{{ $method }}</span>
                        @endforeach
                    </p>
                    <p class="mb-5">
                        <b>Handler: </b>
                        @if (is_string($route['fn']))
                            {{ $route['fn'] }}
                        @else
                            @php
                                var_dump($route['fn']);    
                            @endphp
                        @endif
                    </p>
                    <hr>
                </section>
            @endforeach
        </div>
        <div class="col-12 col-md-6" style="overflow-y: scroll; max-height: calc(100vh - 300px); border: 1px solid #cecece; border-radius: 4px;padding: 20px;">
            <h4>App Env</h4>
            <pre style="background: #e0e0e0; padding: 0px 10px; border-radius: 4px;">
                <div>{{ file_get_contents('.env') }}</div>
            </pre>
            <hr>
            <h4>Session</h4>
            @if (empty($_SESSION))
                There's no active session
            @else
                <div class="d-flex">
                    <b>Session Started At:</b> {{ \Leaf\Date::rawDate($_SESSION["SESSION_STARTED_AT"]) }}
                    <b>Session Last Activity:</b> {{ \Leaf\Date::rawDate($_SESSION["SESSION_LAST_ACTIVITY"]) }}
                </div>
                <div style="display:flex; flex-direction:column; align-items:flex-start; margin: 0;">
                    <div style="background: #e0e0e0; margin-top: 20px; border-radius: 4px; width: 100%; padding: 10px; margin-bottom: 10px;">
                        @foreach ($_SESSION as $item => $value)
                            <div>
                                <b>{{ $item }}</b>: {{ $value }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>
