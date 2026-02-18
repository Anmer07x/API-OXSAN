@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Mis Resultados
            </h2>
        </div>
    </div>

    @if($resultados->isEmpty())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    No tienes resultados disponibles o validados en este momento.
                </p>
            </div>
        </div>
    </div>
    @else
    <div class="grid gap-6 lg:grid-cols-2">
        @foreach($resultados as $resultado)
        <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200 border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $resultado->examen }}
                </h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Validado
                </span>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Fecha del Examen</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $resultado->fecha_examen->format('d/m/Y h:i A') }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Orden</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $resultado->codigo_orden }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Resultado</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $resultado->resultado }} {{ $resultado->unidad }}
                        </dd>
                        @if($resultado->valores_referencia)
                        <p class="mt-2 text-xs text-gray-500">Ref: {{ $resultado->valores_referencia }}</p>
                        @endif
                    </div>
                </dl>

                <!-- Future: Add PDF download button here if needed -->
                <!-- <div class="mt-4 border-t pt-4">
                            <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">Descargar PDF</button>
                        </div> -->
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection