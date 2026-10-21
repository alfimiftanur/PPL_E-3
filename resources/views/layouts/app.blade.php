<!DOCTYPE html>
<html lang="id" class="h-full antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PT Anaheim Nimbus Universal | Nimbus Core ERP' }}</title>

    <!-- Google Fonts: Plus Jakarta Sans, Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Compiled Global Tailwind CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex bg-nimbus-bg text-nimbus-ink font-sans selection:bg-nimbus-primary selection:text-white">

    <!-- LEFT SIDEBAR -->
    <aside class="w-[260px] shrink-0 bg-white border-r border-nimbus-border flex flex-col justify-between sticky top-0 h-screen overflow-y-auto select-none z-30">
        <div>
            <!-- Brand Header -->
            <div class="h-[64px] px-5 flex items-center gap-3 border-b border-nimbus-border">
                <div class="w-8 h-8 rounded-lg bg-nimbus-primary text-white font-display font-bold text-sm flex items-center justify-center shadow-xs shrink-0">
                    N
                </div>
                <div class="leading-tight">
                    <div class="text-[13px] font-display font-bold text-nimbus-ink tracking-tight">PT Anaheim Nimbus Universal</div>
                    <div class="text-[10px] font-semibold tracking-[0.08em] text-nimbus-muted uppercase mt-0.5">NIMBUS CORE ERP</div>
                </div>
            </div>

            <!-- Group Label -->
            <div class="px-5 py-3.5 border-b border-nimbus-border">
                <span class="text-[10.5px] font-bold tracking-[0.07em] text-nimbus-muted uppercase">MODUL MANAJEMEN PROYEK</span>
            </div>

            <!-- Navigation Items -->
            <nav class="p-3 space-y-1">
                <!-- Project Portfolio -->
                <a href="{{ route('projects.initial-analysis') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[13px] font-medium text-[#334155] hover:bg-slate-100/80 transition-colors">
                    <svg class="w-4 h-4 text-[#475569] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                    <span>Portofolio Proyek</span>
                </a>

                <!-- Initial Analysis -->
                @php $isInitialAnalysis = ($activeMenu ?? '') === 'initial-analysis'; @endphp
                <a href="{{ route('projects.initial-analysis') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[13px] transition-colors {{ $isInitialAnalysis ? 'bg-nimbus-primary text-white font-semibold shadow-xs' : 'font-medium text-[#334155] hover:bg-slate-100/80' }}">
                    <svg class="w-4 h-4 {{ $isInitialAnalysis ? 'text-white' : 'text-[#475569]' }} shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="3" width="16" height="18" rx="2"/>
                        <path d="M8 14v3"/>
                        <path d="M12 11v6"/>
                        <path d="M16 8v9"/>
                    </svg>
                    <span>Analisis Awal</span>
                </a>

                <!-- Baseline Setup -->
                @php $isBaselineSetup = ($activeMenu ?? '') === 'baseline-setup'; @endphp
                <a href="{{ route('projects.baseline-setup') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[13px] transition-colors {{ $isBaselineSetup ? 'bg-nimbus-primary text-white font-semibold shadow-xs' : 'font-medium text-[#334155] hover:bg-slate-100/80' }}">
                    <svg class="w-4 h-4 {{ $isBaselineSetup ? 'text-white' : 'text-[#475569]' }} shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="3" width="16" height="18" rx="2"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    <span>Penyusunan Baseline</span>
                </a>

                <!-- Planned Date -->
                @php $isPlannedDate = ($activeMenu ?? '') === 'planned-date'; @endphp
                <a href="{{ route('projects.planned-date') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[13px] transition-colors {{ $isPlannedDate ? 'bg-nimbus-primary text-white font-semibold shadow-xs' : 'font-medium text-[#334155] hover:bg-slate-100/80' }}">
                    <svg class="w-4 h-4 {{ $isPlannedDate ? 'text-white' : 'text-[#475569]' }} shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                        <path d="m9 16 2 2 4-4"/>
                    </svg>
                    <span>Tanggal Rencana</span>
                </a>

                <!-- Baseline Review & Approval -->
                @php $isBaselineReview = ($activeMenu ?? '') === 'baseline-review'; @endphp
                <a href="{{ route('projects.baseline-review') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[13px] transition-colors {{ $isBaselineReview ? 'bg-nimbus-primary text-white font-semibold shadow-xs' : 'font-medium text-[#334155] hover:bg-slate-100/80' }}">
                    <svg class="w-4 h-4 {{ $isBaselineReview ? 'text-white' : 'text-[#475569]' }} shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    <span>Tinjau &amp; Persetujuan</span>
                </a>

                <!-- Resource & RACI -->
                <a href="#resource-raci" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[13px] font-medium text-[#334155] hover:bg-slate-100/80 transition-colors">
                    <svg class="w-4 h-4 text-[#475569] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span>Resource &amp; RACI</span>
                </a>

                <!-- Risk Matrix -->
                <a href="#risk-matrix" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[13px] font-medium text-[#334155] hover:bg-slate-100/80 transition-colors">
                    <svg class="w-4 h-4 text-[#475569] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    <span>Risk Matrix</span>
                </a>

                <!-- Budget & Contract -->
                <a href="#budget-contract" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[13px] font-medium text-[#334155] hover:bg-slate-100/80 transition-colors">
                    <svg class="w-4 h-4 text-[#475569] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="8" cy="8" r="6"/>
                        <path d="M18.09 10.37A6 6 0 1 1 10.34 18"/>
                        <path d="M7 6h1v4"/>
                    </svg>
                    <span>Budget &amp; Kontrak</span>
                </a>
            </nav>
        </div>

        <!-- Bottom Sidebar Divider Area -->
        <div class="h-14 border-t border-nimbus-border"></div>
    </aside>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- TOPBAR -->
        <header class="h-[64px] bg-white border-b border-nimbus-border px-8 flex items-center justify-between shrink-0 sticky top-0 z-20">
            <!-- Left Breadcrumb -->
            <div class="flex items-center gap-2.5 text-[13px]">
                <span class="inline-flex items-center gap-2 text-[#475569] font-medium">
                    <svg class="w-4 h-4 text-[#64748b]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                    Portofolio Proyek
                </span>

                <span class="text-slate-400 font-normal px-0.5">{{ $breadcrumbSeparator ?? '/' }}</span>

                @if(($breadcrumbActiveStyle ?? 'solid') === 'solid')
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-nimbus-primary text-white text-[12px] font-semibold tracking-tight">
                        {{ $breadcrumb ?? 'Analisis Awal' }}
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-md bg-[#e3edff] text-nimbus-primary text-[12px] font-semibold tracking-tight">
                        {{ $breadcrumb ?? 'Analisis Awal' }}
                    </span>
                @endif
            </div>

            <!-- Right User Profile -->
            <div class="flex items-center gap-3">
                <div class="text-right leading-tight">
                    <div class="inline-flex items-center gap-1.5 text-[13px] font-bold text-nimbus-ink">
                        <span>Project Manager</span>
                        <svg class="w-4 h-4 text-nimbus-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <path d="m9 12 2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="text-[11px] font-semibold text-[#059669]">Project Manager</div>
                </div>
                <div class="w-9 h-9 rounded-full bg-nimbus-primary text-white font-display font-bold text-xs flex items-center justify-center ring-2 ring-[#dbeafe]">
                    PM
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-1 px-8 py-7 w-full">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
