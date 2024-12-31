<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel swagger</title>
    <link href="{{ asset('vendor/swagger/app.css') }}" rel="stylesheet">
</head>
<body>

<div id="swagger-ui"></div>

<script src="{{ asset('vendor/swagger/app.js') }}"></script>

<script>
    window.onload = () => {
        window.ui = SwaggerUIBundle({
            dom_id: '#swagger-ui',
            spec: JSON.parse(@json($json)),
        });
    };
</script>

</body>
</html>