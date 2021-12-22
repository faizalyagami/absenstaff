<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel & Vue Learning</title>

        <link rel="stylesheet" href="/css/app.css">

        <script>
            (function () {
                window.Laravel = {
                    csrfToken: '{{ csrf_token() }}'
                };
            })();
        </script>
    </head>
    <body>
        <div id="app">
            @auth
                <mainapp :user="{{ Auth::user() }}"></mainapp>
            @else
                <mainapp :user="false"></mainapp>
            @endauth
        </div>
    </body>

    <script src="{{ mix('/js/app.js') }}"></script>
</html>
