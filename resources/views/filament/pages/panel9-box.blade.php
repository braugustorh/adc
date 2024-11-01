<x-filament-panels::page>

    <x-filament::tabs label="Tabs NineBox">

        <x-filament::tabs.item
            :active="$activeTab === 'tab1'"
            wire:click="changeTab('tab1')"
            icon='heroicon-s-chart-pie'>
            Gráfica
        </x-filament::tabs.item>
        <x-filament::tabs.item
            :active="$activeTab === 'tab2'"
            icon='heroicon-c-list-bullet'
            wire:click="changeTab('tab2')">
            Listado
        </x-filament::tabs.item>
        <x-filament::tabs.item
            :active="$activeTab === 'tab3'"
            wire:click="changeTab('tab3')"
            icon='heroicon-m-squares-plus'>
            9-Box
        </x-filament::tabs.item>
    </x-filament::tabs>
    @if($activeTab === 'tab3')
        <x-filament::section label="tab3"  wire:key="tab2-section">
            <x-slot name="heading">
                9-Box
            </x-slot>
            <x-slot name="description">
                Aquí encontrarás a los colaboradores agrupados por cuadrantes.
                {{-- Content --}}
            </x-slot>
                <!-- Contenido del Tab 2 (Nine Box) -->
            <div class="mt-4 grid gap-2 grid-cols-1 sm:grid-cols-3 xl:grid-cols-3">
                @foreach ($orderedIndexes as $i)
                        <div class="p-4 border">
                            <div class="flex items-center">
                                <x-filament::badge size="md" color="{{$colorBadgets[$i]}}">
                                    <span>Box{{ $i }}</span>
                                </x-filament::badge>
                                <span class="mr-2"> {{$titles[$i]}} </span>
                            </div>

                            <div class="mt-3">
                                @if (empty($quadrants[$i]['collaborators']))
                                    <span class="text-sm text-gray-500 dark:text-gray-400"> No hay colaboradores en este cuadrante</span>
                                @else
                                    @foreach ($quadrants[$i]['collaborators'] as $collaborator)
                                        @if ($collaborator->evaluatedUsers)
                                            <x-filament::avatar
                                                src="{{ $collaborator->evaluatedUsers->profile_photo ? url('storage/'.$collaborator->evaluatedUsers->profile_photo) : asset('path/to/default-avatar.png') }}"
                                                alt="{{ $collaborator->evaluatedUsers->name }}"
                                                class="mr-4 w-8 h-8 rounded-full inline-block"
                                                size="sm"
                                            />
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <div class="mt-2 flex items-center">
                                <x-filament::badge size="xs">
                                    {{ $quadrants[$i]['percentage'].'% ' }}
                                </x-filament::badge>
                                <span class="text-sm text-gray-500 dark:text-gray-400">de colaboradores</span>
                            </div>
                        </div>
                @endforeach
                </div>
        </x-filament::section>
    @endif
    @if($activeTab === 'tab2')

            <!-- Contenido del Tab 3 (Tabla) -->
            {{ $this->table }}

    @endif

    @if($activeTab === 'tab1')
        <x-filament::section label="tab1" wire:key="tab1-section">
            <!-- Contenido del Tab 1 -->
            <div>
                HOLA Aqui va una grefica bonita
            </div>
        </x-filament::section>
    @endif


</x-filament-panels::page>

