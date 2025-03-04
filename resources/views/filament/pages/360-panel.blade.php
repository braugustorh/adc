<x-filament-panels::page>

    <x-filament::tabs label="Content tabs">
        <x-filament::tabs.item
            :active="$activeTab === 'tab1'"
            wire:click="$set('activeTab', 'tab1')">
            Colaboradores
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'tab2'"
            wire:click="$set('activeTab', 'tab2')">
            Superior

        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'tab3'"
            wire:click="$set('activeTab', 'tab3')">
            Cliente
        </x-filament::tabs.item>

    </x-filament::tabs>
    @if($activeTab==='tab1')
        <x-filament::section label="Tab1" >
            <x-slot name="heading">
                Lista de Colaboradores
            </x-slot>
            <x-slot name="description">
                Aquí encontrarás la lista de colaboradores que deberás evaluar
                {{-- Content --}}
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
                        @foreach($members as $member)
                            @if($member->user_id!=1)
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
                                                <p class="mb-0 text-xs leading-tight text-slate-400">{{$member->userToEvaluate->position->name}}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        @php
                                            $idUser=$member->userToEvaluate->id;
                                            $isEvaluated = $this->responses->where('evaluated_user_id',$idUser)->count() > 0;
                                            /*Solo funciona porque busca el primer registro que cumpla la condición
                                                $isEvaluated = $this->responses->search(function ($item, $key) use ($idUser) {
                                                    dump($item->evaluated_user_id);
                                                    return $item->evaluated_user_id === $idUser;
                                                }) === 0;
                                                dump($idUser);
                                            */
                                        @endphp
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
                                            disabled="{{$isEvaluated?'true':''}}"
                                        >
                                            {{$isEvaluated?'Completada':'Iniciar Evaluación'}}
                                         </x-filament::button>
                                     </td>
                                 </tr>
                             @endif
                         @endforeach
                         </tbody>
                    </table>
                     <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                         <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;">

                         </div>
                     </div>
                    <div class="ps__rail-y" style="top: 0px; right: 0px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;">

                        </div>
                    </div>
                </div>
            </div>
         </x-filament::section>
     @endif

     @if($activeTab==='tab2')
         <x-filament::section
             icon="heroicon-o-user"
             icon-color="info">
             <x-slot name="heading">
                 Evaluación de Jefe inmediato
             </x-slot>
             <x-slot name="description">

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
                         @foreach($supervisors as $super)
                                 <tr>
                                     <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                         <div class="flex px-2 py-1">
                                             <div>
                                                 @if($super->userToEvaluate->profile_photo)
                                                     <x-filament::avatar
                                                         src="{{url('storage/'.$super->userToEvaluate->profile_photo)}}"
                                                        alt="{{$super->userToEvaluate->name}}"
                                                        class="mr-4"
                                                        size="lg"
                                                    />
                                                @else
                                                    <x-filament-panels::avatar.user size="lg" :user="$super->modelUser($super->userToEvaluate->id)" />
                                                @endif


                                            </div>
                                            <div class="flex flex-col justify-center px-3">
                                                <h6 class="mb-0 text-sm leading-normal">{{$super->userToEvaluate->name.' '.$super->userToEvaluate->first_name.' '.$super->userToEvaluate->last_name}}</h6>
                                                <p class="mb-0 text-xs leading-tight text-slate-400">{{$super->userToEvaluate->position->name}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    @php
                                        $idUser=$super->userToEvaluate->id;
                                        $isEvaluated = $this->responses->where('evaluated_user_id',$idUser)->count() > 0;
                                        /*Solo funciona porque busca el primer registro que cumpla la condición
                                            $isEvaluated = $this->responses->search(function ($item, $key) use ($idUser) {
                                                dump($item->evaluated_user_id);
                                                return $item->evaluated_user_id === $idUser;
                                            }) === 0;
                                            dump($idUser);
                                        */
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
                                            color="primary"
                                            icon="heroicon-m-check-badge"
                                            icon-position="after"
                                            href="{{route('evaluacion.index',[
                                                        'evaluated' => \Crypt::encryptString($super->userToEvaluate->id),
                                                        'evaluator' => \Crypt::encryptString($super->user_id),
                                                        'campaign' => \Crypt::encryptString($campaigns->id)
                                                         ])}}"
                                            tag="a"
                                            target="_blank"
                                            size="sm"
                                            disabled="{{$isEvaluated?'true':''}}"
                                        >
                                            Iniciar Evaluación
                                        </x-filament::button>
                                    </td>
                                </tr>
                        @endforeach
        </x-filament::section>
    @endif

    @if($activeTab==='tab3')
        <x-filament::section >
            <x-slot name="heading">
                Lista de Colaboradores
            </x-slot>
            <x-slot name="description">
                Lista

            </x-slot>


        </x-filament::section>
    @endif

</x-filament-panels::page>
