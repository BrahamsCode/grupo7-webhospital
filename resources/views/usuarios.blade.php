@extends('layouts.app')

@section('content')

<h1 class="text-center text-gray-700 text-2xl font-medium mb-6">Lista de Usuarios</h1>

<div class="overflow-x-auto relative shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-blue-100 dark:bg-blue-900 dark:text-white">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Nombre
                </th>
                <th scope="col" class="px-6 py-3">
                    Apellidos
                </th>
                <th scope="col" class="px-6 py-3">
                    Documento
                </th>
                <th scope="col" class="px-6 py-3">
                    Correo
                </th>
                <th scope="col" class="px-6 py-3">
                    Teléfono
                </th>
                <th scope="col" class="px-6 py-3">
                    Género
                </th>
                <th scope="col" class="px-6 py-3">
                    Fecha Nacimiento
                </th>
                <th scope="col" class="px-6 py-3">
                    Rol
                </th>
                <th scope="col" class="px-6 py-3">
                    Especialidad
                </th>
                <th scope="col" class="px-6 py-3">
                    Último Acceso
                </th>
                <th scope="col" class="px-6 py-3">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr class="bg-white border-b hover:bg-blue-50 dark:hover:bg-blue-700">
                <td class="px-6 py-4">
                    {{ $usuario->id_usuario }}
                </td>
                <td class="px-6 py-4">
                    {{ $usuario->nombre }}
                </td>
                <td class="px-6 py-4">
                    {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}
                </td>
                <td class="px-6 py-4">
                    @if($usuario->tipo_documento == 'D')
                    DNI
                    @elseif($usuario->tipo_documento == 'C')
                    Carnet de Extranjería
                    @elseif($usuario->tipo_documento == 'P')
                    Pasaporte
                    @else
                    RUC
                    @endif
                    - {{ $usuario->numero_documento }}
                </td>
                <td class="px-6 py-4">
                    {{ $usuario->correo }}
                </td>
                <td class="px-6 py-4">
                    {{ $usuario->telefono }}
                </td>
                <td class="px-6 py-4">
                    @if($usuario->genero == 'M')
                    Masculino
                    @elseif($usuario->genero == 'F')
                    Femenino
                    @else
                    Otro
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{ $usuario->fecha_nacimiento }}
                </td>
                <td class="px-6 py-4">
                    @if($usuario->id_rol == 1)
                    Administrador
                    @elseif($usuario->id_rol == 2)
                    Paciente
                    @elseif($usuario->id_rol == 3)
                    Doctor
                    @elseif($usuario->id_rol == 4)
                    Enfermero
                    @else
                    Desconocido
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{ $usuario->especialidad->nombre ?? 'Sin especialidad' }}
                </td>
                <td class="px-6 py-4">
                    {{ $usuario->ultimo_acceso }}
                </td>                
                <td class="px-6 py-4 flex space-x-2">
                    <a href="#" class="text-blue-600 hover:text-blue-900">Editar</a>
                    <form action="#" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection