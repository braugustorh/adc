<x-filament-panels::page>
    <style>
        :root {
            --nb-surface-light: #ffffff;
            --nb-surface-dark: #18181b;
            --nb-surface-muted-light: #f8fafc;
            --nb-surface-muted-dark: #27272a;
            --nb-border-light: #e2e8f0;
            --nb-border-dark: #3f3f46;
            --nb-text-primary-light: #0f172a;
            --nb-text-primary-dark: #f4f4f5;
            --nb-text-muted-light: #64748b;
            --nb-text-muted-dark: #a1a1aa;

            --nb-surface: var(--nb-surface-light);
            --nb-surface-muted: var(--nb-surface-muted-light);
            --nb-border: var(--nb-border-light);
            --nb-text-primary: var(--nb-text-primary-light);
            --nb-text-muted: var(--nb-text-muted-light);

            @media (prefers-color-scheme: dark) {
                --nb-surface: var(--nb-surface-dark);
                --nb-surface-muted: var(--nb-surface-muted-dark);
                --nb-border: var(--nb-border-dark);
                --nb-text-primary: var(--nb-text-primary-dark);
                --nb-text-muted: var(--nb-text-muted-dark);
            }

            @supports (color: light-dark(white, black)) {
                --nb-surface: light-dark(var(--nb-surface-light), var(--nb-surface-dark));
                --nb-surface-muted: light-dark(var(--nb-surface-muted-light), var(--nb-surface-muted-dark));
                --nb-border: light-dark(var(--nb-border-light), var(--nb-border-dark));
                --nb-text-primary: light-dark(var(--nb-text-primary-light), var(--nb-text-primary-dark));
                --nb-text-muted: light-dark(var(--nb-text-muted-light), var(--nb-text-muted-dark));
            }

            color-scheme: light dark;
        }

        html.dark {
            --nb-surface: var(--nb-surface-dark);
            --nb-surface-muted: var(--nb-surface-muted-dark);
            --nb-border: var(--nb-border-dark);
            --nb-text-primary: var(--nb-text-primary-dark);
            --nb-text-muted: var(--nb-text-muted-dark);
        }

        .nb-container-scope {
            container-type: inline-size;
        }

        .nb-filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 1rem;
            inline-size: 100%;
        }

        .nb-kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.875rem;
            inline-size: 100%;
        }

        .nb-pill-bar {
            display: flex;
            flex-wrap: wrap;
            flex-wrap: balance;
            align-items: safe center;
            gap: 0.5rem;
        }

        .nb-matrix-wrapper {
            container: nb-matrix / inline-size;
            inline-size: 100%;
        }

        .nb-matrix-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            inline-size: 100%;
        }

        @media (min-width: 768px) {
            .nb-matrix-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @supports (container-type: inline-size) {
            @container nb-matrix (min-width: 680px) {
                .nb-matrix-grid {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }
            }
        }

        .nb-quadrant-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-radius: 0.875rem;
            border: 1px solid var(--nb-border);
            background-color: var(--nb-surface);
            padding: 1rem;
            transition: box-shadow 150ms ease, transform 150ms ease;
        }

        .nb-quadrant-card:hover {
            box-shadow: 0 8px 20px -6px rgb(0 0 0 / 0.08);
        }

        .nb-quadrant-tier-high {
            border-block-start: 4px solid #10b981;
        }

        .nb-quadrant-tier-mid {
            border-block-start: 4px solid #f59e0b;
        }

        .nb-quadrant-tier-low {
            border-block-start: 4px solid #0ea5e9;
        }

        .nb-quadrant-tier-risk {
            border-block-start: 4px solid #ef4444;
        }

        .nb-scrollable-list {
            max-block-size: 240px;
            overflow-y: auto;
            scrollbar-gutter: stable;
            overscroll-behavior: contain;
            padding-inline-end: 0.25rem;
        }

        .nb-collab-chip {
            display: flex;
            align-items: safe center;
            gap: 0.625rem;
            inline-size: 100%;
            text-align: start;
            padding: 0.5rem 0.625rem;
            border-radius: 0.625rem;
            border: 1px solid transparent;
            background-color: var(--nb-surface-muted);
            transition: background-color 150ms ease, border-color 150ms ease;
        }

        .nb-collab-chip:hover,
        .nb-collab-chip:focus-visible {
            border-color: #6366f1;
            outline: none;
        }

        .nb-flex-text {
            min-inline-size: 0;
            flex: 1 1 0%;
        }

        .nb-table-wrapper {
            overflow: auto;
            max-inline-size: 100%;
            container-type: inline-size;
            border-radius: 0.75rem;
        }
    </style>

    {{-- OMNIBAR DE ALCANCE ORGANIZACIONAL --}}
    <div class="nb-container-scope rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-gray-900">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 pb-3 dark:border-white/10">
            <div class="nb-flex-text">
                <div class="flex flex-wrap items-center gap-2">
                    <x-filament::icon icon="heroicon-m-adjustments-horizontal" class="h-5 w-5 text-primary-600 dark:text-primary-400" />
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                        Alcance Organizacional y Filtros de Visualización
                    </h2>
                    <x-filament::badge color="gray" size="xs" icon="heroicon-m-lock-closed">
                        Auto-exclusión activa (Tu usuario está oculto)
                    </x-filament::badge>
                </div>
                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                    Filtra resultados 360° y 9-Box por campaña, sede, departamento o equipo de trabajo respetando tu nivel de acceso.
                </p>
            </div>

            <div class="nb-pill-bar" style="margin-inline-start: auto;">
                <x-filament::loading-indicator
                    class="h-5 w-5 text-primary-600"
                    wire:loading
                    wire:target="campaignId,sedeId,departmentId,leaderPositionId,clearScopeFilters,user,changeTab,inspectCollaborator"
                />

                @if(($isGlobalViewer && $sedeId) || $departmentId || ($canFilterTeams && $leaderPositionId))
                    <x-filament::button
                        size="xs"
                        color="gray"
                        icon="heroicon-m-arrow-path"
                        wire:click="clearScopeFilters">
                        Restablecer alcance
                    </x-filament::button>
                @endif
            </div>
        </div>

        <div class="nb-filter-grid mt-4">
            {{-- 1. Campaña --}}
            <div>
                <label for="nb_campaign" class="block text-xs font-medium text-gray-700 dark:text-gray-300">
                    Campaña 360° / 9-Box
                </label>
                <x-filament::input.wrapper class="mt-1">
                    <x-filament::input.select id="nb_campaign" wire:model.live="campaignId">
                        @forelse($availableCampaigns as $camp)
                            <option value="{{ $camp->id }}">
                                {{ $camp->name }} ({{ $camp->status }})
                            </option>
                        @empty
                            <option value="">Sin campañas registradas</option>
                        @endforelse
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>

            {{-- 2. Sede / Central --}}
            <div>
                <label for="nb_sede" class="flex items-center justify-between text-xs font-medium text-gray-700 dark:text-gray-300">
                    <span>Sede / Ubicación</span>
                    @if(!$isGlobalViewer)
                        <span class="text-[11px] text-gray-400 dark:text-gray-500">Fijo por rol</span>
                    @endif
                </label>
                <x-filament::input.wrapper class="mt-1">
                    <x-filament::input.select
                        id="nb_sede"
                        wire:model.live="sedeId"
                        :disabled="!$isGlobalViewer">
                        @if($isGlobalViewer)
                            <option value="">Todas las sedes (Global)</option>
                        @endif
                        @foreach($availableSedes as $sedeOption)
                            <option value="{{ $sedeOption->id }}">{{ $sedeOption->name }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>

            {{-- 3. Departamento --}}
            <div>
                <label for="nb_department" class="block text-xs font-medium text-gray-700 dark:text-gray-300">
                    Departamento
                </label>
                <x-filament::input.wrapper class="mt-1">
                    <x-filament::input.select
                        id="nb_department"
                        wire:model.live="departmentId">
                        <option value="">Todos los departamentos</option>
                        @foreach($availableDepartments as $deptOption)
                            <option value="{{ $deptOption->id }}">{{ $deptOption->name }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>

            {{-- 4. Equipo de Trabajo (Líder Inmediato) --}}
            <div>
                <label for="nb_leader" class="flex items-center justify-between text-xs font-medium text-gray-700 dark:text-gray-300">
                    <span>Equipo de Trabajo (Líder)</span>
                    @if(!$canFilterTeams)
                        <span class="text-[11px] text-gray-400 dark:text-gray-500">Mi equipo directo</span>
                    @endif
                </label>
                <x-filament::input.wrapper class="mt-1">
                    <x-filament::input.select
                        id="nb_leader"
                        wire:model.live="leaderPositionId"
                        :disabled="!$canFilterTeams">
                        @if($canFilterTeams)
                            <option value="">Todos los equipos de trabajo</option>
                        @endif
                        @foreach($availableLeaders as $leaderOption)
                            <option value="{{ $leaderOption['position_id'] }}">
                                {{ $leaderOption['label'] }}
                            </option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>
        </div>

        {{-- KPIs EJECUTIVOS DEL ALCANCE ACTUAL --}}
        <div class="nb-kpi-grid mt-4 border-t border-gray-100 pt-4 dark:border-white/10">
            <div class="rounded-lg border border-gray-100 bg-gray-50/70 p-3 dark:border-white/5 dark:bg-white/[0.02]">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Colaboradores en alcance</span>
                    <x-filament::icon icon="heroicon-m-users" class="h-4 w-4 text-gray-400" />
                </div>
                <div class="mt-1 flex items-baseline gap-2">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $scopeMetrics['total_users'] }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">activos</span>
                </div>
            </div>

            <div class="rounded-lg border border-gray-100 bg-gray-50/70 p-3 dark:border-white/5 dark:bg-white/[0.02]">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Evaluados en 360°</span>
                    <x-filament::icon icon="heroicon-m-check-circle" class="h-4 w-4 text-emerald-500" />
                </div>
                <div class="mt-1 flex items-baseline gap-2">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $scopeMetrics['evaluated_360_count'] }}</span>
                    <x-filament::badge size="xs" :color="$scopeMetrics['coverage_pct'] >= 80 ? 'success' : ($scopeMetrics['coverage_pct'] >= 40 ? 'warning' : 'gray')">
                        {{ $scopeMetrics['coverage_pct'] }}% cobertura
                    </x-filament::badge>
                </div>
            </div>

            <div class="rounded-lg border border-gray-100 bg-gray-50/70 p-3 dark:border-white/5 dark:bg-white/[0.02]">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Promedio Desempeño 360°</span>
                    <x-filament::icon icon="heroicon-m-chart-bar" class="h-4 w-4 text-primary-500" />
                </div>
                <div class="mt-1 flex items-baseline gap-2">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $scopeMetrics['avg_360'] !== null ? number_format($scopeMetrics['avg_360'], 2) : '—' }}
                    </span>
                    @if($scopeMetrics['avg_360'] !== null)
                        @php
                            $avgPerfLevel = \App\Filament\Pages\Panel9Box::mapScoreToLevel($scopeMetrics['avg_360']);
                        @endphp
                        <x-filament::badge size="xs" :color="$avgPerfLevel === 3 ? 'success' : ($avgPerfLevel === 2 ? 'warning' : 'danger')">
                            {{ $avgPerfLevel === 3 ? 'Nivel Alto' : ($avgPerfLevel === 2 ? 'Nivel Medio' : 'Nivel Bajo') }}
                        </x-filament::badge>
                    @endif
                </div>
            </div>

            <div class="rounded-lg border border-gray-100 bg-gray-50/70 p-3 dark:border-white/5 dark:bg-white/[0.02]">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Promedio Potencial</span>
                    <x-filament::icon icon="heroicon-m-sparkles" class="h-4 w-4 text-amber-500" />
                </div>
                <div class="mt-1 flex items-baseline gap-2">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $scopeMetrics['avg_potential'] !== null ? number_format($scopeMetrics['avg_potential'], 2) : '—' }}
                    </span>
                    @if($scopeMetrics['avg_potential'] !== null)
                        @php
                            $avgPotLevel = \App\Filament\Pages\Panel9Box::mapScoreToLevel($scopeMetrics['avg_potential']);
                        @endphp
                        <x-filament::badge size="xs" :color="$avgPotLevel === 3 ? 'success' : ($avgPotLevel === 2 ? 'warning' : 'danger')">
                            {{ $avgPotLevel === 3 ? 'Nivel Alto' : ($avgPotLevel === 2 ? 'Nivel Medio' : 'Nivel Bajo') }}
                        </x-filament::badge>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- NAVEGACIÓN DE VISTAS --}}
    <x-filament::tabs label="Tabs NineBox">
        <x-filament::tabs.item
            :active="$activeTab === 'tab1'"
            wire:click="changeTab('tab1')"
            icon="heroicon-s-user-circle">
            Por Colaborador
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'tab2'"
            icon="heroicon-s-users"
            wire:click="changeTab('tab2')">
            Por Equipo de Trabajo
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'tab3'"
            wire:click="changeTab('tab3')"
            icon="heroicon-m-squares-plus">
            Gráfica 9-Box
        </x-filament::tabs.item>
    </x-filament::tabs>

    {{-- TAB 3: MATRIZ 9-BOX INTERACTIVA --}}
    @if($activeTab === 'tab3')
        <x-filament::section label="tab3" wire:key="tab3-section">
            <x-slot name="heading">
                Matriz de Talento 9-Box (Desempeño 360° vs. Potencial)
            </x-slot>
            <x-slot name="description">
                Haz clic sobre cualquier colaborador dentro de su cuadrante para abrir su radiografía individual.
            </x-slot>

            <div class="nb-matrix-wrapper">
                <div class="mb-4 flex flex-wrap items-center justify-between gap-2 rounded-lg bg-gray-50 px-3 py-2 text-xs text-gray-600 dark:bg-white/5 dark:text-gray-300">
                    <div class="nb-pill-bar">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">Eje Vertical (↑):</span>
                        <span>Potencial (Bajo &lt; 3.00 · Medio 3.00–3.99 · Alto 4.00–5.00)</span>
                    </div>
                    <div class="nb-pill-bar">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">Eje Horizontal (→):</span>
                        <span>Desempeño 360° (Bajo &lt; 3.00 · Medio 3.00–3.99 · Alto 4.00–5.00)</span>
                    </div>
                </div>

                <div class="nb-matrix-grid">
                    @foreach ($orderedIndexes as $i)
                        @php
                            $tierClass = match (true) {
                                in_array($i, [9, 8, 7], true) => 'nb-quadrant-tier-high',
                                in_array($i, [6, 5, 4], true) => 'nb-quadrant-tier-mid',
                                in_array($i, [3, 2], true) => 'nb-quadrant-tier-low',
                                default => 'nb-quadrant-tier-risk',
                            };
                            $quadrantCollaboratorIds = $quadrants[$i]['collaborators'] ?? [];
                            $quadrantCount = count($quadrantCollaboratorIds);
                            $quadrantPct = (float) ($quadrants[$i]['percentage'] ?? 0);
                            $axisHint = match ($i) {
                                4 => 'Desempeño Bajo · Potencial Alto',
                                7 => 'Desempeño Medio · Potencial Alto',
                                9 => 'Desempeño Alto · Potencial Alto',
                                2 => 'Desempeño Bajo · Potencial Medio',
                                5 => 'Desempeño Medio · Potencial Medio',
                                8 => 'Desempeño Alto · Potencial Medio',
                                1 => 'Desempeño Bajo · Potencial Bajo',
                                3 => 'Desempeño Medio · Potencial Bajo',
                                6 => 'Desempeño Alto · Potencial Bajo',
                                default => '',
                            };
                        @endphp

                        <div class="nb-quadrant-card {{ $tierClass }}">
                            {{-- Cabecera del Cuadrante --}}
                            <div>
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <x-filament::badge size="md" color="{{ $colorBadgets[$i] }}">
                                            Box {{ $i }}
                                        </x-filament::badge>
                                        <span class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $titles[$i] }}
                                        </span>
                                    </div>
                                    <span class="shrink-0 rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-700 dark:bg-white/10 dark:text-gray-200">
                                        {{ $quadrantCount }}
                                    </span>
                                </div>
                                <p class="mt-1 text-[11px] text-gray-500 dark:text-gray-400">
                                    {{ $axisHint }}
                                </p>
                            </div>

                            {{-- Lista desplazable de colaboradores en el cuadrante --}}
                            <div class="nb-scrollable-list my-3 space-y-1.5">
                                @if (empty($quadrantCollaboratorIds))
                                    <div class="flex h-24 items-center justify-center rounded-lg border border-dashed border-gray-200 p-3 text-center dark:border-white/10">
                                        <span class="text-xs text-gray-400 dark:text-gray-500">
                                            Sin colaboradores en este cuadrante
                                        </span>
                                    </div>
                                @else
                                    @foreach ($quadrantCollaboratorIds as $collaboratorId)
                                        @php
                                            $evaluatedUser = $users->firstWhere('id', $collaboratorId);
                                        @endphp
                                        @if ($evaluatedUser)
                                            @php
                                                $evaluatedFullName = trim($evaluatedUser->name . ' ' . $evaluatedUser->first_name . ' ' . $evaluatedUser->last_name);
                                                $scores = $collaboratorScores[$evaluatedUser->id] ?? null;
                                            @endphp
                                            <button
                                                type="button"
                                                wire:click="inspectCollaborator({{ $evaluatedUser->id }})"
                                                title="Ver detalle de {{ $evaluatedFullName }}"
                                                class="nb-collab-chip group">
                                                <div class="shrink-0">
                                                    @if($evaluatedUser->profile_photo !== null)
                                                        <x-filament::avatar
                                                            src="{{ $evaluatedUser->profile_photo_url }}"
                                                            alt="{{ $evaluatedFullName }}"
                                                            size="sm"
                                                        />
                                                    @else
                                                        <x-filament-panels::avatar.user
                                                            size="sm"
                                                            :user="$evaluatedUser"
                                                            alt="{{ $evaluatedFullName }}"
                                                        />
                                                    @endif
                                                </div>

                                                <div class="nb-flex-text">
                                                    <p class="truncate text-xs font-semibold text-gray-900 group-hover:text-primary-600 dark:text-gray-100 dark:group-hover:text-primary-400">
                                                        {{ $evaluatedFullName }}
                                                    </p>
                                                    <p class="truncate text-[11px] text-gray-500 dark:text-gray-400">
                                                        {{ $evaluatedUser->position?->name ?? 'Sin puesto' }}
                                                        @if($evaluatedUser->sede?->name)
                                                            · {{ $evaluatedUser->sede->name }}
                                                        @endif
                                                    </p>
                                                    @if($scores)
                                                        <div class="mt-0.5 flex items-center gap-2 text-[10px] font-medium text-gray-600 dark:text-gray-300">
                                                            <span>360°: <strong>{{ number_format((float) $scores['score_360'], 2) }}</strong></span>
                                                            <span>·</span>
                                                            <span>Pot: <strong>{{ $scores['score_potential'] !== null ? number_format((float) $scores['score_potential'], 2) : 'S/E' }}</strong></span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <x-filament::icon
                                                    icon="heroicon-m-arrow-top-right-on-square"
                                                    class="h-4 w-4 shrink-0 text-gray-400 opacity-0 transition-opacity group-hover:opacity-100 group-focus-visible:opacity-100"
                                                />
                                            </button>
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                            {{-- Pie del cuadrante con barra de distribución --}}
                            <div class="mt-auto border-t border-gray-100 pt-2.5 dark:border-white/10">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-500 dark:text-gray-400">Distribución del alcance</span>
                                    <span class="font-semibold text-gray-800 dark:text-gray-200">{{ number_format($quadrantPct, 2) }}%</span>
                                </div>
                                <div class="mt-1.5 h-1.5 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-white/10">
                                    <div
                                        class="h-full rounded-full bg-primary-600 dark:bg-primary-400"
                                        style="inline-size: {{ min(100, max(0, $quadrantPct)) }}%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </x-filament::section>
    @endif

    {{-- TAB 2: POR EQUIPO DE TRABAJO / DEPARTAMENTO / SEDE --}}
    @if($activeTab === 'tab2')
        <div class="space-y-6" wire:key="tab2-container">
            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div class="nb-flex-text">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                            Promedio de Competencias 360° del Alcance Seleccionado
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Calculado sobre <strong>{{ $scopeMetrics['evaluated_360_count'] }}</strong> colaboradores evaluados dentro del filtro activo (excluyendo tu propio usuario).
                        </p>
                    </div>
                </div>
            </div>

            <div>
                @livewire(
                    \App\Livewire\CompetencesChartTeam::class,
                    [
                        'campaignId' => $campaignId,
                        'userIds' => $users->pluck('id')->toArray(),
                    ],
                    key('comp-team-' . $campaignId . '-' . md5($users->pluck('id')->implode(',')))
                )
            </div>

            <div
                tabindex="0"
                role="region"
                aria-label="Tabla de promedio de competencias del equipo de trabajo"
                class="nb-table-wrapper">
                {{ $this->table }}
            </div>
        </div>
    @endif

    {{-- TAB 1: POR COLABORADOR --}}
    @if($activeTab === 'tab1')
        <x-filament::section label="tab1" wire:key="tab1-section">
            <div class="grid grid-cols-1 items-center gap-6 lg:grid-cols-12">
                {{-- Selector de Colaborador --}}
                <div class="lg:col-span-5">
                    <div class="flex items-center justify-between">
                        <label for="_user" class="text-sm font-medium text-gray-700 dark:text-gray-200">
                            Selecciona el colaborador a consultar
                        </label>
                        <x-filament::badge size="xs" color="gray">
                            {{ $users->count() }} en alcance
                        </x-filament::badge>
                    </div>

                    <x-filament::input.wrapper class="mt-2">
                        <x-filament::input.select
                            id="_user"
                            wire:model.live="user">
                            <option value="">— Selecciona un colaborador —</option>
                            @foreach($users as $us)
                                @php
                                    $fullNameOption = trim($us->name . ' ' . $us->first_name . ' ' . $us->last_name);
                                @endphp
                                <option value="{{ $us->id }}">
                                    {{ $fullNameOption }} — {{ $us->position?->name ?? 'Sin puesto' }} ({{ $us->sede?->name ?? 'Sin sede' }})
                                </option>
                            @endforeach
                        </x-filament::input.select>
                    </x-filament::input.wrapper>

                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        También puedes hacer clic sobre cualquier persona en la pestaña <strong>Gráfica 9-Box</strong> para cargar su ficha aquí.
                    </p>
                </div>

                {{-- Tarjeta Ejecutiva del Colaborador Seleccionado --}}
                <div class="lg:col-span-7">
                    @if($show && $userToEvaluated)
                        @php
                            $selectedFullName = trim($userToEvaluated->name . ' ' . $userToEvaluated->first_name . ' ' . $userToEvaluated->last_name);
                            $supervisorHolder = $userToEvaluated->position?->supervisor?->user?->first();
                            $supervisorFullName = $supervisorHolder
                                ? trim($supervisorHolder->name . ' ' . $supervisorHolder->first_name . ' ' . $supervisorHolder->last_name)
                                : ($userToEvaluated->position?->supervisor?->name ?? 'Sin jefe inmediato asignado');
                        @endphp
                        <div class="flex flex-wrap items-center gap-4 rounded-xl border border-gray-200 bg-gray-50/80 p-4 dark:border-white/10 dark:bg-white/[0.03]">
                            <div class="shrink-0">
                                @if($userToEvaluated->profile_photo)
                                    <x-filament::avatar
                                        src="{{ $userToEvaluated->profile_photo_url }}"
                                        alt="{{ $selectedFullName }}"
                                        title="{{ $selectedFullName }}"
                                        size="lg"
                                    />
                                @else
                                    <x-filament-panels::avatar.user size="lg" :user="$userToEvaluated" />
                                @endif
                            </div>

                            <div class="nb-flex-text">
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                    {{ $selectedFullName }}
                                </h3>
                                <p class="text-sm font-medium text-primary-600 dark:text-primary-400">
                                    {{ $userToEvaluated->position?->name ?? 'Sin puesto asignado' }}
                                </p>

                                <div class="nb-pill-bar mt-2 text-xs text-gray-600 dark:text-gray-300">
                                    <span class="inline-flex items-center gap-1 rounded-md bg-white px-2 py-0.5 shadow-2xs ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-white/10">
                                        <x-filament::icon icon="heroicon-m-building-office-2" class="h-3.5 w-3.5 text-gray-400" />
                                        <strong>Sede:</strong> {{ $userToEvaluated->sede?->name ?? 'N/A' }}
                                    </span>

                                    <span class="inline-flex items-center gap-1 rounded-md bg-white px-2 py-0.5 shadow-2xs ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-white/10">
                                        <x-filament::icon icon="heroicon-m-rectangle-group" class="h-3.5 w-3.5 text-gray-400" />
                                        <strong>Depto:</strong> {{ $userToEvaluated->department?->name ?? 'N/A' }}
                                    </span>

                                    <span class="inline-flex items-center gap-1 rounded-md bg-white px-2 py-0.5 shadow-2xs ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-white/10">
                                        <x-filament::icon icon="heroicon-m-user" class="h-3.5 w-3.5 text-gray-400" />
                                        <strong>Líder:</strong> {{ $supervisorFullName }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 rounded-xl border border-dashed border-gray-200 p-4 text-sm text-gray-500 dark:border-white/10 dark:text-gray-400">
                            <x-filament::icon icon="heroicon-o-cursor-arrow-rays" class="h-6 w-6 shrink-0 text-gray-400" />
                            <div>
                                <p class="font-medium text-gray-700 dark:text-gray-200">Ningún colaborador seleccionado</p>
                                <p class="text-xs">Elige un colaborador del selector izquierdo para visualizar su puntaje 360°, potencial psicométrico, clasificación 9-Box y desglose por competencia.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </x-filament::section>

        @if($show && $user)
            <div class="space-y-6">
                <div>
                    @livewire(
                        \App\Livewire\Score360::class,
                        [
                            'user' => $user,
                            'campaignId' => $campaignId,
                            'titles' => $titles,
                            'colors' => $colorBadgets,
                        ],
                        key('score360-' . $user . '-' . $campaignId)
                    )
                </div>

                <div>
                    @livewire(
                        \App\Livewire\CompetencesChart::class,
                        [
                            'user' => $user,
                            'campaignId' => $campaignId,
                        ],
                        key('comp-chart-' . $user . '-' . $campaignId)
                    )
                </div>
            </div>
        @endif
    @endif
</x-filament-panels::page>
