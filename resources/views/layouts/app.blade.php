<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'EzMart')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100">
    <main>
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
