
<x-filament-widgets::widget>
    <x-filament::section>
            @forelse ($campaigns as $campaign)
                <h2 class="text-lg font-bold">{{ $campaign->name }}</h2>
                <ul>
                    @foreach ($campaign->evaluations as $evaluation)
                        <li class="flex items-center justify-between py-2 border-b">
                            <span>{{ $evaluation->name }}</span>
                           {{-- <a href="{{ route('evaluation.start', ['campaign' => $campaign->id, 'evaluation' => $evaluation->id]) }}"
                               class="btn btn-primary">
                                Iniciar Evaluación
                            </a>
                            --}}
                            <x-filament::button
                                color="warning"
                                icon="heroicon-c-paper-airplane"
                                icon-position="after"
                                labeled-from="sm"
                                href="/dashboard/panel360"
                                tag="a"
                            >
                                {{ __('Revisar evaluaciones') }}
                            </x-filament::button>
                        </li>
                    @endforeach
                </ul>
            @empty
                <p>No hay campañas activas para tu sede en este momento.</p>
            @endforelse
    </x-filament::section>
</x-filament-widgets::widget>
