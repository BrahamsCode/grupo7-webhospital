@extends('layouts.app')

@section('content')
<div class="text-center my-10">
    <h1 class="text-3xl font-bold text-cyan-800">Planes de Seguros Médicos</h1>
    <p class="text-gray-600 mt-2">Consulta los seguros disponibles y su cobertura</p>
</div>

<div class="flex flex-wrap justify-evenly mt-4 gap-6 px-4">
    @foreach($seguros as $seguro)
        <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition duration-300 w-[300px]">
            
            <img class="w-full h-48 object-cover" src="https://img.freepik.com/foto-gratis/medico-vista-frontal-elemento-medico_23-2148854104.jpg?semt=ais_hybrid&w=740" alt="{{ $seguro->nombre }}">

            <div class="p-6">
                <h2 class="text-2xl font-semibold text-cyan-800 mb-2">{{ $seguro->nombre }}</h2>
                <p class="text-gray-600 text-sm mb-2">Tipo de Plan: <span class="font-semibold text-gray-800">{{ $seguro->tipo_plan }}</span></p>
                <p class="text-gray-600 text-sm mb-4">Cobertura: <span class="font-semibold text-green-600">{{ $seguro->porcentaje_cobertura }}%</span></p>
                                
                <div class="flex justify-end">
                    <a href="#" class="bg-cyan-600 text-white hover:bg-cyan-700 px-4 py-2 rounded-md text-sm transition duration-200">Más Información</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection

