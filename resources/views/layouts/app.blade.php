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
    
</body>
<!--<script>

    const KEY_CACHE_SESSION = 'KEY_CACHE_SESSION';
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function generateRandomString(){
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        let random = '';
        for (let i = 0; i < 20; i++){
                const ch = chars[Math.floor(Math.random() * (chars.length - 1))];
                random+=ch;
        }
        return random;
    }

    function loadCacheSession(){
        const prevSession = localStorage.getItem(KEY_CACHE_SESSION);
        console.log('prevSession',prevSession);
        if(!prevSession){
            const random = generateRandomString();
            console.log('random',random);
            localStorage.setItem(KEY_CACHE_SESSION, random);
        }
    }

    async function addCarritoCompras(idProducto) {
        console.log('idProducto',idProducto);

        const sessionId=localStorage.getItem(KEY_CACHE_SESSION);

        const result = await fetch('/carrito-compras/nuevo-producto', {
            method: 'POST',
            body: JSON.stringify({ idProducto, sessionId }),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            }
        });
        const data = await result.json();
        console.log('data',data);
    }

    loadCacheSession();

    function goToCarritoCompras(){
        console.log('goToCarritoCompras');
        window.location.href = `/carrito-compras/${localStorage.getItem(KEY_CACHE_SESSION)}`
    }

</script>-->
</html>