<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Muestra una lista de todos los usuarios activos.
     */
    public function index()
    {
        $usuarios = Usuario::where('estado_auditoria', '1')
            ->with(['rol', 'especialidad'])
            ->get();

        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $roles = Rol::where('estado_auditoria', '1')->get();
        $especialidades = Especialidad::where('estado_auditoria', '1')->get();

        return view('usuarios.create', compact('roles', 'especialidades'));
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'apellido_paterno' => 'required|string|max:150',
            'apellido_materno' => 'required|string|max:150',
            'tipo_documento' => 'required|string|size:1',
            'numero_documento' => 'required|string|max:15|unique:usuarios',
            'correo' => 'required|email|max:150|unique:usuarios',
            'password' => 'required|string|min:6|confirmed',
            'genero' => 'required|string|size:1',
            'telefono' => 'required|string|max:10',
            'fecha_nacimiento' => 'required|date',
            'id_rol' => 'required|exists:roles,id_rol',
            'id_especialidad' => 'nullable|exists:especialidades,id_especialidad',
        ]);

        // Encriptar contraseña
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Crear el usuario
        Usuario::create($validatedData);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra los detalles de un usuario específico.
     */
    public function show($id)
    {
        $usuario = Usuario::where('id_usuario', $id)
            ->where('estado_auditoria', '1')
            ->with(['rol', 'especialidad'])
            ->firstOrFail();

        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit($id)
    {
        $usuario = Usuario::where('id_usuario', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $roles = Rol::where('estado_auditoria', '1')->get();
        $especialidades = Especialidad::where('estado_auditoria', '1')->get();

        return view('usuarios.edit', compact('usuario', 'roles', 'especialidades'));
    }

    /**
     * Actualiza un usuario específico en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::where('id_usuario', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'apellido_paterno' => 'required|string|max:150',
            'apellido_materno' => 'required|string|max:150',
            'tipo_documento' => 'required|string|size:1',
            'numero_documento' => 'required|string|max:15|unique:usuarios,numero_documento,' . $id . ',id_usuario',
            'correo' => 'required|email|max:150|unique:usuarios,correo,' . $id . ',id_usuario',
            'password' => 'nullable|string|min:6|confirmed',
            'genero' => 'required|string|size:1',
            'telefono' => 'required|string|max:10',
            'fecha_nacimiento' => 'required|date',
            'id_rol' => 'required|exists:roles,id_rol',
            'id_especialidad' => 'nullable|exists:especialidades,id_especialidad',
        ]);

        // Solo actualizar contraseña si se proporcionó una nueva
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $usuario->update($validatedData);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Elimina un usuario específico (eliminación lógica).
     */
    public function destroy($id)
    {
        $usuario = Usuario::where('id_usuario', $id)
            ->where('estado_auditoria', '1')
            ->firstOrFail();

        // Eliminación lógica
        $usuario->estado_auditoria = '0';
        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    public function doctores()
    {
        $doctores = Usuario::with('especialidad')
            ->where('estado_auditoria', '1')
            ->where('id_rol', 3)
            ->get();
        return view('doctores.index', compact('doctores'));
    }
}
