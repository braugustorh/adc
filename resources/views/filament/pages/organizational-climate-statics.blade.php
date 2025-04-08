<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            Filtros de Datos
        </x-slot>
        <div class="fi-section-content-ctn">
            <div class="fi-section-content p-2">
                <div class="grid gap-2 grid-cols-1 sm:grid-cols-3 xl:grid-cols-3">
                    <div>
                        <label for="_campaign_id">Campaña</label>
                        <x-filament::input.wrapper class="mt-2">
                            <x-filament::input.select
                                id="_campaign_id"
                                wire:model.live="campaign_id">
                                <option selected value="">Todas </option>
                                @foreach($campaigns as $camp)
                                    <option value="{{$camp->id}}" >{{$camp->name}}</option>
                                @endforeach
                            </x-filament::input.select>

                        </x-filament::input.wrapper>
                    </div>
                    <div>
                        <label for="sede_id">Sede</label>
                        <x-filament::input.wrapper class="mt-2">
                            <x-filament::input.select
                                id="sede_id"
                                wire:model.live="sede_id">
                                @if(auth()->user()->hasAnyRole('Administrador','RH Corp'))
                                    <option selected value="">Todas</option>
                                    @foreach($sedes as $sede)
                                        <option value="{{$sede->id}}">{{$sede->name}}</option>
                                    @endforeach
                                @else
                                    @foreach($sedes as $sede)
                                        <option selected value="{{$sede->id}}">{{$sede->name}}</option>
                                    @endforeach
                                @endif
                            </x-filament::input.select>

                        </x-filament::input.wrapper>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>
    <x-filament::section
        collapsible
        collapsed
    >
        <x-slot name="heading">
            Más Filtros
        </x-slot>

        {{-- Content --}}
    </x-filament::section>
    <div class="grid md:grid-cols-3 gap-4">
        <div>
            <div class="flex flex-col gap-y-3 lg:gap-y-5 p-4 md:p-5 bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-800 mb-2">
                <div class="inline-flex justify-center items-center">
                    <span class="size-2 inline-block bg-red-500 rounded-full me-2"></span>
                    <span class="text-xs font-semibold uppercase text-gray-600 dark:text-neutral-400">
                       Score General
                    </span>
                </div>

                <div class="text-center">
                    <h3 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-800 dark:text-neutral-200">
                        {{ number_format($globalScorePercentage, 1) }}%
                    </h3>
                </div>

                <dl class="flex justify-center items-center divide-x divide-gray-200 dark:divide-neutral-800">
                    <dt class="pe-3">
                        <span class="ms-1 inline-flex items-center gap-x-1 bg-gray-200 font-medium text-gray-800 text-xs leading-4 rounded-full py-0.5 px-2 dark:bg-neutral-800 dark:text-neutral-300">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                  <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                                </svg>
                            score
                        </span>

                    </dt>
                    <dd class="text-start ps-3">
                        <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ number_format($globalScore, 2) }}</span>
                        <span class="block text-sm text-gray-500 dark:text-neutral-500">Promedio</span>
                    </dd>
                </dl>
            </div>
            <div class="flex flex-col gap-y-3 lg:gap-y-5 p-4 md:p-5 bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-800 mb-2">
                <div class="inline-flex justify-center items-center">
                    <span class="size-2 inline-block bg-gray-500 rounded-full me-2"></span>
                    <span class="text-xs font-semibold uppercase text-gray-600 dark:text-neutral-400">Audiencia</span>
                </div>

                <div class="text-center">
                    <h3 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-800 dark:text-neutral-200">
                        {{$users->count()}}
                    </h3>
                </div>

                <dl class="flex justify-center items-center divide-x divide-gray-200 dark:divide-neutral-800">
                    <dt class="pe-3">
                          <span class="text-green-600">
                            <svg class="inline-block size-4 self-center" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                              <path fill-rule="evenodd" d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                            </svg>
                            <span class="inline-block text-sm">
                              1.7%
                            </span>
                          </span>
                        <span class="block text-sm text-gray-500 dark:text-neutral-500">cambió</span>
                    </dt>
                    <dd class="text-start ps-3">
                        <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">5</span>
                        <span class="block text-sm text-gray-500 dark:text-neutral-500">última medición</span>
                    </dd>
                </dl>
            </div>
            <div class="flex flex-col gap-y-3 lg:gap-y-5 p-4 md:p-5 bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
                <div class="inline-flex justify-center items-center">
                    <span class="size-2 inline-block bg-gray-500 rounded-full me-2">
                    </span>
                    <span class="text-xs font-semibold uppercase text-gray-600 dark:text-neutral-400">Participación Total</span>
                </div>

                <div class="text-center">
                    <h3 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-800 dark:text-neutral-200">
                        {{$respondentCount}}
                    </h3>
                </div>

                <dl class="flex justify-center items-center divide-x divide-gray-200 dark:divide-neutral-800">
                    <dt class="pe-3">
                          <span class="text-green-600">
                            <svg class="inline-block size-4 self-center" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                              <path fill-rule="evenodd" d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                            </svg>
                            <span class="inline-block text-sm">
                              1.7%
                            </span>
                          </span>
                        <span class="block text-sm text-gray-500 dark:text-neutral-500">cambió</span>
                    </dt>
                    <dd class="text-start ps-3">
                        <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">5</span>
                        <span class="block text-sm text-gray-500 dark:text-neutral-500">última medición</span>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="md:col-span-2">
            <div class="mb-2">
                @livewire(\App\Livewire\ScoreClimaLineChart::class, ['chartData' => $campaignScores])
            </div>


        </div>
    </div>

        <div>
            @livewire(\App\Livewire\ScoreBySexChart::class,['chartData' => $sexChartData])
        </div>
        <div>
            @livewire(\App\Livewire\CompetencesClimaChart::class,['chartData' => $chartData])
        </div>


    <div>
        {{ $this->table }}
    </div>


</x-filament-panels::page>
