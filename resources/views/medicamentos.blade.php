@extends('layouts.app')

@section('content')
<h1 class="text-center text-3xl font-bold text-cyan-800">Elige un Medicamento para comprar</h1><br>

<div class="relative">
    
    <button id="scrollLeft" class="absolute left-0 top-1/2 -translate-y-1/2 bg-cyan-600 text-white p-2 rounded-full shadow-lg z-10 hover:bg-cyan-700">
        ‹
    </button>
    
    <div id="medicamentoSlider" class="flex overflow-x-auto space-x-4 px-10 scroll-smooth">
        @foreach($medicamentos as $medicamento)
            <div class="min-w-[280px] bg-white shadow-md hover:shadow-lg transition duration-300 rounded-lg border border-gray-200 p-4">
                <img class="h-40 w-full object-cover rounded" src="{{ $medicamento->imagen_url }}" alt="{{ $medicamento->nombre }}">
                <h2 class="text-center mt-2 text-lg font-bold text-gray-700">{{ $medicamento->nombre }}</h2>
                <p class="text-sm text-gray-600 text-center">Código: {{ $medicamento->codigo_medicamento }}</p>
                <p class="text-sm text-gray-600 text-center">{{ $medicamento->descripcion }}</p>
                <p class="text-sm text-gray-600 text-center">Vence: {{ $medicamento->fecha_vencimiento }}</p>
                <p class="text-sm text-gray-600 text-center">Laboratorio: {{ $medicamento->laboratorio }}</p>
                <p class="text-sm text-green-700 font-semibold text-center">Precio: S/.{{ $medicamento->precio }}</p>
                <p class="text-sm text-red-700 font-semibold text-center">Stock: {{ $medicamento->stock }}</p>
            </div>
        @endforeach
    </div>
    
    <button id="scrollRight" class="absolute right-0 top-1/2 -translate-y-1/2 bg-cyan-600 text-white p-2 rounded-full shadow-lg z-10 hover:bg-cyan-700">
        ›
    </button>
</div>

<script>
    const slider = document.getElementById('medicamentoSlider');
    const scrollLeftBtn = document.getElementById('scrollLeft');
    const scrollRightBtn = document.getElementById('scrollRight');

    scrollLeftBtn.addEventListener('click', () => {
        slider.scrollBy({ left: -300, behavior: 'smooth' });
    });

    scrollRightBtn.addEventListener('click', () => {
        slider.scrollBy({ left: 300, behavior: 'smooth' });
    });
</script>
@endsection
