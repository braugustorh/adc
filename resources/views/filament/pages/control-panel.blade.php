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
                                            :src="$userToEvaluated->profile_photo_url"
                                            :alt="$userToEvaluated->name"
                                            class="mr-4 w-8 h-8 rounded-full inline-block"
                                            size="sm"
                                            :tooltip="$userToEvaluated->name"
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
        <x-filament::section collapsible id="indicadores" collapsed>
            <x-slot name="heading">
                <strong>Indicadores</strong>
            </x-slot>
            <x-slot name="description">
                Gestiona los indicadores de desempeño de tu colaborador.
                {{-- Content --}}
            </x-slot>
            <div class="space-y-4">
                <form wire:submit.prevent="saveIndicador">
                    {{ $this->formIndicador }}
                    <x-filament::button type="submit" ag="a" class="cursor-pointer"
                                        icon="heroicon-s-arrow-right-circle" color="primary">
                        Guardar Indicadores
                    </x-filament::button>
                </form>
            </div>

        </x-filament::section>
    @endif
</x-filament-panels::page>

