<x-filament-panels::page>

    <x-filament::tabs label="Content tabs">
        <x-filament::tabs.item
            :active="$activeTab === 'tab1'"
            wire:click="$set('activeTab', 'tab1')">
            Autoevaluación
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'tab2'"
            wire:click="$set('activeTab', 'tab2')">
            Jefe Inmediato
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'tab3'"
            wire:click="$set('activeTab', 'tab3')">
            Colaboradores
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'tab4'"
            wire:click="$set('activeTab', 'tab4')">
            Colega
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'tab5'"
            wire:click="$set('activeTab', 'tab5')">
            Cliente
        </x-filament::tabs.item>

    </x-filament::tabs>

    {{-- Autoevaluación Tab --}}
    @if($activeTab === 'tab1')
        <x-filament::section label="Autoevaluación">
            <x-slot name="heading">
                Autoevaluación
            </x-slot>
            <x-slot name="description">
                Contesta las preguntas de la autoevaluación
            </x-slot>
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-0 overflow-x-auto ps">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom">
                        <tr>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nombre</th>
                            <th class="px-3 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Estatus</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Días Restantes</th>
                            <th class="px-3 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($autoEvaluations as $member)
                            <tr>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="flex px-2 py-1">
                                        <div>
                                            @if($member->userToEvaluate->profile_photo)
                                                <x-filament::avatar
                                                    src="{{url('storage/'.$member->userToEvaluate->profile_photo)}}"
                                                    alt="{{$member->userToEvaluate->name}}"
                                                    class="mr-4"
                                                    size="lg"
                                                />
                                            @else
                                                <x-filament-panels::avatar.user size="lg" :user="$member->modelUser($member->userToEvaluate->id)" />
                                            @endif
                                        </div>
                                        <div class="flex flex-col justify-center px-3">
                                            <h6 class="mb-0 text-sm leading-normal">{{$member->userToEvaluate->name.' '.$member->userToEvaluate->first_name.' '.$member->userToEvaluate->last_name}}</h6>
                                            <p class="mb-0 text-xs leading-tight text-slate-400">{{$member->userToEvaluate->position?->name}}</p>
                                        </div>
                                    </div>
                                </td>
                                @php
                                    $idUser=$member->userToEvaluate->id;
                                    $isEvaluated = $this->responses->where('evaluated_user_id',$idUser)->count() > 0;

                                    @endphp
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::badge
                                        color="{{$isEvaluated ? 'success' : 'danger'}}"
                                        size="sm"
                                        class="text-xs font-semibold leading-tight w-20">
                                        {{$isEvaluated ? 'Evaluado' : 'Pendiente'}}
                                    </x-filament::badge>
                                </td>
                                <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <span class="text-xs font-semibold leading-tight text-slate-400">{{$daysRemaining}}</span>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <x-filament::button
                                        color="{{$isEvaluated ? 'success' : 'primary'}}"
                                        icon="heroicon-m-check-badge"
                                        icon-position="after"
                                        href="{{route('evaluacion.index',[
                                            'evaluated' => \Crypt::encryptString($member->userToEvaluate->id),
                                            'evaluator' => \Crypt::encryptString($member->user_id),
                                            'campaign' => \Crypt::encryptString($campaigns->id)
                                         ])}}"
                                        tag="a"
                                        size="sm"
                                        :disabled="$isEvaluated"
                                    >
                                        {{$isEvaluated ? 'Completada' : 'Iniciar Evaluación'}}
                                    </x-filament::button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center">
                                    <div>No tienes autoevaluaciones pendientes.</div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </x-filament::section>
    @endif

    {{-- Jefe Inmediato Tab --}}
    @if($activeTab === 'tab2')
        <x-filament::section label="Jefe Inmediato" icon="heroicon-o-user" icon-color="info">
            <x-slot name="heading">
                Jefe Inmediato
            </x-slot>
            <x-slot name="description">
                Evalúa a tu jefe inmediato.
            </x-slot>
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-0 overflow-x-auto ps">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom">
                        <tr>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nombre</th>
                            <th class="px-3 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Estatus</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Días Restantes</th>
                            <th class="px-3 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($supervisors as $supervisorAssign)
                            @php
                                $supervisorUser = \App\Models\User::find($supervisorAssign->user_to_evaluate_id);
                                $isEvaluated = $this->responses->where('evaluated_user_id', $supervisorAssign->user_to_evaluate_id)->count() > 0;
                            @endphp
                            @if($supervisorUser)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <div class="flex px-2 py-1">
                                            <div>
                                                @if($supervisorUser->profile_photo)
                                                    <x-filament::avatar
                                                        src="{{url('storage/'.$supervisorUser->profile_photo)}}"
                                                        alt="{{$supervisorUser->name}}"
                                                        class="mr-4"
                                                        size="lg"
                                                    />
                                                @else
                                                    <x-filament-panels::avatar.user size="lg" :user="$supervisorUser" />
                                                @endif
                                            </div>
                                            <div class="flex flex-col justify-center px-3">
                                                <h6 class="mb-0 text-sm leading-normal">{{$supervisorUser->name.' '.$supervisorUser->first_name.' '.$supervisorUser->last_name}}</h6>
                                                <p class="mb-0 text-xs leading-tight text-slate-400">{{$supervisorUser->position?->name}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <x-filament::badge
                                            color="{{$isEvaluated ? 'success' : 'danger'}}"
                                            size="sm"
                                            class="text-xs font-semibold leading-tight w-20">
                                            {{$isEvaluated ? 'Evaluado' : 'Pendiente'}}
                                        </x-filament::badge>
                                    </td>
                                    <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="text-xs font-semibold leading-tight text-slate-400">{{$daysRemaining}}</span>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <x-filament::button
                                            color="primary"
                                            icon="heroicon-m-check-badge"
                                            icon-position="after"
                                            href="{{route('evaluacion.index',[
                                                        'evaluated' => \Crypt::encryptString($supervisorAssign->user_to_evaluate_id),
                                                        'evaluator' => \Crypt::encryptString($supervisorAssign->user_id),
                                                        'campaign' => \Crypt::encryptString($campaigns->id)
                                                         ])}}"
                                            tag="a"
                                            size="sm"
                                            :disabled="$isEvaluated"
                                        >
                                            {{$isEvaluated ? 'Completada' : 'Iniciar Evaluación'}}
                                        </x-filament::button>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center">
                                    <div>No tienes evaluaciones pendientes para tu jefe inmediato.</div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </x-filament::section>
    @endif

    {{-- Colaboradores Tab --}}
    @if($activeTab === 'tab3')
        <x-filament::section label="Colaboradores">
            <x-slot name="heading">
                Colaboradores
            </x-slot>
            <x-slot name="description">
                Lista de Colaboradores
            </x-slot>
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-0 overflow-x-auto ps">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom">
                        <tr>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nombre</th>
                            <th class="px-3 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Estatus</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Días Restantes</th>
                            <th class="px-3 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($subordinates as $subordinateAssign)
                            @php
                                $subordinateUser = \App\Models\User::find($subordinateAssign->user_to_evaluate_id);
                                $isEvaluated = $this->responses->where('evaluated_user_id', $subordinateAssign->user_to_evaluate_id)->count() > 0;
                            @endphp
                            @if($subordinateUser)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <div class="flex px-2 py-1">
                                            <div>
                                                @if($subordinateUser->profile_photo)
                                                    <x-filament::avatar
                                                        src="{{url('storage/'.$subordinateUser->profile_photo)}}"
                                                        alt="{{$subordinateUser->name}}"
                                                        class="mr-4"
                                                        size="lg"
                                                    />
                                                @else
                                                    <x-filament-panels::avatar.user size="lg" :user="$subordinateUser" />
                                                @endif
                                            </div>
                                            <div class="flex flex-col justify-center px-3">
                                                <h6 class="mb-0 text-sm leading-normal">{{$subordinateUser->name.' '.$subordinateUser->first_name.' '.$subordinateUser->last_name}}</h6>
                                                <p class="mb-0 text-xs leading-tight text-slate-400">{{$subordinateUser->position?->name}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <x-filament::badge
                                            color="{{$isEvaluated ? 'success' : 'danger'}}"
                                            size="sm"
                                            class="text-xs font-semibold leading-tight w-20">
                                            {{$isEvaluated ? 'Evaluado' : 'Pendiente'}}
                                        </x-filament::badge>
                                    </td>
                                    <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="text-xs font-semibold leading-tight text-slate-400">{{$daysRemaining}}</span>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <x-filament::button
                                            color="primary"
                                            icon="heroicon-m-check-badge"
                                            icon-position="after"
                                            href="{{route('evaluacion.index',[
                                                        'evaluated' => \Crypt::encryptString($subordinateAssign->user_to_evaluate_id),
                                                        'evaluator' => \Crypt::encryptString($subordinateAssign->user_id),
                                                        'campaign' => \Crypt::encryptString($campaigns->id)
                                                         ])}}"
                                            tag="a"
                                            size="sm"
                                            :disabled="$isEvaluated"
                                        >
                                            {{$isEvaluated ? 'Completada' : 'Iniciar Evaluación'}}
                                        </x-filament::button>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center">
                                    <div>No tienes colaboradores asignados para evaluar.</div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </x-filament::section>
    @endif

    {{-- Colega Tab --}}
    @if($activeTab === 'tab4')
        <x-filament::section label="Colegas">
            <x-slot name="heading">
                Colegas
            </x-slot>
            <x-slot name="description">
                Lista de colegas a evaluar.
            </x-slot>
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-0 overflow-x-auto ps">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom">
                        <tr>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nombre</th>
                            <th class="px-3 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Estatus</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Días Restantes</th>
                            <th class="px-3 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($peers as $peerAssign)
                            @php
                                $peerUser = \App\Models\User::find($peerAssign->user_to_evaluate_id);
                                $isEvaluated = $this->responses->where('evaluated_user_id', $peerAssign->user_to_evaluate_id)->count() > 0;
                            @endphp
                            @if($peerUser)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <div class="flex px-2 py-1">
                                            <div>
                                                @if($peerUser->profile_photo)
                                                    <x-filament::avatar
                                                        src="{{url('storage/'.$peerUser->profile_photo)}}"
                                                        alt="{{$peerUser->name}}"
                                                        class="mr-4"
                                                        size="lg"
                                                    />
                                                @else
                                                    <x-filament-panels::avatar.user size="lg" :user="$peerUser" />
                                                @endif
                                            </div>
                                            <div class="flex flex-col justify-center px-3">
                                                <h6 class="mb-0 text-sm leading-normal">{{$peerUser->name.' '.$peerUser->first_name.' '.$peerUser->last_name}}</h6>
                                                <p class="mb-0 text-xs leading-tight text-slate-400">{{$peerUser->position?->name}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <x-filament::badge
                                            color="{{$isEvaluated ? 'success' : 'danger'}}"
                                            size="sm"
                                            class="text-xs font-semibold leading-tight w-20">
                                            {{$isEvaluated ? 'Evaluado' : 'Pendiente'}}
                                        </x-filament::badge>
                                    </td>
                                    <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="text-xs font-semibold leading-tight text-slate-400">{{$daysRemaining}}</span>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <x-filament::button
                                            color="primary"
                                            icon="heroicon-m-check-badge"
                                            icon-position="after"
                                            href="{{route('evaluacion.index',[
                                                        'evaluated' => \Crypt::encryptString($peerAssign->user_to_evaluate_id),
                                                        'evaluator' => \Crypt::encryptString($peerAssign->user_id),
                                                        'campaign' => \Crypt::encryptString($campaigns->id)
                                                         ])}}"
                                            tag="a"
                                            size="sm"
                                            :disabled="$isEvaluated"
                                        >
                                            {{$isEvaluated ? 'Completada' : 'Iniciar Evaluación'}}
                                        </x-filament::button>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center">
                                    <div>No tienes colegas asignados para evaluar.</div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </x-filament::section>
    @endif
    {{-- End Client Tab --}}

    {{-- Cliente Tab --}}
    @if($activeTab === 'tab5')
        <x-filament::section label="Clientes">
            <x-slot name="heading">
                Clientes
            </x-slot>
            <x-slot name="description">
                Lista de clientes a evaluar.
            </x-slot>
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-0 overflow-x-auto ps">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom">
                        <tr>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nombre</th>
                            <th class="px-3 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Estatus</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Días Restantes</th>
                            <th class="px-3 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($clients as $client)
                            @php
                                $clientEvaluatedUser = \App\Models\User::find($client->user_to_evaluate_id);
                                $isEvaluated = $this->responses->where('evaluated_user_id', $client->user_to_evaluate_id)->count() > 0;
                            @endphp
                            @if($clientEvaluatedUser)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <div class="flex px-2 py-1">
                                            <div>
                                                @if($clientEvaluatedUser->profile_photo)
                                                    <x-filament::avatar
                                                        src="{{url('storage/'.$clientEvaluatedUser->profile_photo)}}"
                                                        alt="{{$clientEvaluatedUser->name}}"
                                                        class="mr-4"
                                                        size="lg"
                                                    />
                                                @else
                                                    <x-filament-panels::avatar.user size="lg" :user="$clientEvaluatedUser" />
                                                @endif
                                            </div>
                                            <div class="flex flex-col justify-center px-3">
                                                <h6 class="mb-0 text-sm leading-normal">{{$clientEvaluatedUser->name.' '.$clientEvaluatedUser->first_name.' '.$clientEvaluatedUser->last_name}}</h6>
                                                <p class="mb-0 text-xs leading-tight text-slate-400">{{$clientEvaluatedUser->position?->name}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <x-filament::badge
                                            color="{{$isEvaluated ? 'success' : 'danger'}}"
                                            size="sm"
                                            class="text-xs font-semibold leading-tight w-20">
                                            {{$isEvaluated ? 'Evaluado' : 'Pendiente'}}
                                        </x-filament::badge>
                                    </td>
                                    <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="text-xs font-semibold leading-tight text-slate-400">{{$daysRemaining}}</span>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <x-filament::button
                                            color="primary"
                                            icon="heroicon-m-check-badge"
                                            icon-position="after"
                                            href="{{route('evaluacion.index',[
                                                        'evaluated' => \Crypt::encryptString($client->user_to_evaluate_id),
                                                        'evaluator' => \Crypt::encryptString(auth()->id()),
                                                        'campaign' => \Crypt::encryptString($campaigns->id)
                                                         ])}}"
                                            tag="a"
                                            size="sm"
                                            :disabled="$isEvaluated"
                                        >
                                            {{$isEvaluated ? 'Completada' : 'Iniciar Evaluación'}}
                                        </x-filament::button>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center">
                                    <div>No tienes clientes asignados para evaluar.</div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </x-filament::section>
    @endif

</x-filament-panels::page>
