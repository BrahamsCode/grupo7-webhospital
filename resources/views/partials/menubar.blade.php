<div class="flex items-center justify-between bg-sky-200 text-sky-900 h-14 px-6 shadow-md font-medium">
  
  <div class="text-lg font-bold tracking-wide">
    Hospital 7
  </div>
  
  <div class="flex gap-6">
    <a href="{{ route('usuarios.index') }}" class="hover:bg-cyan-300 px-3 py-1 rounded-md cursor-pointer transition duration-200">
      Usuarios
    </a>
    <a href="{{ route('doctores.index') }}" class="hover:bg-cyan-300 px-3 py-1 rounded-md transition duration-200 cursor-pointer">
      Doctores
    </a>
    <a href="{{ route('seguros.index') }}" class="hover:bg-cyan-300 px-3 py-1 rounded-md transition duration-200 cursor-pointer">
      Seguros Medicos
    </a>
    <a href="{{ route('especialidades.index') }}" class="hover:bg-cyan-300 px-3 py-1 rounded-md transition duration-200 cursor-pointer">
      Especialidades
    </a>
    <a href="{{ route('medicamentos.index') }}" class="hover:bg-cyan-300 px-3 py-1 rounded-md transition duration-200 cursor-pointer">
      Medicamentos
    </a>
  </div>

  <button onclick="goToCarritoCompras()" class="flex items-center gap-2 bg-teal-500 text-white px-4 py-1.5 rounded-md hover:bg-teal-600 transition duration-200 shadow">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m10-9l2 9m-6-9v9" />
    </svg>
    Carrito
  </button>
</div>