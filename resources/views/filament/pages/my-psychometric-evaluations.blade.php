<x-filament-panels::page>

    <div class="mb-4 text-sm text-gray-600">
        <p>A continuación se muestran las evaluaciones psicométricas que el departamento de Recursos Humanos te ha asignado. Por favor, asegúrate de contar con el tiempo suficiente y un ambiente libre de distracciones antes de comenzar.</p>
    </div>

    {{-- Aquí Filament inyecta la tabla automáticamente --}}
    {{ $this->table }}

</x-filament-panels::page>
