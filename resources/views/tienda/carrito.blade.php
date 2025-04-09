@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Mi Carrito de Compras</h1>
        <p class="text-gray-600">Revise sus productos y proceda al pago</p>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    @if(count($itemsCarrito) > 0)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($itemsCarrito as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($item['medicamento']->imagen_url)
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-md object-cover" src="{{ $item['medicamento']->imagen_url }}" alt="{{ $item['medicamento']->nombre }}">
                            </div>
                            @endif
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $item['medicamento']->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $item['medicamento']->presentacion }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">S/. {{ number_format($item['medicamento']->precio, 2) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('tienda.actualizar') }}" method="POST" class="flex items-center">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $item['medicamento']->id_medicamento }}">
                            <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" max="{{ $item['medicamento']->stock }}" class="border border-gray-300 rounded-md px-2 py-1 w-16 text-center">
                            <button type="submit" class="ml-2 bg-gray-200 hover:bg-gray-300 text-gray-700 px-2 py-1 rounded-md text-xs">
                                Actualizar
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        S/. {{ number_format($item['medicamento']->precio * $item['cantidad'], 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <form action="{{ route('tienda.eliminar') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $item['medicamento']->id_medicamento }}">
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="px-6 py-4 text-right font-bold">Total:</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                        S/. {{ number_format($total, 2) }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="mt-6 flex justify-between">
        <div>
            <a href="{{ route('tienda.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Seguir comprando
            </a>
            <form action="{{ route('tienda.vaciar') }}" method="POST" class="inline-block ml-2">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-md transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Vaciar carrito
                </button>
            </form>
        </div>
        <form action="{{ route('tienda.finalizar') }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center px-6 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-md transition duration-200">
                Finalizar compra
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
        </form>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m10-9l2 9m-6-9v9" />
        </svg>
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Tu carrito está vacío</h2>
        <p class="text-gray-600 mb-6">¡Agrega algunos productos para comenzar tu compra!</p>
        <a href="{{ route('tienda.index') }}" class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-md transition duration-200">
            Ir a la tienda
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </a>
    </div>
    @endif
</div>
@endsection
