@extends('layouts.app')

@section('content')
    <div class="text-center my-10">
        <h1 class="text-4xl font-extrabold text-indigo-900">Nuestros Doctores</h1>
        <p class="text-gray-600 mt-2 text-lg">Conoce a nuestros profesionales de la salud</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-6 mb-10">
        @foreach($doctores as $doctor)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:shadow-2xl duration-300 flex flex-col justify-between h-full">
                <div class="p-4 flex-grow">
                    <h2 class="text-xl font-semibold text-indigo-700">{{ $doctor->nombre }} {{ $doctor->apellido_paterno }}</h2>
                    <p class="text-gray-600 text-sm mt-1">{{ $doctor->especialidad->nombre }}</p>
                    <p class="text-gray-500 text-sm mt-2">DNI: {{ $doctor->numero_documento }}</p>
                    <p class="text-gray-500 text-sm mt-2">Teléfono: {{ $doctor->telefono }}</p>
                    <p class="text-gray-500 text-sm mt-2">Email: {{ $doctor->correo }}</p>
                </div>

                <div class="px-4 pb-4 flex justify-between items-center">
                    <a href="mailto:{{ $doctor->correo }}"
                       class="text-white bg-indigo-600 hover:bg-indigo-800 transition duration-300 text-sm font-medium py-2 px-4 rounded-lg shadow-md">
                        Contactar
                    </a>
                    <span class="bg-indigo-100 text-indigo-700 text-xs font-semibold py-1 px-3 rounded-lg">
                        {{ $doctor->especialidad->nombre }}
                    </span>
                </div>

                <img src="{{ $doctor->especialidad->imagen_url }}" alt="Especialidad: {{ $doctor->especialidad->nombre }}"
                     class="w-full h-36 object-cover mt-2">
            </div>
        @endforeach
    </div>
@endsection

