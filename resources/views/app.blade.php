<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead

        <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
        <link href="/css/bootstrap.min.css?v=2023.09.27.1" rel="stylesheet">
        <link rel="stylesheet" href="/css/jquery.fancybox.min.css?v=2023.09.27.1">
        <link rel="stylesheet" href="/css/slick.css?v=2023.09.27.1">
        <link rel="stylesheet" href="/css/slick-theme.css?v=2023.09.27.1">
        <link rel="stylesheet" href="/css/main.css?v=2023.10.06.3">
    </head>
    <body class="font-sans antialiased">
        @inertia


        <script src="/js/jquery-3.4.1.min.js?v=2023.09.27.1" type="text/javascript"></script>
        <script src="/js/bootstrap.min.js?v=2023.09.27.1"></script>
        <script src="/js/jquery.fancybox.min.js?v=2023.09.27.1"></script>
        <script src="/js/jquery-ui.min.js?v=2023.09.27.1"></script>
        <script src="/js/stepper.min.js?v=2023.09.27.1"></script>
        <script src="/js/slick.js?v=2023.09.27.1"></script>
{{--        <script src="/js/functions.js?v=2023.09.27.1"></script>--}}
    </body>
</html>
