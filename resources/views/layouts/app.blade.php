<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hospital 7</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

    <header>
        @include('partials.menubar')
    </header>

    <main>
        <div class="max-w-[1080px] pt-5 m-auto">
            @yield('content')
        </div>
    </main>

    <script>
        function goToCarritoCompras() {
            window.location.href = "{{ route('tienda.carrito') }}";
        }
    </script>

</body>
</html>
