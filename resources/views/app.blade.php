<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <style>
        .layout-page{
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <div class="layout-page" id="app"></div>

</body>
</html>