<!doctype html>
<html>
    <head>
        @include('includes.head')
    </head>
    <body>
        <div class="container-fluid">
            <header class="row">
                @include('includes.header')
            </header>
            <div id="main" class="py-4">
                @yield('content')
            </div>
        </div>
        <footer class="bg-dark text-white text-center py-3 fixed-bottom" data-bs-theme="dark">
            @include('includes.footer')
        </footer>
        <script src="{{ asset('build/assets/app-W7Y791fY.js') }}"></script>
    </body>
</html>
