<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>

<body class="bg-blue-900">
    <div class="min-h-screen flex justify-center items-center">
        <div class="bg-blue-950 p-8 rounded-lg shadow-lg w-full max-w-prose">
            <h2 class="text-2xl font-semibold text-center text-lime-50 mb-6">Registrar Doctor</h2>
            <form action="#" method="POST" class="space-y-6">
                <div>
                    <label for="usuario" class="block text-sm font-medium text-fuchsia-50">Usuario</label>
                    <select id="usuario" name="usuario" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccione un usuario</option>
                        <option value="juanperez">juanperez</option>
                        <option value="mariafernandez">mariafernandez</option>
                        <option value="pedrolopez">pedrolopez</option>
                        <option value="lauragomez">lauragomez</option>
                    </select>
                </div>
                <div>
                    <label for="nombre" class="block text-sm font-medium text-fuchsia-50">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. Dr. Juan ">
                </div>
                <div>
                    <label for="apellido_paterno" class="block text-sm font-medium text-fuchsia-50">Apellido Paterno</label>
                    <input type="text" id="apellido_paterno" name="apellido_paterno" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. Dr. Pérez">
                </div>
                <div>
                    <label for="apellido_materno" class="block text-sm font-medium text-fuchsia-50">Apellido Materno</label>
                    <input type="text" id="apellido_materno" name="apellido_materno" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. Dr. Cordova">
                </div>

                <div>
                    <label for="especialidad" class="block text-sm font-medium text-fuchsia-50">Especialidad</label>
                    <select id="especialidad" name="especialidad" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccione una especialidad</option>
                        <option value="cardiologia">Cardiología</option>
                        <option value="neurologia">Neurología</option>
                        <option value="pedriatria">Pediatría</option>
                        <option value="cirugia">Cirugía</option>
                    </select>
                </div>

                <div>
                    <label for="telefono" class="block text-sm font-medium text-fuchsia-50">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. +51 987 654 321">
                </div>

                <div>
                    <label for="correo" class="block text-sm font-medium text-fuchsia-50">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. juan.perez@dominio.com">
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit" class="w-full border-green-400 text-white py-2 px-4 rounded-md hover:bg-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-900">Registrar</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>