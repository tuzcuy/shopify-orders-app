<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopify Orders</title>
    @vite('resources/css/app.css') <!-- CSS dosyası -->
</head>
<body>
    <div id="app">
        @yield('content') <!-- Vue bileşeni burada render edilecek -->
    </div>
    @vite('resources/js/app.js') <!-- JS dosyası -->
</body>
</html>
