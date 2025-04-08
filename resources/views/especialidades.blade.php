@extends('layouts.app')

@section('content')
    <div class="text-center my-10">
        <h1 class="text-4xl font-extrabold text-cyan-800 tracking-wide">Especialidades Médicas</h1>
        <p class="text-gray-600 mt-2 text-lg">Conoce nuestras áreas de atención médica disponibles</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-6 mb-10">
        @foreach($especialidades as $especialidad)
            <div class="bg-white shadow-lg rounded-xl overflow-hidden transition-transform transform hover:scale-105 hover:shadow-2xl duration-300">
                <img src="{{ $especialidad->imagen_url }}" alt="{{ $especialidad->nombre }}"
                     class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-cyan-700">{{ $especialidad->nombre }}</h2>
                    <p class="text-gray-600 text-sm mt-1 leading-relaxed">{{ $especialidad->descripcion }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection
