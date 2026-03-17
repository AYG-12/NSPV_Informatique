<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — ShopCore</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">

    @vite('resources/css/css/admin.css')
</head>
<body>

<!-- ════════════════════════════════════
    SIDE_BAR
════════════════════════════════════ -->
  
    @include('admin.sidebar')


<!-- ════════════════════════════════════
    CONTENT
════════════════════════════════════ -->

    @yield('content')



    <!-- JS -->
    @vite('resources/js/js/admin.js')
</body>
</html>