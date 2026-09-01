<x-filament-panels::page>
    {{-- ── ESTILOS AUTOCONTENIDOS PARA EL MONITOR 360 ────────────────────── --}}
    <style>
        .m360-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            font-family: inherit;
        }

        /* ── BARRA SUPERIOR DE FILTROS ── */
        .m360-toolbar {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 1.25rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        @media (min-width: 1024px) {
            .m360-toolbar {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }
        .m360-filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            width: 100%;
        }
        @media (min-width: 1024px) {
            .m360-filter-group {
                width: auto;
            }
        }
        .m360-input-box {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            min-width: 260px;
            flex: 1;
        }
        .m360-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
        }
        .m360-select {
            width: 100%;
            padding: 0.55rem 0.85rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #111827;
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .m360-select:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
            background-color: #ffffff;
        }
        .m360-select:disabled {
            background-color: #f3f4f6;
            color: #9ca3af;
            cursor: not-allowed;
        }

        /* ── BADGES & STATUS ── */
        .m360-badge-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
        }
        .m360-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 9999px;
            white-space: nowrap;
        }
        .m360-pill-success { background-color: #d1fae5; color: #065f46; }
        .m360-pill-warning { background-color: #fef3c7; color: #92400e; }
        .m360-pill-danger  { background-color: #fee2e2; color: #991b1b; }
        .m360-pill-info    { background-color: #e0e7ff; color: #3730a3; }
        .m360-pill-gray    { background-color: #f3f4f6; color: #374151; }

        /* ── GRID DE KPIS (4 COLUMNAS) ── */
        .m360-kpi-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        @media (min-width: 640px) {
            .m360-kpi-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (min-width: 1024px) {
            .m360-kpi-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        .m360-kpi-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 1.25rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .m360-kpi-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08);
            transform: translateY(-1px);
        }
        .m360-kpi-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }
        .m360-kpi-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
        }
        .m360-kpi-value {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1.1;
            margin-top: 0.35rem;
            color: #111827;
        }
        .m360-kpi-icon {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        .m360-kpi-footer {
            margin-top: 0.85rem;
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* ── BARRAS DE PROGRESO ── */
        .m360-progress-track {
            width: 100%;
            height: 0.6rem;
            background-color: #f3f4f6;
            border-radius: 9999px;
            overflow: hidden;
            margin-top: 0.75rem;
        }
        .m360-progress-bar {
            height: 100%;
            border-radius: 9999px;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .bg-progress-emerald { background-color: #10b981; }
        .bg-progress-amber   { background-color: #f59e0b; }
        .bg-progress-rose    { background-color: #ef4444; }
        .bg-progress-indigo  { background-color: #6366f1; }

        /* ── PESTAÑAS ── */
        .m360-tabs-container {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .m360-tab-nav {
            display: flex;
            border-bottom: 1px solid #e5e7eb;
            background-color: #fafafa;
            padding: 0 1rem;
            gap: 1.5rem;
            overflow-x: auto;
        }
        .m360-tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 0.5rem;
            font-size: 0.875rem;
            font-weight: 700;
            color: #6b7280;
            border-bottom: 3px solid transparent;
            background: none;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .m360-tab-btn:hover {
            color: #111827;
        }
        .m360-tab-btn.active {
            color: #d97706;
            border-bottom-color: #f59e0b;
        }
        .m360-tab-count {
            padding: 0.15rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 700;
            border-radius: 9999px;
            background-color: #e5e7eb;
            color: #374151;
        }
        .m360-tab-btn.active .m360-tab-count {
            background-color: #fef3c7;
            color: #92400e;
        }

        /* ── GRID DE SEDES (PESTAÑA 1) ── */
        .m360-sedes-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
            padding: 1.5rem;
        }
        @media (min-width: 640px) {
            .m360-sedes-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (min-width: 1024px) {
            .m360-sedes-grid { grid-template-columns: repeat(3, 1fr); }
        }
        .m360-sede-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            transition: all 0.2s;
        }
        .m360-sede-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.06);
            border-color: #d1d5db;
        }
        .m360-stats-box {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            background-color: #f9fafb;
            border-radius: 0.5rem;
            padding: 0.75rem 0.5rem;
            margin-top: 1rem;
            text-align: center;
        }
        .m360-btn-outline {
            width: 100%;
            margin-top: 1rem;
            padding: 0.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #92400e;
            background-color: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
        }
        .m360-btn-outline:hover {
            background-color: #fef3c7;
            color: #78350f;
        }

        /* ── TABLA DE EVALUADORES (PESTAÑA 2) ── */
        .m360-table-controls {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 1.25rem 1.5rem 0 1.5rem;
        }
        @media (min-width: 1024px) {
            .m360-table-controls {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }
        .m360-search-input {
            width: 100%;
            padding: 0.5rem 0.85rem;
            font-size: 0.875rem;
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            outline: none;
        }
        .m360-search-input:focus {
            border-color: #f59e0b;
            background-color: #fff;
        }
        .m360-status-btn-group {
            display: inline-flex;
            background-color: #f3f4f6;
            padding: 0.25rem;
            border-radius: 0.5rem;
            gap: 0.25rem;
        }
        .m360-status-btn {
            padding: 0.35rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 0.375rem;
            border: none;
            background: none;
            cursor: pointer;
            color: #6b7280;
            transition: all 0.15s;
        }
        .m360-status-btn.active {
            background-color: #ffffff;
            color: #111827;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        }
        .m360-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1rem;
            font-size: 0.8rem;
            font-weight: 700;
            color: #ffffff;
            background-color: #d97706;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            transition: background-color 0.2s;
            white-space: nowrap;
        }
        .m360-btn-primary:hover {
            background-color: #b45309;
        }
        .m360-table-wrapper {
            padding: 1rem 1.5rem 1.5rem 1.5rem;
            overflow-x: auto;
        }
        .m360-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
            text-align: left;
        }
        .m360-table th {
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }
        .m360-table td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
        .m360-table tr:hover td {
            background-color: #fafafa;
        }
        .m360-avatar {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 9999px;
            background-color: #f3f4f6;
            color: #4b5563;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            flex-shrink: 0;
        }
        .m360-icon-btn {
            padding: 0.4rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            background-color: #f3f4f6;
            color: #4b5563;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .m360-icon-btn:hover {
            background-color: #fef3c7;
            color: #92400e;
        }

        /* ── MODAL FLOTANTE ANÓNIMO ── */
        .m360-modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(17, 24, 39, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .m360-modal-box {
            background-color: #ffffff;
            border-radius: 1rem;
            width: 100%;
            max-width: 32rem;
            padding: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .m360-secret-banner {
            background-color: #fffbeb;
            border: 1px solid #fef3c7;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-size: 0.75rem;
            color: #92400e;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        /* ── MODO OSCURO (DARK MODE) ── */
        .dark .m360-toolbar,
        .dark .m360-kpi-card,
        .dark .m360-tabs-container,
        .dark .m360-sede-card,
        .dark .m360-modal-box {
            background-color: #111827;
            border-color: #1f2937;
            color: #f9fafb;
        }
        .dark .m360-tab-nav,
        .dark .m360-table th,
        .dark .m360-stats-box {
            background-color: #1f2937;
            border-color: #374151;
        }
        .dark .m360-kpi-value,
        .dark .m360-table td {
            color: #f9fafb;
            border-color: #1f2937;
        }
        .dark .m360-select,
        .dark .m360-search-input {
            background-color: #1f2937;
            border-color: #374151;
            color: #ffffff;
        }
        .dark .m360-table tr:hover td {
            background-color: #1f2937;
        }
    </style>

    <div class="m360-container">

        {{-- ── 1. BARRA SUPERIOR DE FILTROS & CONTROL ───────────────────────────── --}}
        <div class="m360-toolbar">

            <div class="m360-filter-group">

                {{-- Selector de Campaña 360° --}}
                <div class="m360-input-box">
                    <label class="m360-label">Campaña 360°</label>
                    <select wire:model.live="campaign_id" class="m360-select">
                        @forelse($campaigns as $camp)
                            <option value="{{ $camp->id }}">
                                [{{ $camp->status }}] {{ $camp->name }}
                            </option>
                        @empty
                            <option value="">No hay campañas 360° disponibles</option>
                        @endforelse
                    </select>
                </div>

                {{-- Selector de Central / Sede --}}
                <div class="m360-input-box">
                    <label class="m360-label">Central / Sede</label>
                    <select wire:model.live="sede_id" @if(!$isCorpOrAdmin) disabled @endif class="m360-select">
                        @if($isCorpOrAdmin)
                            <option value="">🌐 Todas las Centrales (Global)</option>
                        @endif
                        @foreach($sedes as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- Badges de Estado y Vigencia --}}
            @if($selectedCampaign)
                <div class="m360-badge-group">
                    {{-- Badge Estatus Campaña --}}
                    @php
                        $statusClass = match($selectedCampaign->status) {
                            'Activa'     => 'm360-pill-success',
                            'Programada' => 'm360-pill-info',
                            'Concluida'  => 'm360-pill-gray',
                            'Suspendida' => 'm360-pill-warning',
                            'Cancelada'  => 'm360-pill-danger',
                            default      => 'm360-pill-gray',
                        };
                    @endphp
                    <span class="m360-pill {{ $statusClass }}">
                        ● {{ $selectedCampaign->status }}
                    </span>

                    {{-- Contador de Días / Vigencia --}}
                    @if($selectedCampaign->status === 'Activa')
                        @if($isCampaignEnded)
                            <span class="m360-pill m360-pill-danger">
                                ⚠️ Vencida hace {{ abs($daysRemaining) }} días
                            </span>
                        @else
                            <span class="m360-pill {{ $daysRemaining <= 3 ? 'm360-pill-danger' : ($daysRemaining <= 7 ? 'm360-pill-warning' : 'm360-pill-success') }}">
                                ⏳ {{ $daysRemaining === 0 ? '¡Vence hoy!' : $daysRemaining . ' días restantes' }}
                            </span>
                        @endif
                    @elseif($selectedCampaign->status === 'Concluida')
                        <span class="m360-pill m360-pill-gray">
                            ✓ Periodo Concluido
                        </span>
                    @endif

                    {{-- Botón Quitar Filtro Sede si está activo --}}
                    @if($isCorpOrAdmin && $sede_id)
                        <button
                            wire:click="clearSedeFilter"
                            type="button"
                            class="m360-pill m360-pill-warning"
                            style="cursor: pointer; border: none;"
                        >
                            ✕ Ver Todas
                        </button>
                    @endif
                </div>
            @endif

        </div>

        @if(!$selectedCampaign)
            {{-- Estado Vacío --}}
            <div style="background-color: #fff; border: 2px dashed #d1d5db; border-radius: 0.75rem; padding: 3rem; text-align: center;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #374151;">No hay campañas seleccionadas</h3>
                <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;">Selecciona una campaña 360° en el filtro superior para visualizar el avance.</p>
            </div>
        @else

            {{-- ── 2. TARJETAS DE MÉTRICAS GLOBALES (KPIs EN 4 COLUMNAS) ────────────── --}}
            <div class="m360-kpi-grid">

                {{-- Card 1: Avance Global --}}
                <div class="m360-kpi-card">
                    <div>
                        <div class="m360-kpi-header">
                            <span class="m360-kpi-title">Avance Global</span>
                            <div class="m360-kpi-icon" style="background-color: #fef3c7; color: #d97706;">
                                📊
                            </div>
                        </div>
                        <div class="m360-kpi-value" style="color: #d97706;">
                            {{ $metrics['porcentaje_avance'] ?? 0 }}%
                        </div>
                    </div>
                    <div>
                        @php
                            $pct = $metrics['porcentaje_avance'] ?? 0;
                            $barClass = $pct >= 80 ? 'bg-progress-emerald' : ($pct >= 50 ? 'bg-progress-amber' : 'bg-progress-rose');
                        @endphp
                        <div class="m360-progress-track">
                            <div class="m360-progress-bar {{ $barClass }}" style="width: {{ min(100, $pct) }}%;"></div>
                        </div>
                        <div class="m360-kpi-footer">
                            <strong>{{ $metrics['total_contestadas'] ?? 0 }}</strong> de {{ $metrics['total_asignadas'] ?? 0 }} evaluaciones contestadas
                        </div>
                    </div>
                </div>

                {{-- Card 2: Evaluadores Completados --}}
                <div class="m360-kpi-card">
                    <div>
                        <div class="m360-kpi-header">
                            <span class="m360-kpi-title">Evaluadores al 100%</span>
                            <div class="m360-kpi-icon" style="background-color: #d1fae5; color: #059669;">
                                ✅
                            </div>
                        </div>
                        <div class="m360-kpi-value" style="color: #059669;">
                            {{ $metrics['evaluadores_completos'] ?? 0 }}
                        </div>
                    </div>
                    <div>
                        @php
                            $totalEv = $metrics['total_evaluadores'] ?? 0;
                            $pctDoneEv = $totalEv > 0 ? round((($metrics['evaluadores_completos'] ?? 0) / $totalEv) * 100, 1) : 0;
                        @endphp
                        <div class="m360-progress-track">
                            <div class="m360-progress-bar bg-progress-emerald" style="width: {{ $pctDoneEv }}%;"></div>
                        </div>
                        <div class="m360-kpi-footer">
                            <strong>{{ $pctDoneEv }}%</strong> del total de {{ $totalEv }} evaluadores
                        </div>
                    </div>
                </div>

                {{-- Card 3: Evaluadores Sin Iniciar --}}
                <div class="m360-kpi-card">
                    <div>
                        <div class="m360-kpi-header">
                            <span class="m360-kpi-title">Evaluadores en Cero</span>
                            <div class="m360-kpi-icon" style="background-color: #fee2e2; color: #dc2626;">
                                ⚠️
                            </div>
                        </div>
                        <div class="m360-kpi-value" style="color: #dc2626;">
                            {{ $metrics['evaluadores_en_cero'] ?? 0 }}
                        </div>
                    </div>
                    <div>
                        <div style="margin-top: 0.75rem; display: flex; align-items: center; gap: 0.35rem;">
                            <span class="m360-pill m360-pill-warning">
                                {{ $metrics['evaluadores_en_proceso'] ?? 0 }} en proceso
                            </span>
                        </div>
                        <div class="m360-kpi-footer">
                            Evaluadores que no han iniciado sus pruebas
                        </div>
                    </div>
                </div>

                {{-- Card 4: Colaboradores con Batería Completa --}}
                <div class="m360-kpi-card">
                    <div>
                        <div class="m360-kpi-header">
                            <span class="m360-kpi-title">Evaluados Listos (100%)</span>
                            <div class="m360-kpi-icon" style="background-color: #e0e7ff; color: #4f46e5;">
                                🎯
                            </div>
                        </div>
                        <div class="m360-kpi-value" style="color: #4f46e5;">
                            {{ $metrics['evaluados_completos'] ?? 0 }}
                        </div>
                    </div>
                    <div>
                        @php
                            $totalEd = $metrics['total_evaluados'] ?? 0;
                            $pctDoneEd = $totalEd > 0 ? round((($metrics['evaluados_completos'] ?? 0) / $totalEd) * 100, 1) : 0;
                        @endphp
                        <div class="m360-progress-track">
                            <div class="m360-progress-bar bg-progress-indigo" style="width: {{ $pctDoneEd }}%;"></div>
                        </div>
                        <div class="m360-kpi-footer">
                            <strong>{{ $metrics['evaluados_completos'] ?? 0 }}</strong> de {{ $totalEd }} listos!
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── 3. CONTENEDOR PRINCIPAL CON PESTAÑAS ──────────────────────────── --}}
            <div class="m360-tabs-container">

                {{-- Navegación de Pestañas --}}
                <div class="m360-tab-nav">

                    {{-- Pestaña 1: Sedes --}}
                    <button wire:click="setTab('sedes')" class="m360-tab-btn {{ $activeTab === 'sedes' ? 'active' : '' }}">
                        🏢 Avance por Central / Sede
                        <span class="m360-tab-count">{{ $sedesProgress->count() ?: $sedes->count() }}</span>
                    </button>

                    {{-- Pestaña 2: Evaluadores --}}
                    <button wire:click="setTab('evaluadores')" class="m360-tab-btn {{ $activeTab === 'evaluadores' ? 'active' : '' }}">
                        👥 Detalle por Evaluador
                        <span class="m360-tab-count">{{ $metrics['total_evaluadores'] ?? 0 }}</span>
                    </button>

                    {{-- Pestaña 3: Evaluados --}}
                    <button wire:click="setTab('evaluados')" class="m360-tab-btn {{ $activeTab === 'evaluados' ? 'active' : '' }}">
                        🎯 Estatus por Evaluado
                        <span class="m360-tab-count">{{ $metrics['total_evaluados'] ?? 0 }}</span>
                    </button>

                </div>

                {{-- ── PESTAÑA 1: AVANCE POR CENTRAL / SEDE ────────────────────────── --}}
                @if($activeTab === 'sedes')
                    <div class="m360-sedes-grid">
                        @forelse($sedesProgress as $item)
                            @php
                                $p = $item['porcentaje_avance'];
                                $sedeBarColor = $p >= 80 ? 'bg-progress-emerald' : ($p >= 50 ? 'bg-progress-amber' : 'bg-progress-rose');
                                $sedePillColor = $p >= 80 ? 'm360-pill-success' : ($p >= 50 ? 'm360-pill-warning' : 'm360-pill-danger');
                            @endphp
                            <div class="m360-sede-card">
                                <div>
                                    <div style="display: flex; align-items: flex-start; justify-content: space-between;">
                                        <div>
                                            <h4 style="font-size: 1.05rem; font-weight: 800; color: #111827; margin: 0;">
                                                {{ $item['sede_name'] }}
                                            </h4>
                                            <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.2rem;">
                                                {{ $item['total_evaluadores'] }} evaluadores · {{ $item['total_evaluados'] }} evaluados
                                            </p>
                                        </div>
                                        <span class="m360-pill {{ $sedePillColor }}">
                                            {{ $p }}%
                                        </span>
                                    </div>

                                    {{-- Barra de Progreso Sede --}}
                                    <div class="m360-progress-track">
                                        <div class="m360-progress-bar {{ $sedeBarColor }}" style="width: {{ min(100, $p) }}%;"></div>
                                    </div>

                                    {{-- Contadores Rápidos --}}
                                    <div class="m360-stats-box">
                                        <div>
                                            <span style="font-size: 0.7rem; color: #6b7280; display: block;">Asignadas</span>
                                            <strong style="font-size: 0.95rem; color: #111827;">{{ $item['total_asignadas'] }}</strong>
                                        </div>
                                        <div>
                                            <span style="font-size: 0.7rem; color: #6b7280; display: block;">Contestadas</span>
                                            <strong style="font-size: 0.95rem; color: #059669;">{{ $item['total_contestadas'] }}</strong>
                                        </div>
                                        <div>
                                            <span style="font-size: 0.7rem; color: #6b7280; display: block;">Pendientes</span>
                                            <strong style="font-size: 0.95rem; color: #dc2626;">{{ $item['total_pendientes'] }}</strong>
                                        </div>
                                    </div>
                                </div>

                                {{-- Botón para ver evaluadores de esta sede --}}
                                @if($isCorpOrAdmin)
                                    <div>
                                        <button
                                            wire:click="filterBySedeAndGoToEvaluators({{ $item['sede_id'] }})"
                                            type="button"
                                            class="m360-btn-outline"
                                        >
                                            🔍 Ver evaluadores de esta central
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div style="grid-column: span 3; text-align: center; padding: 3rem; color: #6b7280;">
                                No hay sedes asociadas a esta campaña.
                            </div>
                        @endforelse
                    </div>
                @endif

                {{-- ── PESTAÑA 2: DETALLE POR EVALUADOR ────────────────────────────── --}}
                @if($activeTab === 'evaluadores')
                    <div>

                        {{-- Controles y Filtros de la Tabla --}}
                        <div class="m360-table-controls">

                            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center;">
                                {{-- Input de Búsqueda --}}
                                <div style="min-width: 240px;">
                                    <input
                                        wire:model.live.debounce.300ms="search"
                                        type="text"
                                        placeholder="🔍 Buscar por nombre o departamento..."
                                        class="m360-search-input"
                                    />
                                </div>

                                {{-- Filtro por Estatus --}}
                                <div class="m360-status-btn-group">
                                    <button wire:click="$set('statusFilter', 'todos')" type="button" class="m360-status-btn {{ $statusFilter === 'todos' ? 'active' : '' }}">
                                        Todos
                                    </button>
                                    <button wire:click="$set('statusFilter', 'sin_iniciar')" type="button" class="m360-status-btn {{ $statusFilter === 'sin_iniciar' ? 'active' : '' }}" style="{{ $statusFilter === 'sin_iniciar' ? 'color: #dc2626;' : '' }}">
                                        🔴 Sin Iniciar
                                    </button>
                                    <button wire:click="$set('statusFilter', 'en_proceso')" type="button" class="m360-status-btn {{ $statusFilter === 'en_proceso' ? 'active' : '' }}" style="{{ $statusFilter === 'en_proceso' ? 'color: #d97706;' : '' }}">
                                        🟡 En Proceso
                                    </button>
                                    <button wire:click="$set('statusFilter', 'completado')" type="button" class="m360-status-btn {{ $statusFilter === 'completado' ? 'active' : '' }}" style="{{ $statusFilter === 'completado' ? 'color: #059669;' : '' }}">
                                        🟢 Completados
                                    </button>
                                </div>
                            </div>

                            {{-- Botón de Recordatorio Masivo --}}
                            <div>
                                <button wire:click="sendBulkNotifications" type="button" class="m360-btn-primary">
                                    🔔 Recordar a todos los pendientes
                                </button>
                            </div>

                        </div>

                        {{-- Tabla de Evaluadores --}}
                        <div class="m360-table-wrapper">
                            <table class="m360-table">
                                <thead>
                                    <tr>
                                        <th>Evaluador</th>
                                        <th>Central / Depto</th>
                                        <th style="text-align: center;">Carga Total</th>
                                        <th style="text-align: center;">Contestadas</th>
                                        <th style="text-align: center;">Pendientes</th>
                                        <th style="min-width: 140px;">Avance %</th>
                                        <th style="text-align: center;">Estatus</th>
                                        <th style="text-align: right;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($evaluatorsProgress as $ev)
                                        @php
                                            $pct = $ev['porcentaje_avance'];
                                            $badgeClass = match($ev['status']) {
                                                'completado' => 'm360-pill-success',
                                                'en_proceso' => 'm360-pill-warning',
                                                'sin_iniciar'=> 'm360-pill-danger',
                                            };
                                            $badgeText = match($ev['status']) {
                                                'completado' => '✓ Completado',
                                                'en_proceso' => '⏳ En Proceso',
                                                'sin_iniciar'=> '⚠️ Sin Iniciar',
                                            };
                                            $barColor = $pct >= 100 ? 'bg-progress-emerald' : ($pct > 0 ? 'bg-progress-amber' : 'bg-progress-rose');
                                        @endphp
                                        <tr>

                                            {{-- Evaluador --}}
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                    <div class="m360-avatar">
                                                        {{ strtoupper(substr($ev['name'], 0, 2)) }}
                                                    </div>
                                                    <div>
                                                        <div style="font-weight: 700; color: #111827;">{{ $ev['name'] }}</div>
                                                        <div style="font-size: 0.75rem; color: #6b7280;">{{ $ev['position'] }}</div>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Sede / Depto --}}
                                            <td>
                                                <div style="font-weight: 600; font-size: 0.8rem; color: #111827;">{{ $ev['sede'] }}</div>
                                                <div style="font-size: 0.75rem; color: #6b7280;">{{ $ev['department'] }}</div>
                                            </td>

                                            {{-- Carga Total --}}
                                            <td style="text-align: center; font-weight: 700; color: #111827;">
                                                {{ $ev['total_asignadas'] }}
                                            </td>

                                            {{-- Contestadas --}}
                                            <td style="text-align: center; font-weight: 700; color: #059669;">
                                                {{ $ev['total_contestadas'] }}
                                            </td>

                                            {{-- Pendientes --}}
                                            <td style="text-align: center; font-weight: 700; color: {{ $ev['total_pendientes'] > 0 ? '#dc2626' : '#9ca3af' }};">
                                                {{ $ev['total_pendientes'] }}
                                            </td>

                                            {{-- Barra de Avance --}}
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                    <div class="m360-progress-track" style="margin: 0;">
                                                        <div class="m360-progress-bar {{ $barColor }}" style="width: {{ $pct }}%;"></div>
                                                    </div>
                                                    <span style="font-size: 0.75rem; font-weight: 700; width: 2.5rem; text-align: right;">{{ $pct }}%</span>
                                                </div>
                                            </td>

                                            {{-- Estatus Pill --}}
                                            <td style="text-align: center;">
                                                <span class="m360-pill {{ $badgeClass }}">
                                                    {{ $badgeText }}
                                                </span>
                                            </td>

                                            {{-- Acciones --}}
                                            <td style="text-align: right;">
                                                <div style="display: inline-flex; align-items: center; gap: 0.35rem;">

                                                    {{-- Ver Desglose Anónimo --}}
                                                    <button
                                                        wire:click="openBreakdownModal({{ $ev['user_id'] }})"
                                                        type="button"
                                                        title="Ver desglose confidencial por roles"
                                                        class="m360-icon-btn"
                                                    >
                                                        👁️
                                                    </button>

                                                    {{-- Notificar Individual --}}
                                                    @if($ev['total_pendientes'] > 0)
                                                        <button
                                                            wire:click="sendNotification({{ $ev['user_id'] }})"
                                                            type="button"
                                                            title="Enviar recordatorio en plataforma"
                                                            class="m360-icon-btn"
                                                            style="color: #d97706; background-color: #fef3c7;"
                                                        >
                                                            🔔
                                                        </button>
                                                    @endif

                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" style="text-align: center; padding: 2.5rem; color: #6b7280;">
                                                No se encontraron evaluadores con los filtros seleccionados.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                @endif

                {{-- ── PESTAÑA 3: ESTATUS POR EVALUADO ────────────────────────────── --}}
                @if($activeTab === 'evaluados')
                    <div>

                        <div style="padding: 1.25rem 1.5rem 0 1.5rem; max-width: 320px;">
                            <input
                                wire:model.live.debounce.300ms="search"
                                type="text"
                                placeholder="🔍 Buscar colaborador evaluado..."
                                class="m360-search-input"
                            />
                        </div>

                        <div class="m360-table-wrapper">
                            <table class="m360-table">
                                <thead>
                                    <tr>
                                        <th>Colaborador Evaluado</th>
                                        <th>Central / Depto</th>
                                        <th style="text-align: center;">Esperadas</th>
                                        <th style="text-align: center;">Recibidas</th>
                                        <th style="text-align: center;">Faltantes</th>
                                        <th style="min-width: 140px;">Avance %</th>
                                        <th style="text-align: center;">Estatus Diagnóstico</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($evaluatedProgress as $ed)
                                        @php
                                            $pct = $ed['porcentaje_avance'];
                                            $barColor = $ed['is_ready'] ? 'bg-progress-emerald' : ($pct > 0 ? 'bg-progress-indigo' : 'bg-progress-amber');
                                        @endphp
                                        <tr>

                                            {{-- Evaluado --}}
                                            <td>
                                                <div style="font-weight: 700; color: #111827;">{{ $ed['name'] }}</div>
                                                <div style="font-size: 0.75rem; color: #6b7280;">{{ $ed['position'] }}</div>
                                            </td>

                                            {{-- Sede / Depto --}}
                                            <td>
                                                <div style="font-weight: 600; font-size: 0.8rem; color: #111827;">{{ $ed['sede'] }}</div>
                                                <div style="font-size: 0.75rem; color: #6b7280;">{{ $ed['department'] }}</div>
                                            </td>

                                            {{-- Esperadas --}}
                                            <td style="text-align: center; font-weight: 700; color: #111827;">
                                                {{ $ed['total_esperadas'] }}
                                            </td>

                                            {{-- Recibidas --}}
                                            <td style="text-align: center; font-weight: 700; color: #059669;">
                                                {{ $ed['total_recibidas'] }}
                                            </td>

                                            {{-- Faltantes --}}
                                            <td style="text-align: center; font-weight: 700; color: {{ $ed['total_faltantes'] > 0 ? '#dc2626' : '#9ca3af' }};">
                                                {{ $ed['total_faltantes'] }}
                                            </td>

                                            {{-- Barra de Avance --}}
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                    <div class="m360-progress-track" style="margin: 0;">
                                                        <div class="m360-progress-bar {{ $barColor }}" style="width: {{ $pct }}%;"></div>
                                                    </div>
                                                    <span style="font-size: 0.75rem; font-weight: 700; width: 2.5rem; text-align: right;">{{ $pct }}%</span>
                                                </div>
                                            </td>

                                            {{-- Estatus Diagnóstico --}}
                                            <td style="text-align: center;">
                                                @if($ed['is_ready'])
                                                    <span class="m360-pill m360-pill-success">
                                                        ✓ Batería Completa (Listo)
                                                    </span>
                                                @else
                                                    <span class="m360-pill m360-pill-warning">
                                                        ⏳ Faltan {{ $ed['total_faltantes'] }} {{ $ed['total_faltantes'] === 1 ? 'evaluación' : 'evaluaciones' }}
                                                    </span>
                                                @endif
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" style="text-align: center; padding: 2.5rem; color: #6b7280;">
                                                No hay colaboradores evaluados para mostrar.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                @endif

            </div>

        @endif

    </div>

    {{-- ── MODAL FLOTANTE: DESGLOSE ANÓNIMO POR ROLES ────────────────────────── --}}
    {{-- SECRECÍA TOTAL: Muestra avances cuantitativos por rol SIN revelar nombres de los evaluados --}}
    @if($showBreakdownModal && $selectedEvaluator)
        <div class="m360-modal-overlay">
            <div class="m360-modal-box">

                {{-- Encabezado Modal --}}
                <div style="display: flex; align-items: flex-start; justify-content: space-between; border-bottom: 1px solid #e5e7eb; padding-bottom: 0.75rem;">
                    <div>
                        <span class="m360-pill m360-pill-warning" style="margin-bottom: 0.25rem;">
                            🔒 Resumen Confidencial
                        </span>
                        <h3 style="font-size: 1.15rem; font-weight: 800; color: #111827; margin: 0.35rem 0 0 0;">
                            {{ $selectedEvaluator['name'] }}
                        </h3>
                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0.15rem 0 0 0;">
                            {{ $selectedEvaluator['position'] }} · {{ $selectedEvaluator['sede'] }}
                        </p>
                    </div>
                    <button
                        wire:click="closeBreakdownModal"
                        type="button"
                        style="background: none; border: none; font-size: 1.25rem; color: #9ca3af; cursor: pointer;"
                    >
                        ✕
                    </button>
                </div>

                {{-- Aviso de Secrecía --}}
                <div class="m360-secret-banner">
                    <span>🔒</span>
                    <span>Por política de confidencialidad de la metodología 360°, este reporte desglosa el cumplimiento numérico por tipo de relación sin exponer los nombres de las personas evaluadas.</span>
                </div>

                {{-- Desglose por Roles --}}
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @foreach($selectedEvaluator['roles_breakdown'] as $roleKey => $roleData)
                        @if($roleData['total'] > 0)
                            @php
                                $isAllDone = $roleData['done'] === $roleData['total'];
                                $rolePct = round(($roleData['done'] / $roleData['total']) * 100);
                            @endphp
                            <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 0.75rem; background-color: #fafafa;">
                                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.85rem; font-weight: 700; color: #374151;">
                                    <span>
                                        {{ $isAllDone ? '🟢' : '🟡' }} {{ $roleData['label'] }}
                                    </span>
                                    <span style="font-size: 0.75rem; color: {{ $isAllDone ? '#059669' : '#d97706' }};">
                                        {{ $roleData['done'] }} de {{ $roleData['total'] }} completadas
                                    </span>
                                </div>
                                <div class="m360-progress-track" style="margin-top: 0.5rem;">
                                    <div class="m360-progress-bar {{ $isAllDone ? 'bg-progress-emerald' : 'bg-progress-amber' }}" style="width: {{ $rolePct }}%;"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Pie del Modal --}}
                <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #e5e7eb; padding-top: 0.75rem;">
                    <div>
                        @if($selectedEvaluator['total_pendientes'] > 0)
                            <button
                                wire:click="sendNotification({{ $selectedEvaluator['user_id'] }})"
                                type="button"
                                class="m360-btn-primary"
                                style="font-size: 0.75rem; padding: 0.45rem 0.85rem;"
                            >
                                🔔 Notificar en Plataforma
                            </button>
                        @endif
                    </div>
                    <button
                        wire:click="closeBreakdownModal"
                        type="button"
                        style="padding: 0.45rem 1rem; font-size: 0.75rem; font-weight: 700; background-color: #f3f4f6; color: #374151; border: none; border-radius: 0.5rem; cursor: pointer;"
                    >
                        Cerrar
                    </button>
                </div>

            </div>
        </div>
    @endif

</x-filament-panels::page>
