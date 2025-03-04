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
                                    @if($userToEvaluated->profile_photo!==null)

                                        <x-filament::avatar
                                            src="{{ $userToEvaluated->profile_photo ? url('storage/'.$userToEvaluated->profile_photo) : asset('path/to/default-avatar.png') }}"
                                            alt="{{ $userToEvaluated->name }}"
                                            class="mr-4 w-8 h-8 rounded-full inline-block"
                                            size="sm"
                                            tooltip="{{ $userToEvaluated->name }}"
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
    @if($show)
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
                        @foreach (['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $month)
                            <th class="px-3 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                {{ $month }}
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($indicatorProgresses as $indicator)
                        <tr>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <div class="flex px-2 py-1">
                                    <div class="flex flex-col justify-center px-3">
                                        <h6 class="mb-0 text-sm leading-normal"> {{ $indicator->name }}</h6> <!-- Usa el nombre del indicador -->
                                    </div>
                                </div>
                            </td>
                            @php
                                $months = array_fill(1, 12, 0); // Inicializa un arreglo con 12 meses
                                foreach ($indicator->progresses as $progress) {
                                    $months[$progress->month] = $progress->progress_value; // Llena el mes con su valor
                                }
                            @endphp
                            @foreach ($months as $progressValue)
                                <td class="px-3 py-3 font-bold text-center align-middle bg-transparent border-b border-gray-200 shadow-none text-xs border-b-solid tracking-none whitespace-nowrap text-slate-500">
                                    {{ $progressValue }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </x-filament::section>
    @endif
    <x-filament::modal id="add-value"  width="2xl">

        <x-slot name="heading">

        </x-slot>
        <form wire:submit.prevent="save">
            <x-filament::section>

                <div class="mt-12">
                    <!-- Form -->

                    {{ $this->formProgresses }}


                </div>
            </x-filament::section>
            <x-slot name="footerActions">
                {{-- Modal footer actions --}}
                <x-filament::button
                    wire:click="closeModal"
                    class="mr-2"
                    tag="button"
                    type="button"
                    color="danger">
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
        </form>
    </x-filament::modal>
</x-filament-panels::page>
