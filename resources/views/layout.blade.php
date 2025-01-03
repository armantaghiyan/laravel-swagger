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
    let currentSpec = null;

    function initSwagger(spec) {
        window.ui = SwaggerUIBundle({
            dom_id: '#swagger-ui',
            spec: spec,
            deepLinking: true,
            filter: true,
            onComplete: () => {
                console.log('onComplete')
            },
            docExpansion: 'list',
        });
        currentSpec = spec;
    }

    function updateSwaggerIfChanged() {
        fetch('/swagger/data')
            .then(response => response.json())
            .then(newSpec => {
                if (JSON.stringify(newSpec) !== JSON.stringify(currentSpec)) {
                    window.ui.specActions.updateSpec(JSON.stringify(newSpec));
                    currentSpec = newSpec;
                }
            });
    }

    window.onload = () => {
        fetch('/swagger/data')
            .then(response => response.json())
            .then(spec => {
                initSwagger(spec);
                setInterval(updateSwaggerIfChanged, 5000);
            });
    };
</script>

</body>
</html>