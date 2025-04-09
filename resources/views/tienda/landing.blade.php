@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Farmacia Online Hospital 7</h1>
        <p class="text-gray-600">Encuentre los medicamentos que necesita al mejor precio</p>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($medicamentos as $medicamento)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            @if($medicamento->imagen_url)
            <img src="{{ $medicamento->imagen_url }}" alt="{{ $medicamento->nombre }}" class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            @endif

            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $medicamento->nombre }}</h3>
                <p class="text-gray-600 text-sm mb-2">{{ $medicamento->presentacion }}</p>
                <p class="text-gray-500 text-xs mb-4">{{ Str::limit($medicamento->descripcion, 100) }}</p>

                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-teal-600">S/. {{ number_format($medicamento->precio, 2)
                        }}</span>
                    <button onclick="agregarAlCarrito({{ $medicamento->id_medicamento }})"
                        class="flex items-center gap-2 bg-teal-500 text-white px-4 py-1.5 rounded-md hover:bg-teal-600 transition duration-200 shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m10-9l2 9m-6-9v9" />
                        </svg>
                        Agregar
                    </button>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function agregarAlCarrito(id) {
        fetch('{{ route('tienda.agregar') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: id, cantidad: 1 })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                actualizarContador(data.carrito_count);
                mostrarNoti("Producto agregado al carrito");
            } else {
                mostrarNoti("Error: " + data.error, true);
            }
        })
        .catch(() => {
            mostrarNoti("Error al agregar producto", true);
        });
    }

    function actualizarContador(count) {
        const contador = document.getElementById('cart-count');
        if (contador) {
            contador.textContent = count;
        }
    }

    function mostrarNoti(msg, error = false) {
        const noti = document.createElement('div');
        noti.textContent = msg;
        noti.className = `fixed bottom-20 right-4 max-w-sm px-4 py-2 rounded-lg text-white shadow-md z-50 transition-opacity duration-300 ${error ? 'bg-red-500' : 'bg-green-500'}`;
        document.body.appendChild(noti);
        setTimeout(() => noti.remove(), 3000);
    }
</script>


@endsection
