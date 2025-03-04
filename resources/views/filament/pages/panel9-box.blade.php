<x-filament-panels::page>

    <x-filament::tabs label="Tabs NineBox">

        <x-filament::tabs.item
            :active="$activeTab === 'tab1'"
            wire:click="changeTab('tab1')"
            icon='heroicon-s-chart-pie'>
            Por Colaborador
        </x-filament::tabs.item>
        <x-filament::tabs.item
            :active="$activeTab === 'tab2'"
            icon='heroicon-s-users'
            wire:click="changeTab('tab2')">
            Por Equipo de Trabajo
        </x-filament::tabs.item>
        <x-filament::tabs.item
            :active="$activeTab === 'tab3'"
            wire:click="changeTab('tab3')"
            icon='heroicon-m-squares-plus'>
            Gráfica 9-Box
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
                                            @if($collaborator->evaluatedUsers->profile_photo!==null)

                                                <x-filament::avatar
                                                    src="{{ $collaborator->evaluatedUsers->profile_photo ? url('storage/'.$collaborator->evaluatedUsers->profile_photo) : asset('path/to/default-avatar.png') }}"
                                                    alt="{{ $collaborator->evaluatedUsers->name }}"
                                                    class="mr-4 w-8 h-8 rounded-full inline-block"
                                                    size="sm"
                                                    title="{{ $collaborator->evaluatedUsers->name }}"
                                                />

                                            @else

                                                <x-filament-panels::avatar.user size="sm" :user="$collaborator->evaluatedUsers"
                                                                                alt="{{ $collaborator->evaluatedUsers->name }}"
                                                                                title="{{ $collaborator->evaluatedUsers->name }}"/>
                                            @endif
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
            {{-- $this->table --}}
        <div>
            @livewire(\App\Livewire\CompetencesChartTeam::class)
        </div>

        {{ $this->table }}



    @endif

    @if($activeTab === 'tab1')
        <x-filament::section label="tab1" wire:key="tab1-section">
            <!-- Contenido del Tab 1 -->
            <div class="fi-section-content-ctn">
                <div class="fi-section-content p-2">
                    <div class="grid gap-2 grid-cols-1 sm:grid-cols-3 xl:grid-cols-3">
                        <div>
                            <label for="_user">Selecciona el colaborador a evaluar</label>
                            <x-filament::input.wrapper class="mt-2">
                                <x-filament::input.select
                                    id="_user"
                                    wire:model.change="user">
                                    <option value="" hidden="true">Selecciona un colaborador</option>
                                    @foreach($users as $us)
                                        <option value="{{$us->id}}">{{$us->name.' '.$us->first_name.' '.$us->last_name}}</option>
                                    @endforeach
                                </x-filament::input.select>

                            </x-filament::input.wrapper>


                        </div>
                        <div class="content-center gap-4">
                            <div>
                                <x-filament::loading-indicator class="h-7 w-7 invisible" wire:loading.class.remove="invisible " wire:target="user"/>
                            </div>
                        </div>
                        <div>
                            @if($show)
                                <div class="flex items-center gap-x-3">
                                    <div class="shrink-0">
                                        @if($userToEvaluated->profile_photo)
                                            <x-filament::avatar
                                                src="{{ $userToEvaluated->profile_photo ? url('storage/'.$userToEvaluated->profile_photo) : asset('path/to/default-avatar.png') }}"
                                                alt="{{ $userToEvaluated->name }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="{{ $userToEvaluated->name }}"
                                                size="h-16"
                                            />
                                        @else
                                            <x-filament-panels::avatar.user size="lg" :user="$userToEvaluated" />

                                        @endif

                                    </div>

                                    <div class="grow">
                                        <h1 class="text-lg font-medium text-gray-800 dark:text-neutral-200">
                                            {{$userToEvaluated->name.' '.$userToEvaluated->first_name.' '.$userToEvaluated->last_name}}
                                        </h1>
                                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                                            {{$userToEvaluated->position->name}}
                                        </p>
                                    </div>
                                </div>
                            @endif

                        </div>


                    </div>
                </div>
            </div>
        </x-filament::section>
        <div>
            @livewire(\App\Livewire\Score360::class)
        </div>
            <div>
                @livewire(\App\Livewire\CompetencesChart::class)
            </div>

    @endif


</x-filament-panels::page>

