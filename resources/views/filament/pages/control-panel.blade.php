<x-filament-panels::page>
    <x-filament::section>
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
                                    <x-filament::avatar
                                        src="{{ $userToEvaluated->profile_photo ? url('storage/'.$userToEvaluated->profile_photo) : asset('path/to/default-avatar.png') }}"
                                        alt="{{ $userToEvaluated->name }}"
                                        size="h-16"/>
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
    @if($show)
        <x-filament::section collapsible id="indicadores" collapsed>
            <x-slot name="heading">
                <strong>Indicadores</strong>
            </x-slot>
            <x-slot name="description">
                Gestiona los indicadores de desempeño de tu colaborador.
                {{-- Content --}}
            </x-slot>
            {{$this->formIndicador}}

        </x-filament::section>


        <!-- Table Section -->
        <x-filament::section id="Table">
            <x-slot name="heading">
                <strong>Tabla de indicadores</strong>
            </x-slot>
            <x-slot name="description">
                Revisa el avance de tu colaborador por indicador.
                {{-- Content --}}
            </x-slot>
            <x-slot name="headerEnd">
                <x-filament::button wire:click="addValue" tag="a" class="cursor-pointer" icon="heroicon-m-sparkles">
                    {{ __('Registrar Avance') }}
                </x-filament::button>
            </x-slot>

            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-0 overflow-x-auto ps">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom">
                        <tr>
                            <th class="px-3 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Indicadores</th>
                            <th class="px-3 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Enero</th>
                            <th class="px-3 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Febrero</th>
                            <th class="px-3 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Marzo</th>
                            <th class="px-3 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Abril</th>
                            <th class="px-3 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Mayo</th>
                            <th class="px-3 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Junio</th>
                            <th class="px-3 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Julio</th>
                            <th class="px-3 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Agosto</th>
                            <th class="px-3 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Septiembre</th>
                            <th class="px-3 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Octubre</th>
                            <th class="px-3 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Noviembre</th>
                            <th class="px-3 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Diciembre</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="flex px-2 py-1">
                                        <div class="flex flex-col justify-center px-3">
                                            <h6 class="mb-0 text-sm leading-normal">Indicador 1</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="danger"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        0%
                                    </x-filament::badge>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="danger"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        0%
                                    </x-filament::badge>

                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="danger"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        0%
                                    </x-filament::badge>

                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="danger"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        0%
                                    </x-filament::badge>

                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="danger"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        0%
                                    </x-filament::badge>

                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="danger"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        0%
                                    </x-filament::badge>

                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="danger"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        0%
                                    </x-filament::badge>

                                </td>

                            </tr>
                            <tr>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="flex px-2 py-1">
                                        <div class="flex flex-col justify-center px-3">
                                            <h6 class="mb-0 text-sm leading-normal">Indicador 2</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="success"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        10
                                    </x-filament::badge>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="warning"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        3
                                    </x-filament::badge>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="warning"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        5
                                    </x-filament::badge>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="danger"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        4
                                    </x-filament::badge>

                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="success"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        9
                                    </x-filament::badge>

                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="success"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        8
                                    </x-filament::badge>

                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="danger"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        4
                                    </x-filament::badge>

                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="danger"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-10">
                                        4
                                    </x-filament::badge>

                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="warning"
                                        size="xs"
                                        class="text-xs font-semibold leading-tight w-10">
                                        7
                                    </x-filament::badge>

                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </x-filament::section>
        <x-filament::modal id="add-value"  width="2xl">

            <x-slot name="heading">

            </x-slot>

            <x-filament::section>

                <div class="mt-12">
                    <!-- Form -->
                    <form>
                        <div class="grid gap-4 lg:gap-6">
                            <!-- Grid -->
                            <div class="grid grid-cols-3 sm:grid-cols-3 gap-4 lg:gap-6">
                                <div>
                                    <label>Indicadores</label>
                                    <x-filament::input.wrapper>
                                        <x-filament::input.select wire:model="indicador_mes">
                                            <option value="indicador1">Indicador 1</option>
                                            <option value="indicador2">Indicador 2</option>
                                            <option value="indicador3">Indicador 3</option>
                                        </x-filament::input.select>
                                    </x-filament::input.wrapper>
                                </div>

                                <div>
                                    <label>Mes</label>
                                    <x-filament::input.wrapper>
                                        <x-filament::input.select wire:model="month">
                                            <option value="Enero">Enero</option>
                                            <option value="Febrero">Febrero</option>
                                            <option value="Marzo">Marzo</option>
                                            <option value="Abril">Abril</option>
                                            <option value="Mayo">Mayo</option>
                                            <option value="Junio">Junio</option>
                                            <option value="Julio">Julio</option>
                                            <option value="Agosto">Agosto</option>
                                            <option value="Septiembre">Septiembre</option>
                                            <option value="Octubre">Octubre</option>
                                            <option value="Noviembre">Noviembre</option>
                                            <option value="Diciembre">Diciembre</option>
                                        </x-filament::input.select>
                                    </x-filament::input.wrapper>
                                </div>
                                <div>
                                    <label>Avance</label>
                                    <x-filament::input.wrapper>
                                        <x-filament::input
                                            type="numeric"
                                            wire:model="avance"
                                        />
                                    </x-filament::input.wrapper>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </x-filament::section>

            <x-slot name="footerActions">
                {{-- Modal footer actions --}}
                <x-filament::button
                    wire:click="closeModal"
                    class="mr-2"
                    tag="button"
                    type="button"
                    color="secondary">
                    {{ __('Cancelar') }}
                </x-filament::button>
                <x-filament::button
                    wire:click="save"
                    tag="button"
                    type="button"
                    color="primary">
                    {{ __('Guardar') }}
                </x-filament::button>
            </x-slot>

        </x-filament::modal>

    @endif
</x-filament-panels::page>

