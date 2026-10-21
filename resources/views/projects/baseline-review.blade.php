@extends('layouts.app', ['title' => 'Peninjauan dan Persetujuan Baseline Proyek | PT Anaheim Nimbus Universal'])

@section('content')
    <!-- QA & DEMO STATUS SIMULATOR BAR -->
    <div class="bg-[#eaf2ff] border border-[#cfe0ff] rounded-xl px-4 sm:px-5 py-3.5 mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-3">
        <div class="flex items-center justify-center lg:justify-start gap-2 text-[11px] font-bold tracking-wider text-[#334155] uppercase text-center lg:text-left">
            <svg class="w-3.5 h-3.5 text-nimbus-primary shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 2v7.31"/><path d="M14 9.3V1.99"/><path d="M8.5 2h7"/><path d="M14 9.3a6.5 6.5 0 1 1-4 0"/><path d="M5.52 16h12.96"/>
            </svg>
            <span>SIMULATOR STATUS PENGUJIAN (QA &amp; DEMO)</span>
        </div>

        <div class="w-full lg:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-1.5 bg-white p-1.5 rounded-lg border border-[#dbeafe]">
            <!-- Mode 1 -->
            <button type="button" data-mode="1" class="qa-mode-btn w-full sm:flex-1 lg:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-2 sm:py-1.5 rounded-md bg-nimbus-primary text-white text-[11.5px] font-semibold transition-all">
                <span class="qa-mode-dot w-2 h-2 rounded-full bg-white shrink-0" data-dot-color="bg-emerald-500"></span>
                <span>Mode 1: Draf Lengkap</span>
            </button>

            <!-- Mode 2 -->
            <button type="button" data-mode="2" class="qa-mode-btn w-full sm:flex-1 lg:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-2 sm:py-1.5 rounded-md bg-white hover:bg-slate-50 text-nimbus-ink text-[11.5px] font-semibold transition-all">
                <span class="qa-mode-dot w-2 h-2 rounded-full bg-red-600 shrink-0" data-dot-color="bg-red-600"></span>
                <span>Mode 2: Baseline Belum Lengkap</span>
            </button>

            <!-- Mode 3 -->
            <button type="button" data-mode="3" class="qa-mode-btn w-full sm:flex-1 lg:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-2 sm:py-1.5 rounded-md bg-white hover:bg-slate-50 text-nimbus-ink text-[11.5px] font-semibold transition-all">
                <span class="qa-mode-dot w-2 h-2 rounded-full bg-[#0f5275] shrink-0" data-dot-color="bg-[#0f5275]"></span>
                <span>Mode 3: Baseline Telah Disetujui</span>
            </button>
        </div>
    </div>

    <!-- PAGE HEADER & EXPORT BUTTONS -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-[20px] sm:text-[23px] lg:text-[25px] font-display font-extrabold text-nimbus-ink tracking-tight">
                Peninjauan dan Persetujuan Baseline Proyek
            </h1>
            <p class="text-[13px] sm:text-[13.5px] text-nimbus-slate leading-relaxed mt-1.5">
                Evaluasi kelengkapan tiga matriks kerja (Scope, Deliverables, Timeline) dan pengesahan formal sebelum penentuan tanggal rencana operasional.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 shrink-0">
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-[#e8f0fe] hover:bg-[#dbeafe] text-nimbus-ink text-[11.5px] font-bold transition-colors">
                <svg class="w-3.5 h-3.5 text-nimbus-slate" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 6 2 18 2 18 9"/>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                    <rect x="6" y="14" width="12" height="8"/>
                </svg>
                <span>Cetak Dokumen</span>
            </button>

            <button type="button" id="btnExportJson" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-[#e8f0fe] hover:bg-[#dbeafe] text-nimbus-ink text-[11.5px] font-bold transition-colors">
                <svg class="w-3.5 h-3.5 text-nimbus-slate" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                <span>Ekspor JSON/PDF</span>
            </button>
        </div>
    </div>

    <!-- TOP 4 SUMMARY METRIC CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3.5 sm:gap-4 mt-5 sm:mt-6">
        <!-- 1. Versi & Dibuat -->
        <div class="bg-white border border-nimbus-border rounded-xl p-4 shadow-card flex flex-col justify-between min-h-[112px]">
            <div class="flex items-center justify-between">
                <span class="text-[10.5px] font-bold tracking-wider text-nimbus-muted uppercase">VERSI &amp; DIBUAT</span>
                <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                    <path d="M3 3v5h5"/><path d="M12 7v5l4 2"/>
                </svg>
            </div>
            <div class="mt-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-[#e8f0fe] text-nimbus-ink font-display font-extrabold text-[14px]">
                    v1.0
                </span>
            </div>
            <div class="font-mono text-[11px] text-nimbus-slate mt-2.5">
                2026-10-08 14:15:00 WIB
            </div>
        </div>

        <!-- 2. Status Dokumen -->
        <div class="bg-white border border-nimbus-border rounded-xl p-4 shadow-card flex flex-col justify-between min-h-[112px]">
            <div class="flex items-center justify-between">
                <span class="text-[10.5px] font-bold tracking-wider text-nimbus-muted uppercase">STATUS DOKUMEN</span>
                <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <path d="m9 12 2 2 4-4"/>
                </svg>
            </div>
            <div class="mt-2" id="docStatusBadgeWrap">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#e0e7ff] text-[#3730a3] text-[11px] font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#4338ca]"></span>
                    <span>Draf Baseline</span>
                </span>
            </div>
            <div id="docStatusSub" class="text-[11.5px] text-nimbus-slate mt-2.5">
                Belum difinalisasi
            </div>
        </div>

        <!-- 3. Kelengkapan Matriks -->
        <div class="bg-white border border-nimbus-border rounded-xl p-4 shadow-card flex flex-col justify-between min-h-[112px]">
            <div class="flex items-center justify-between">
                <span class="text-[10.5px] font-bold tracking-wider text-nimbus-muted uppercase">KELENGKAPAN MATRIKS</span>
                <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 8 2 2 4-4"/><path d="M13 6h8"/><path d="m3 16 2 2 4-4"/><path d="M13 14h8"/>
                </svg>
            </div>
            <div class="mt-2" id="completenessBadgeWrap">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#e0ebff] text-nimbus-primary text-[11px] font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-nimbus-primary"></span>
                    <span>Lengkap (3/3 Matriks)</span>
                </span>
            </div>
            <div id="completenessSub" class="text-[11.5px] text-nimbus-slate mt-2.5">
                Scope, Deliverables, Timeline
            </div>
        </div>

        <!-- 4. Penanggung Jawab Otoritas -->
        <div class="bg-white border border-nimbus-border rounded-xl p-4 shadow-card flex flex-col justify-between min-h-[112px]">
            <div class="flex items-center justify-between">
                <span class="text-[10.5px] font-bold tracking-wider text-nimbus-muted uppercase leading-tight">PENANGGUNG JAWAB<br>OTORITAS</span>
                <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <circle cx="9" cy="10" r="2"/>
                    <path d="M15 8h2"/><path d="M15 12h2"/><path d="M7 16h10"/>
                </svg>
            </div>
            <div class="text-[14.5px] font-display font-bold text-nimbus-ink mt-1.5">
                Project Manager
            </div>
            <div class="text-[11.5px] text-nimbus-muted mt-1">
                Project Manager
            </div>
        </div>
    </div>

    <!-- MAIN GRID (LEFT 8 COLS, RIGHT 4 COLS) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mt-5 items-stretch">
        <!-- LEFT COLUMN (8 COLS) -->
        <div class="lg:col-span-8 flex flex-col gap-5">
            @php
                $reviewScopeRows = $state['baseline']['matrices']['scope'] ?? [];
                $reviewDeliverableRows = $state['baseline']['matrices']['deliverable'] ?? [];
                $reviewTimelineRows = $state['baseline']['matrices']['timeline'] ?? [];
            @endphp

            <!-- Matrices Table Card -->
            <section class="bg-white border border-nimbus-border rounded-xl shadow-card overflow-hidden">
                <!-- Baris Tab -->
                <div class="px-4 sm:px-5 pt-3 bg-[#f4f7fb] border-b border-nimbus-border flex items-center gap-2 sm:gap-4 overflow-x-auto no-scrollbar">
                    <button type="button" data-review-tab="scope" class="review-tab-btn px-3 sm:px-3.5 py-2.5 rounded-t-lg bg-white border-t border-x border-nimbus-border text-nimbus-primary font-display font-bold text-[12px] inline-flex items-center gap-2 whitespace-nowrap shrink-0 -mb-px">
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"/><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/>
                        </svg>
                        <span>Scope Matrix</span>
                        <span class="px-2 py-0.5 rounded-full bg-[#e8f0fe] text-nimbus-ink text-[10.5px] font-bold">{{ count($reviewScopeRows) }} Modul</span>
                    </button>

                    <button type="button" data-review-tab="deliverable" class="review-tab-btn px-3 py-2.5 text-nimbus-slate hover:text-nimbus-ink font-display font-semibold text-[12px] inline-flex items-center gap-2 whitespace-nowrap shrink-0">
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="16" rx="2"/><line x1="7" y1="9" x2="17" y2="9"/><line x1="7" y1="13" x2="13" y2="13"/>
                        </svg>
                        <span>Deliverable Matrix</span>
                        <span class="px-2 py-0.5 rounded-full bg-[#e8eef7] text-nimbus-slate text-[10.5px] font-bold">{{ count($reviewDeliverableRows) }} Artefak</span>
                    </button>

                    <button type="button" data-review-tab="timeline" class="review-tab-btn px-3 py-2.5 text-nimbus-slate hover:text-nimbus-ink font-display font-semibold text-[12px] inline-flex items-center gap-2 whitespace-nowrap shrink-0">
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <span>Timeline Matrix</span>
                        <span class="px-2 py-0.5 rounded-full bg-[#e8eef7] text-nimbus-slate text-[10.5px] font-bold">{{ count($reviewTimelineRows) }} Fase</span>
                    </button>
                </div>

                <!-- Isi Tabel Cakupan (Scope) -->
                <div id="review-panel-scope" class="review-tab-panel p-4 sm:p-6">
                    <h2 class="text-[14.5px] font-display font-bold text-nimbus-ink">
                        Cakupan Modul Inti &amp; Arsitektur
                    </h2>
                    <p class="text-[12px] text-nimbus-muted mt-0.5">
                        Spesifikasi batas operasional sistem terpadu Nimbus Core.
                    </p>

                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full min-w-[640px] border-collapse">
                            <thead>
                                <tr class="bg-[#e3edff] text-left text-[10px] font-bold tracking-wider text-[#1e293b] uppercase">
                                    <th class="py-3 px-4 rounded-l-lg w-[185px]">KODE &amp; MODUL</th>
                                    <th class="py-3 px-4">DESKRIPSI FUNGSIONAL</th>
                                    <th class="py-3 px-4 w-[145px] text-center">PIC</th>
                                    <th class="py-3 px-4 rounded-r-lg w-[150px] text-center">TINGKAT<br>KOMPLEKSITAS</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#eef2f7] text-[12.5px]">
                                @foreach($reviewScopeRows as $row)
                                <tr>
                                    <td class="py-3.5 px-4 align-middle">
                                        <div class="font-display font-bold text-nimbus-ink leading-snug">{{ $row['moduleTitle'] ?? $row['module'] }}</div>
                                        <div class="font-mono text-[11px] text-nimbus-muted mt-0.5">{{ $row['code'] ?? 'MOD-CORE' }}</div>
                                    </td>
                                    <td class="py-3.5 px-4 text-nimbus-slate leading-relaxed">
                                        {{ $row['reviewDescription'] ?? $row['description'] }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center font-semibold text-nimbus-ink">
                                        {{ $row['picRole'] }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        @if(($row['complexity'] ?? 'High') === 'High')
                                            <span class="inline-flex items-center justify-center px-4 py-1 rounded-full bg-[#fbd5d5] text-[#b91c1c] text-[11px] font-bold">
                                                High
                                            </span>
                                        @elseif(($row['complexity'] ?? '') === 'Medium-High')
                                            <span class="inline-flex items-center justify-center px-3.5 py-1 rounded-full bg-[#e0e7ff] text-[#3730a3] text-[11px] font-bold">
                                                Medium-High
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center px-3.5 py-1 rounded-full bg-[#d1fae5] text-[#047857] text-[11px] font-bold">
                                                {{ $row['complexity'] ?? 'Medium' }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Isi Tabel Deliverable -->
                <div id="review-panel-deliverable" class="review-tab-panel hidden p-4 sm:p-6">
                    <h2 class="text-[14.5px] font-display font-bold text-nimbus-ink">
                        Daftar Artefak Serah Terima (Deliverables)
                    </h2>
                    <p class="text-[12px] text-nimbus-muted mt-0.5">
                        Artefak teknis dan dokumen pengujian per modul.
                    </p>
                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full min-w-[640px] border-collapse">
                            <thead>
                                <tr class="bg-[#e3edff] text-left text-[10px] font-bold tracking-wider text-[#1e293b] uppercase">
                                    <th class="py-3 px-4 rounded-l-lg w-[185px]">KODE &amp; MODUL</th>
                                    <th class="py-3 px-4">SPESIFIKASI ARTEFAK</th>
                                    <th class="py-3 px-4 w-[145px] text-center">PIC</th>
                                    <th class="py-3 px-4 rounded-r-lg w-[150px] text-center">KOMPLEKSITAS</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#eef2f7] text-[12.5px]">
                                @foreach($reviewDeliverableRows as $row)
                                <tr>
                                    <td class="py-3.5 px-4 align-middle">
                                        <div class="font-display font-bold text-nimbus-ink leading-snug">{{ $row['module'] }}</div>
                                        <div class="font-mono text-[11px] text-nimbus-muted mt-0.5">{{ $row['code'] ?? 'DEL-CORE' }}</div>
                                    </td>
                                    <td class="py-3.5 px-4 text-nimbus-slate leading-relaxed">{{ $row['description'] }}</td>
                                    <td class="py-3.5 px-4 text-center font-semibold text-nimbus-ink">{{ $row['picRole'] }}</td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-flex items-center justify-center px-3.5 py-1 rounded-full bg-[#e0e7ff] text-[#3730a3] text-[11px] font-bold">
                                            {{ $row['complexity'] ?? 'Medium-High' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Isi Tabel Timeline -->
                <div id="review-panel-timeline" class="review-tab-panel hidden p-4 sm:p-6">
                    <h2 class="text-[14.5px] font-display font-bold text-nimbus-ink">
                        Linimasa Eksekusi Baseline (Timeline)
                    </h2>
                    <p class="text-[12px] text-nimbus-muted mt-0.5">
                        Jadwal mulai dan selesai setiap modul kerja.
                    </p>
                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full min-w-[640px] border-collapse">
                            <thead>
                                <tr class="bg-[#e3edff] text-left text-[10px] font-bold tracking-wider text-[#1e293b] uppercase">
                                    <th class="py-3 px-4 rounded-l-lg w-[185px]">KODE &amp; MODUL</th>
                                    <th class="py-3 px-4">JADWAL PELAKSANAAN</th>
                                    <th class="py-3 px-4 w-[145px] text-center">PIC</th>
                                    <th class="py-3 px-4 rounded-r-lg w-[150px] text-center">FASE</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#eef2f7] text-[12.5px]">
                                @foreach($reviewTimelineRows as $row)
                                <tr>
                                    <td class="py-3.5 px-4 align-middle">
                                        <div class="font-display font-bold text-nimbus-ink leading-snug">{{ $row['module'] }}</div>
                                        <div class="font-mono text-[11px] text-nimbus-muted mt-0.5">{{ $row['code'] ?? 'TML-CORE' }}</div>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-nimbus-slate leading-relaxed">{{ $row['description'] }}</td>
                                    <td class="py-3.5 px-4 text-center font-semibold text-nimbus-ink">{{ $row['picRole'] }}</td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-flex items-center justify-center px-3.5 py-1 rounded-full bg-[#e8f0fe] text-nimbus-primary text-[11px] font-bold">
                                            {{ $row['complexity'] ?? 'Fase 1' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Kartu Distribusi Beban Kerja Baseline -->
            <section class="bg-white border border-nimbus-border rounded-xl p-5 shadow-card">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-nimbus-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                        </svg>
                        <h3 class="text-[13.5px] font-display font-bold text-nimbus-ink">
                            Distribusi Beban Kerja Baseline
                        </h3>
                    </div>
                    <span class="font-mono text-[11.5px] text-nimbus-slate">Total: 30 Hari Kerja</span>
                </div>

                <!-- Segmented Bar -->
                <div class="mt-3.5 h-3 w-full rounded-full overflow-hidden flex">
                    <div class="w-1/3 bg-[#1546c8]"></div>
                    <div class="w-1/3 bg-[#094e6b]"></div>
                    <div class="w-1/3 bg-[#525b6c]"></div>
                </div>

                <!-- 3 Fase Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4">
                    <div class="bg-[#f4f7fb] border border-[#e6ecf5] rounded-lg py-3 px-4 text-center">
                        <div class="inline-flex items-center gap-1.5 text-[11.5px] font-bold text-nimbus-ink">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#1546c8]"></span>
                            <span>Fase Arsitektur</span>
                        </div>
                        <div class="font-mono text-[11.5px] text-nimbus-slate mt-1">33.3% (10 Hari)</div>
                    </div>

                    <div class="bg-[#f4f7fb] border border-[#e6ecf5] rounded-lg py-3 px-4 text-center">
                        <div class="inline-flex items-center gap-1.5 text-[11.5px] font-bold text-nimbus-ink">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#094e6b]"></span>
                            <span>Fase Core Ledger</span>
                        </div>
                        <div class="font-mono text-[11.5px] text-nimbus-slate mt-1">33.3% (10 Hari)</div>
                    </div>

                    <div class="bg-[#f4f7fb] border border-[#e6ecf5] rounded-lg py-3 px-4 text-center">
                        <div class="inline-flex items-center gap-1.5 text-[11.5px] font-bold text-nimbus-ink">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#525b6c]"></span>
                            <span>Fase Audit &amp; Final</span>
                        </div>
                        <div class="font-mono text-[11.5px] text-nimbus-slate mt-1">33.4% (10 Hari)</div>
                    </div>
                </div>
            </section>
        </div>

        <!-- RIGHT COLUMN (4 COLS): APPROVAL HISTORY -->
        <aside class="lg:col-span-4 bg-white border border-nimbus-border rounded-xl p-5 shadow-card flex flex-col">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-nimbus-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="3" width="16" height="18" rx="2"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    <h2 class="text-[14.5px] font-display font-bold text-nimbus-ink">
                        Riwayat Persetujuan
                    </h2>
                </div>
                <span class="font-mono text-[10.5px] font-bold tracking-wider text-nimbus-muted uppercase">AUDIT-LOG</span>
            </div>

            <div id="approvalHistoryPanel" class="mt-5 flex-1 bg-[#f0f4fa] border border-[#e2e8f0] rounded-xl p-6 flex flex-col items-center justify-center text-center">
                <!-- Ikon Clipboard Jam SVG -->
                <div class="w-12 h-12 rounded-xl bg-[#e2e8f0]/70 text-[#64748b] flex items-center justify-center">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                        <circle cx="12" cy="14" r="4"/>
                        <path d="M12 12v2l1 1"/>
                    </svg>
                </div>

                <h3 class="text-[14px] font-display font-bold text-nimbus-ink mt-4">
                    Belum Ada Persetujuan
                </h3>
                <p class="text-[11.5px] text-nimbus-slate leading-relaxed mt-1.5 max-w-[260px]">
                    Baseline saat ini berada dalam tahap pratinjau draf internal. Menunggu tindakan otorisasi oleh Project Manager.
                </p>

                <div class="mt-5 w-full bg-white border border-[#e2e8f0] rounded-lg px-4 py-2.5 flex items-center justify-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-[#334155] shrink-0"></span>
                    <span class="font-mono text-[11px] font-medium text-nimbus-ink leading-snug">
                        Status Sesi: Menunggu Konfirmasi
                    </span>
                </div>
            </div>
        </aside>
    </div>

    <!-- BOTTOM ACTION FOOTER -->
    <section class="bg-white border border-nimbus-border rounded-xl px-4 sm:px-6 py-4 mt-5 shadow-card flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <a href="{{ route('projects.baseline-setup') }}" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[#e8eef7] hover:bg-[#dbeafe] text-nimbus-ink text-[12px] font-bold transition-colors">
            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
            <span>Kembali ke Penyusunan Baseline</span>
        </a>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3">
            <button type="button" id="btnApproveBaseline" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-nimbus-primary hover:bg-nimbus-primaryHover text-white text-[12.5px] font-bold shadow-xs transition-all">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span>Setujui Baseline</span>
            </button>

            <a id="btnNextProjectPlan" href="{{ route('projects.planned-date') }}" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[#e8eef7] text-[#64748b] text-[12.5px] font-bold transition-all">
                <span>Lanjut ke Project Plan</span>
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    (function () {
        const modeBtns = document.querySelectorAll('.qa-mode-btn');
        const docStatusBadgeWrap = document.getElementById('docStatusBadgeWrap');
        const docStatusSub = document.getElementById('docStatusSub');
        const completenessBadgeWrap = document.getElementById('completenessBadgeWrap');
        const completenessSub = document.getElementById('completenessSub');
        const approvalHistoryPanel = document.getElementById('approvalHistoryPanel');
        const btnApprove = document.getElementById('btnApproveBaseline');
        const btnNext = document.getElementById('btnNextProjectPlan');

        function applyMode(mode) {
            modeBtns.forEach((b) => {
                const isActive = b.getAttribute('data-mode') === String(mode);
                const dot = b.querySelector('.qa-mode-dot');
                const inactiveDotColor = dot ? dot.getAttribute('data-dot-color') : 'bg-nimbus-primary';
                if (isActive) {
                    b.className = 'qa-mode-btn w-full sm:flex-1 lg:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-2 sm:py-1.5 rounded-md bg-nimbus-primary text-white text-[11.5px] font-semibold transition-all';
                    if (dot) dot.className = 'qa-mode-dot w-2 h-2 rounded-full bg-white shrink-0';
                } else {
                    b.className = 'qa-mode-btn w-full sm:flex-1 lg:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-2 sm:py-1.5 rounded-md bg-white hover:bg-slate-50 text-nimbus-ink text-[11.5px] font-semibold transition-all';
                    if (dot) dot.className = `qa-mode-dot w-2 h-2 rounded-full ${inactiveDotColor} shrink-0`;
                }
            });

            if (mode === 1) {
                docStatusBadgeWrap.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#e0e7ff] text-[#3730a3] text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-[#4338ca]"></span><span>Draf Baseline</span></span>`;
                docStatusSub.textContent = 'Belum difinalisasi';
                completenessBadgeWrap.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#e0ebff] text-nimbus-primary text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-nimbus-primary"></span><span>Lengkap (3/3 Matriks)</span></span>`;
                completenessSub.textContent = 'Scope, Deliverables, Timeline';

                approvalHistoryPanel.innerHTML = `
                    <div class="w-12 h-12 rounded-xl bg-[#e2e8f0]/70 text-[#64748b] flex items-center justify-center">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                            <circle cx="12" cy="14" r="4"/><path d="M12 12v2l1 1"/>
                        </svg>
                    </div>
                    <h3 class="text-[14px] font-display font-bold text-nimbus-ink mt-4">Belum Ada Persetujuan</h3>
                    <p class="text-[11.5px] text-nimbus-slate leading-relaxed mt-1.5 max-w-[260px]">
                        Baseline saat ini berada dalam tahap pratinjau draf internal. Menunggu tindakan otorisasi oleh Project Manager.
                    </p>
                    <div class="mt-5 w-full bg-white border border-[#e2e8f0] rounded-lg px-4 py-2.5 flex items-center justify-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-[#334155] shrink-0"></span>
                        <span class="font-mono text-[11px] font-medium text-nimbus-ink leading-snug">Status Sesi: Menunggu Konfirmasi</span>
                    </div>
                `;
                btnApprove.disabled = false;
                btnApprove.className = 'w-full sm:w-auto justify-center inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-nimbus-primary hover:bg-nimbus-primaryHover text-white text-[12.5px] font-bold shadow-xs transition-all';
                btnNext.className = 'w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[#e8eef7] text-[#64748b] text-[12.5px] font-bold transition-all';
            } else if (mode === 2) {
                docStatusBadgeWrap.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#fef3c7] text-[#b45309] text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-[#d97706]"></span><span>Draf Belum Lengkap</span></span>`;
                docStatusSub.textContent = 'Menunggu kelengkapan matriks';
                completenessBadgeWrap.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#fee2e2] text-[#dc2626] text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-[#dc2626]"></span><span>Belum Lengkap (2/3 Matriks)</span></span>`;
                completenessSub.textContent = 'Timeline Matrix belum diisi';

                approvalHistoryPanel.innerHTML = `
                    <div class="w-12 h-12 rounded-xl bg-[#fee2e2] text-[#dc2626] flex items-center justify-center">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <h3 class="text-[14px] font-display font-bold text-nimbus-ink mt-4">Baseline Belum Lengkap</h3>
                    <p class="text-[11.5px] text-nimbus-slate leading-relaxed mt-1.5 max-w-[260px]">
                        Persetujuan tidak dapat dilakukan karena Timeline Matrix belum diisi.
                    </p>
                    <div class="mt-5 w-full bg-white border border-[#fecaca] rounded-lg px-4 py-2.5 flex items-center justify-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-red-600 shrink-0"></span>
                        <span class="font-mono text-[11px] font-medium text-red-700 leading-snug">Otorisasi Dikunci</span>
                    </div>
                `;
                btnApprove.disabled = true;
                btnApprove.className = 'w-full sm:w-auto justify-center inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-slate-200 text-slate-400 cursor-not-allowed text-[12.5px] font-bold transition-all';
            } else if (mode === 3) {
                docStatusBadgeWrap.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#d1fae5] text-[#047857] text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-[#059669]"></span><span>Disetujui (APPROVED)</span></span>`;
                docStatusSub.textContent = 'Acuan resmi terkunci';
                completenessBadgeWrap.innerHTML = `<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#e0ebff] text-nimbus-primary text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-nimbus-primary"></span><span>Lengkap (3/3 Matriks)</span></span>`;
                completenessSub.textContent = 'Scope, Deliverables, Timeline';

                approvalHistoryPanel.innerHTML = `
                    <div class="w-12 h-12 rounded-xl bg-[#d1fae5] text-[#059669] flex items-center justify-center">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-[14px] font-display font-bold text-nimbus-ink mt-4">Baseline Disetujui</h3>
                    <p class="text-[11.5px] text-nimbus-slate leading-relaxed mt-1.5 max-w-[260px]">
                        Baseline v1.0 disetujui oleh <strong>Project Manager (01924b1e-7f32-7c40-8a01-9c0010100101)</strong> pada <span class="font-mono">2026-10-14 10:00:00 WIB</span>.
                    </p>
                    <div class="mt-5 w-full bg-white border border-[#a7f3d0] rounded-lg px-4 py-2.5 flex items-center justify-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-[#059669] shrink-0"></span>
                        <span class="font-mono text-[11px] font-semibold text-[#047857] leading-snug">Status Sesi: Terotorisasi Resmi</span>
                    </div>
                `;
                btnApprove.disabled = true;
                btnApprove.className = 'w-full sm:w-auto justify-center inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-slate-200 text-slate-500 cursor-not-allowed text-[12.5px] font-bold transition-all';
                btnNext.className = 'w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-nimbus-primary hover:bg-nimbus-primaryHover text-white text-[12.5px] font-bold shadow-xs transition-all';
            }
        }

        // Review Matrix Tab Switching
        const reviewTabBtns = document.querySelectorAll('.review-tab-btn');
        const reviewPanels = {
            scope: document.getElementById('review-panel-scope'),
            deliverable: document.getElementById('review-panel-deliverable'),
            timeline: document.getElementById('review-panel-timeline'),
        };
        reviewTabBtns.forEach((btn) => {
            btn.addEventListener('click', () => {
                const target = btn.getAttribute('data-review-tab');
                reviewTabBtns.forEach((b) => {
                    if (b.getAttribute('data-review-tab') === target) {
                        b.className = 'review-tab-btn shrink-0 whitespace-nowrap px-3.5 py-2.5 rounded-t-lg bg-white border-t border-x border-nimbus-border text-nimbus-primary font-display font-bold text-[12px] inline-flex items-center gap-2 -mb-px';
                    } else {
                        b.className = 'review-tab-btn shrink-0 whitespace-nowrap px-3 py-2.5 text-nimbus-slate hover:text-nimbus-ink font-display font-semibold text-[12px] inline-flex items-center gap-2';
                    }
                });
                Object.keys(reviewPanels).forEach((k) => {
                    reviewPanels[k]?.classList.toggle('hidden', k !== target);
                });
            });
        });

        modeBtns.forEach((btn) => {
            btn.addEventListener('click', async () => {
                const mode = parseInt(btn.getAttribute('data-mode'), 10);
                const PROJECT_ID = @json($state['project']['projectId'] ?? '01924b1e-7f32-7a81-9b12-45e8a1234567');
                try {
                    await fetch(`/api/v1/projects/${PROJECT_ID}/baselines/simulator-mode`, {
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer mock-token',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ mode }),
                    });
                } catch (e) {}
                applyMode(mode);
            });
        });

        btnApprove.addEventListener('click', async () => {
            const PROJECT_ID = @json($state['project']['projectId'] ?? '01924b1e-7f32-7a81-9b12-45e8a1234567');
            try {
                const res = await fetch(`/api/v1/projects/${PROJECT_ID}/baselines/approve`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer mock-token',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                });
                if (res.ok) {
                    applyMode(3);
                }
            } catch (e) {
                applyMode(3);
            }
        });

        const btnExportJson = document.getElementById('btnExportJson');
        if (btnExportJson) {
            btnExportJson.addEventListener('click', async () => {
                const PROJECT_ID = @json($state['project']['projectId'] ?? '01924b1e-7f32-7a81-9b12-45e8a1234567');
                try {
                    const [planRes, execRes] = await Promise.all([
                        fetch(`/api/v1/projects/${PROJECT_ID}/planning-references`, {
                            headers: { 'Authorization': 'Bearer mock-token', 'Accept': 'application/json' },
                        }),
                        fetch(`/api/v1/projects/${PROJECT_ID}/execution-readiness`, {
                            headers: { 'Authorization': 'Bearer mock-token', 'Accept': 'application/json' },
                        }),
                    ]);
                    const exportData = {
                        planningReferences: await planRes.json(),
                        executionReadiness: await execRes.json(),
                    };
                    const blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `baseline-export-${PROJECT_ID}.json`;
                    a.click();
                    URL.revokeObjectURL(url);
                } catch (e) {}
            });
        }
    })();
</script>
@endpush
