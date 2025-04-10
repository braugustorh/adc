
<x-filament-widgets::widget>
    <x-filament::section>
            @forelse ($campaigns as $campaign)
                <h2 class="text-lg font-bold">{{ $campaign->name }}</h2>
                <ul>
                    @foreach ($campaign->evaluations as $evaluation)
                        @if($evaluation->name !== 'Face to Face'
                            && $evaluation->name !== '9 Box' )


                        <li class="flex items-center justify-between py-2 border-b">
                            <span>{{ $evaluation->name }}</span>
                            @if($evaluation->id===1 && $user->hasAnyRole('Supervisor','RH','RH Corp','Administrador'))
                                <x-filament::button
                                    color="warning"
                                    icon="heroicon-c-paper-airplane"
                                    icon-position="after"
                                    labeled-from="sm"
                                    href="/dashboard/panel9-box"
                                    tag="a"
                                >
                                    {{ __('Ir al panel') }}
                                </x-filament::button>
                            @elseif($evaluation->name ==='Clima Organizacional')
                                @if($responseCO->where('campaign_id', $campaign->id)->count() !== 0)
                                    <x-filament::button
                                        color="success"
                                        icon="heroicon-c-paper-airplane"
                                        icon-position="after"
                                        labeled-from="sm"
                                        disabled="true"
                                        tag="a"
                                    >
                                        {{ __('Completada') }}
                                    </x-filament::button>
                                @else
                                    <x-filament::button
                                        color="warning"
                                        icon="heroicon-c-paper-airplane"
                                        icon-position="after"
                                        labeled-from="sm"
                                        href="{{ route('clima-organizacional.index', [
                                            'user' => \Crypt::encryptString($user->id),
                                            'campaign' => \Crypt::encryptString($campaign->id),
                                        ]) }}"
                                        tag="a"
                                    >
                                        {{ __('Realizar Evaluación') }}
                                    </x-filament::button>
                                @endif
                            @elseif($evaluation->name==='360')
                               @php
                               $response = $this->response360->where('campaign_id', $campaign->id)
                               ->unique('evaluated_user_id')->count();
                               $assignedUsers=\App\Models\EvaluationAssign::where('evaluation_id', 2)
                               ->where('campaign_id', $campaign->id)
                               ->where('user_to_evaluate_id', auth()->user()->id)
                                ->distinct('user_id')
                               ->count();
                               $this->qtty=$assignedUsers-$response;
                               @endphp
                                @if($this->qtty==0)
                                    <x-filament::button
                                        color="success"
                                        icon="heroicon-c-paper-airplane"
                                        icon-position="after"
                                        labeled-from="sm"
                                        disabled="true"
                                        tag="a"
                                    >
                                        {{ __('Completada') }}
                                    </x-filament::button>
                                @else
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
                                @endif
{{--                            @elseif($evaluation->id===4 && $user->hasAnyRole('Supervisor','RH','RH Corp','Administrador'))--}}
{{--                                    <x-filament::button--}}
{{--                                        color="warning"--}}
{{--                                        icon="heroicon-c-paper-airplane"--}}
{{--                                        icon-position="after"--}}
{{--                                        labeled-from="sm"--}}
{{--                                        href="/dashboard/one-to-one"--}}
{{--                                        tag="a"--}}
{{--                                    >--}}
{{--                                        {{ __('Ir al panel') }}--}}
{{--                                    </x-filament::button>--}}
                            @endif
                        </li>
                        @endif
                    @endforeach
                </ul>
            @empty
                <p>No hay campañas activas para tu sede en este momento.</p>
            @endforelse
    </x-filament::section>
</x-filament-widgets::widget>
