@extends('layouts.app', ['title' => 'Ringkasan Data Tersimpan | PT Anaheim Nimbus Universal'])

@section('content')
    @php
        $project = $state['project'] ?? [];
        $analysis = $state['initialAnalysis'] ?? [];
        $baseline = $state['baseline'] ?? [];
        $plan = $state['projectPlan'] ?? [];
        $analysisSaved = ($analysis['isSaved'] ?? false) === true;
        $val = fn ($v) => ($v === null || $v === '') ? '-' : $v;
        $pretty = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
    @endphp

    <!-- PAGE HEADER -->
    <div>
        <h1 class="text-[25px] font-display font-extrabold text-nimbus-ink tracking-tight">
            Ringkasan Data Tersimpan
        </h1>
        <p class="text-[13.5px] text-nimbus-slate leading-relaxed mt-1.5">
            Halaman baca saja untuk melihat data yang sudah disimpan pada alur analisis awal, baseline, dan tanggal rencana.
            Sumber: state tampilan (storage/app/workflow_state.json); data proyek dari D-1 bila D1_MODE=real.
        </p>
    </div>

    <!-- PROYEK -->
    <section class="bg-white border border-nimbus-border rounded-xl p-6 mt-6 shadow-card">
        <h2 class="text-[15px] font-display font-bold text-nimbus-ink">Proyek</h2>
        @if (! empty($d1))
            @if ($d1['ok'])
                <p class="text-[12px] text-nimbus-slate mt-2">Sumber data proyek: D-1 (GET /api/v1/projects/{projectId}), mode nyata.</p>
            @else
                <p class="text-[12.5px] text-[#b45309] bg-[#fef3c7] border border-[#f59e0b]/60 rounded-lg px-3 py-2 mt-3">
                    Data proyek tidak tersedia dari D-1 ({{ $d1['code'] }}). Analisis awal di bawah tetap ditampilkan dari state E-3.
                </p>
            @endif
        @endif
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mt-4">
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">projectId</dt>
                <dd class="text-[13.5px] text-nimbus-ink font-mono mt-1">{{ $val($project['projectId'] ?? null) }}</dd>
            </div>
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Kode proyek</dt>
                <dd class="text-[13.5px] text-nimbus-ink mt-1">{{ $val($project['canonicalCode'] ?? null) }}</dd>
            </div>
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Nama proyek</dt>
                <dd class="text-[13.5px] text-nimbus-ink mt-1">{{ $val($project['projectName'] ?? null) }}</dd>
            </div>
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Klien</dt>
                <dd class="text-[13.5px] text-nimbus-ink mt-1">{{ $val($project['clientName'] ?? null) }}</dd>
            </div>
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Project Manager</dt>
                <dd class="text-[13.5px] text-nimbus-ink mt-1">{{ $val($project['pmName'] ?? null) }}</dd>
            </div>
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Status proyek</dt>
                <dd class="text-[13.5px] text-nimbus-ink mt-1">{{ $val($project['status'] ?? ($project['intakeStatus'] ?? null)) }}</dd>
            </div>
        </dl>
    </section>

    <!-- ANALISIS AWAL -->
    <section class="bg-white border border-nimbus-border rounded-xl p-6 mt-6 shadow-card">
        <div class="flex items-center justify-between">
            <h2 class="text-[15px] font-display font-bold text-nimbus-ink">Analisis Awal (ENT-K-E3-01)</h2>
            @if ($analysisSaved)
                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-[#d1fae5] border border-[#a7f3d0] text-[#047857] text-[11.5px] font-semibold">Tersimpan</span>
            @else
                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-[#fef3c7] border border-[#f59e0b]/60 text-[#b45309] text-[11.5px] font-semibold">Belum dicatat</span>
            @endif
        </div>

        @if ($analysisSaved)
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mt-4">
                <div class="md:col-span-2">
                    <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Kebutuhan awal</dt>
                    <dd class="text-[13.5px] text-nimbus-ink leading-relaxed mt-1">{{ $val($analysis['projectNeed'] ?? null) }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Kondisi awal</dt>
                    <dd class="text-[13.5px] text-nimbus-ink leading-relaxed mt-1">{{ $val($analysis['projectCondition'] ?? null) }}</dd>
                </div>
                <div>
                    <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">analysisId</dt>
                    <dd class="text-[13.5px] text-nimbus-ink font-mono mt-1">{{ $val($analysis['analysisId'] ?? null) }}</dd>
                </div>
                <div></div>
                <div>
                    <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Dibuat oleh (createdBy)</dt>
                    <dd class="text-[13.5px] text-nimbus-ink font-mono mt-1">{{ $val($analysis['createdBy'] ?? null) }}</dd>
                </div>
                <div>
                    <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Dibuat pada (createdAt)</dt>
                    <dd class="text-[13.5px] text-nimbus-ink font-mono mt-1">{{ $val($analysis['createdAt'] ?? null) }}</dd>
                </div>
                <div>
                    <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Diubah oleh (updatedBy)</dt>
                    <dd class="text-[13.5px] text-nimbus-ink font-mono mt-1">{{ $val($analysis['updatedBy'] ?? null) }}</dd>
                </div>
                <div>
                    <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Diubah pada (updatedAt)</dt>
                    <dd class="text-[13.5px] text-nimbus-ink font-mono mt-1">{{ $val($analysis['updatedAt'] ?? null) }}</dd>
                </div>
            </dl>
        @else
            <p class="text-[13.5px] text-nimbus-slate mt-3">
                Analisis awal belum dicatat.
                <a href="{{ route('projects.initial-analysis') }}" class="text-nimbus-primary font-semibold hover:underline">Isi dan simpan analisis awal</a>.
            </p>
        @endif

        <details class="mt-5">
            <summary class="text-[12.5px] font-semibold text-nimbus-primary cursor-pointer">Lihat JSON mentah (initialAnalysis)</summary>
            <pre class="mt-3 p-4 rounded-lg bg-nimbus-subtle border border-nimbus-border text-[12px] font-mono text-nimbus-ink overflow-x-auto">{{ json_encode($analysis, $pretty) }}</pre>
        </details>
    </section>

    <!-- BASELINE -->
    <section class="bg-white border border-nimbus-border rounded-xl p-6 mt-6 shadow-card">
        <h2 class="text-[15px] font-display font-bold text-nimbus-ink">Baseline</h2>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mt-4">
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">baselineId</dt>
                <dd class="text-[13.5px] text-nimbus-ink font-mono mt-1">{{ $val($baseline['baselineId'] ?? null) }}</dd>
            </div>
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Versi</dt>
                <dd class="text-[13.5px] text-nimbus-ink mt-1">{{ $val($baseline['versionLabel'] ?? null) }}</dd>
            </div>
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Status</dt>
                <dd class="text-[13.5px] text-nimbus-ink mt-1">{{ $val($baseline['statusLabel'] ?? null) }}</dd>
            </div>
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Kelengkapan</dt>
                <dd class="text-[13.5px] text-nimbus-ink mt-1">{{ $val($baseline['completenessLabel'] ?? null) }}</dd>
            </div>
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Disetujui oleh</dt>
                <dd class="text-[13.5px] text-nimbus-ink mt-1">{{ $val($baseline['approvedBy'] ?? null) }}</dd>
            </div>
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Disetujui pada</dt>
                <dd class="text-[13.5px] text-nimbus-ink font-mono mt-1">{{ $val($baseline['approvedAt'] ?? null) }}</dd>
            </div>
        </dl>
    </section>

    <!-- TANGGAL RENCANA -->
    <section class="bg-white border border-nimbus-border rounded-xl p-6 mt-6 shadow-card">
        <h2 class="text-[15px] font-display font-bold text-nimbus-ink">Tanggal Rencana (Project Plan)</h2>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mt-4">
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">planId</dt>
                <dd class="text-[13.5px] text-nimbus-ink font-mono mt-1">{{ $val($plan['planId'] ?? null) }}</dd>
            </div>
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Tanggal rencana</dt>
                <dd class="text-[13.5px] text-nimbus-ink font-mono mt-1">{{ $val($plan['plannedDate'] ?? null) }}</dd>
            </div>
            <div>
                <dt class="text-[11px] font-semibold tracking-[0.06em] text-nimbus-muted uppercase">Tenggat H-1 hari kerja</dt>
                <dd class="text-[13.5px] text-nimbus-ink font-mono mt-1">
                    {{ $val($plan['dueDateH1'] ?? null) }}
                    @if (! empty($plan['dueDayName']))
                        ({{ $plan['dueDayName'] }}, {{ $val($plan['cutoffTime'] ?? null) }})
                    @endif
                </dd>
            </div>
        </dl>
    </section>

    <p class="text-[12px] text-nimbus-muted mt-6">
        Halaman ini membaca state tampilan. API kontrak antarkelompok (execution-readiness dan planning-references) masih membaca data seed dan belum mengikuti state ini.
    </p>
@endsection
