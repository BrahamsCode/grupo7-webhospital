<div class="h-16"></div>

<div id="navbar" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between bg-sky-200/80 backdrop-blur-sm text-sky-900 h-16 px-6 shadow-md font-medium transition-all duration-300">
    <div class="text-lg font-bold tracking-wide">
        Hospital 7
    </div>

    <div class="flex gap-6">
        <a href="{{ route('usuarios.index') }}"
            class="hover:bg-cyan-300 px-3 py-1 rounded-md cursor-pointer transition duration-200">
            Usuarios
        </a>
        <a href="{{ route('doctores.index') }}"
            class="hover:bg-cyan-300 px-3 py-1 rounded-md transition duration-200 cursor-pointer">
            Doctores
        </a>
        <a href="{{ route('seguros.index') }}"
            class="hover:bg-cyan-300 px-3 py-1 rounded-md transition duration-200 cursor-pointer">
            Seguros Medicos
        </a>
        <a href="{{ route('especialidades.index') }}"
            class="hover:bg-cyan-300 px-3 py-1 rounded-md transition duration-200 cursor-pointer">
            Especialidades
        </a>
        <a href="{{ route('medicamentos.index') }}"
            class="hover:bg-cyan-300 px-3 py-1 rounded-md transition duration-200 cursor-pointer">
            Medicamentos
        </a>
        <a href="{{ route('tienda.index') }}"
            class="hover:bg-cyan-300 px-3 py-1 rounded-md transition duration-200 cursor-pointer">
            Ir a la Tienda
        </a>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('tienda.carrito') }}"
            class="flex items-center gap-2 bg-teal-500 text-white px-4 py-1.5 rounded-md hover:bg-teal-600 transition duration-200 shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m10-9l2 9m-6-9v9" />
            </svg>
            Carrito
            <span id="cart-count"
                class="bg-white text-teal-600 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">
                {{ count(session('carrito', [])) }}
            </span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-2 bg-red-500 text-white px-4 py-1.5 rounded-md hover:bg-red-600 transition duration-200 shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Salir
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('navbar');
        let lastScrollTop = 0;

        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            // Cambiar apariencia al hacer scroll
            if (scrollTop > 10) {
                navbar.classList.remove('bg-sky-200/80');
                navbar.classList.add('bg-white/90');
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.add('bg-sky-200/80');
                navbar.classList.remove('bg-white/90');
                navbar.classList.remove('shadow-lg');
            }

            lastScrollTop = scrollTop;
        });
    });
</script>
