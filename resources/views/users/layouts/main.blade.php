<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield("title", "Authentication") - Banao Laravel
    </title>

    <!-- Custom Styles if required -->
    @yield('styles')

    <!-- Flowbite Tailwind Css -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body>
    
    <!--- Main page content -->
    @yield('content')
    
    @yield('scripts')

    <!--- Flowbite scripts --->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
</body>

</html>
