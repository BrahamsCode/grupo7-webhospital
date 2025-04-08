@extends('layouts.app')

@section('content')

<h1 class="text-center text-gray-800 text-3xl font-bold mb-6">Lista de Usuarios</h1>

<form method="GET" action="{{ route('usuarios.index') }}" class="mb-6">
    <div class="flex justify-center items-center space-x-4">
        <div>
            <label for="rol" class="text-gray-700">Filtrar por Rol:</label>
            <select name="rol" id="rol" class="px-4 py-2 border rounded-md">
                <option value="">Todos</option>
                <option value="2" {{ request()->get('rol') == '2' ? 'selected' : '' }}>Pacientes</option>
                <option value="3" {{ request()->get('rol') == '3' ? 'selected' : '' }}>Doctores(as)</option>
                <option value="4" {{ request()->get('rol') == '4' ? 'selected' : '' }}>Enfermeros(as)</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md cursor-pointer">Filtrar</button>
    </div>
</form>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">

    @foreach($usuarios as $usuario)
        <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
            <div class="flex justify-center mb-4">
                <img src="https://cdn-icons-png.flaticon.com/512/9187/9187604.png" alt="Avatar" class="w-24 h-24 rounded-full object-cover">
            </div>

            <h2 class="text-2xl font-semibold text-cyan-800 text-center">{{ $usuario->nombre }} {{ $usuario->apellido_paterno }}</h2>
            <p class="text-gray-600 text-sm text-center">Rol: <span class="font-semibold">{{ $usuario->rol->nombre ?? 'Sin rol' }}</span></p>
            <p class="text-gray-600 text-sm text-center">Especialidad: <span class="font-semibold">{{ $usuario->especialidad->nombre ?? 'Sin especialidad' }}</span></p>

            <div class="mt-4 text-center">
                <p class="text-gray-600">Documento: {{ $usuario->tipo_documento == 'D' ? 'DNI' : ($usuario->tipo_documento == 'C' ? 'Carnet de Extranjería' : ($usuario->tipo_documento == 'P' ? 'Pasaporte' : 'RUC')) }} - {{ $usuario->numero_documento }}</p>
                <p class="text-gray-600">{{ $usuario->genero == 'M' ? 'Masculino' : ($usuario->genero == 'F' ? 'Femenino' : 'Otro') }}</p>
                <p class="text-gray-600">Teléfono: {{ $usuario->telefono }}</p>
                <p class="text-gray-600">Último Acceso: {{ $usuario->ultimo_acceso }}</p>
            </div>

            <div class="mt-4 flex justify-around">
                <a href="#" class="text-blue-600 hover:text-blue-900">Editar</a>
                <form action="#" class="inline-block">                    
                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

@endsection
