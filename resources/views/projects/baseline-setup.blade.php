@extends('layouts.app', ['title' => 'Penyusunan Baseline Proyek | PT Anaheim Nimbus Universal'])

@section('content')
    <!-- PAGE HEADER -->
    <div>
        <div class="flex items-center gap-2.5">
            <div class="w-6 h-6 rounded-md bg-[#e8f0fe] text-nimbus-primary flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="3"/>
                    <path d="m9 12 2 2 4-4"/>
                </svg>
            </div>
            <h1 class="text-[20px] sm:text-[23px] lg:text-[25px] font-display font-extrabold text-nimbus-ink tracking-tight">
                Penyusunan Baseline Proyek
            </h1>
        </div>
        <p class="text-[13px] sm:text-[13.5px] text-nimbus-slate leading-relaxed mt-1.5">
            Perumusan baseline terpadu ruang lingkup (Scope), artefak serah terima (Deliverable), dan linimasa eksekusi (Timeline) sebelum penguncian formal.
        </p>
    </div>

    <!-- TOP BASELINE METADATA CARD -->
    <section class="bg-white border border-nimbus-border rounded-xl px-4 sm:px-6 py-4 sm:py-5 mt-5 sm:mt-6 shadow-card">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6">
            <!-- 1. Baseline Version -->
            <div>
                <div class="text-[10.5px] font-bold tracking-wider text-nimbus-muted uppercase">VERSI BASELINE</div>
                <div class="flex items-center gap-2.5 mt-2">
                    <span id="baselineVersionBadge" class="inline-flex items-center px-2.5 py-1 rounded-md bg-[#e8f0fe] text-nimbus-ink font-display font-extrabold text-[13.5px]">
                        v1.0
                    </span>
                    <span id="baselineDraftStatus" class="text-[12px] font-medium text-nimbus-slate">Draf Baru Siap</span>
                </div>
            </div>

            <!-- 2. Baseline Date -->
            <div>
                <div class="text-[10.5px] font-bold tracking-wider text-nimbus-muted uppercase">TANGGAL BASELINE</div>
                <div id="baselineDateMain" class="text-[13.5px] font-display font-bold text-nimbus-ink mt-1.5">
                    Otomatis saat simpan
                </div>
                <div class="text-[11px] text-nimbus-muted mt-0.5">
                    Stempel waktu kanonis server
                </div>
            </div>

            <!-- 3. Baseline Readiness Status -->
            <div>
                <div class="text-[10.5px] font-bold tracking-wider text-nimbus-muted uppercase">STATUS KESIAPAN BASELINE</div>
                <div class="mt-1.5">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#d1fae5] text-[#047857] text-[11px] font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#059669]"></span>
                        Siap Disimpan (3/3 Matriks Lengkap)
                    </span>
                </div>
                <div class="text-[11px] text-nimbus-muted mt-1">
                    Validasi struktur WI-02 lulus
                </div>
            </div>

            <!-- 4. Authority Info -->
            <div>
                <div class="text-[10.5px] font-bold tracking-wider text-nimbus-muted uppercase">KETERANGAN OTORITAS</div>
                <div class="text-[13.5px] font-display font-bold text-nimbus-ink mt-1.5">
                    ENT-K-E3-02: Baseline
                </div>
                <div class="text-[11px] text-nimbus-muted mt-0.5">
                    Project Manager
                </div>
            </div>
        </div>
    </section>

    @php
        $scopeRows = $state['baseline']['matrices']['scope'] ?? [];
        $deliverableRows = $state['baseline']['matrices']['deliverable'] ?? [];
        $timelineRows = $state['baseline']['matrices']['timeline'] ?? [];
    @endphp

    <!-- BASELINE MATRICES TAB CARD -->
    <section class="bg-white border border-nimbus-border rounded-xl mt-5 sm:mt-6 shadow-card overflow-hidden">
        <!-- Tab Navigation Bar -->
        <div class="px-4 sm:px-6 pt-3 border-b border-nimbus-border flex items-center gap-4 sm:gap-7 overflow-x-auto no-scrollbar">
            <button type="button" data-tab="scope" class="matrix-tab-btn pb-3 border-b-2 border-nimbus-primary text-nimbus-primary font-display font-bold text-[12.5px] sm:text-[13px] flex items-center gap-2 whitespace-nowrap shrink-0 transition-colors">
                <span>1. Scope Matrix</span>
                <span id="countBadgeScope" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-[#d1fae5] text-[#047857] text-[10.5px] font-bold">
                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>{{ count($scopeRows) }} Modul</span>
                </span>
            </button>

            <button type="button" data-tab="deliverable" class="matrix-tab-btn pb-3 border-b-2 border-transparent text-nimbus-slate hover:text-nimbus-ink font-display font-semibold text-[12.5px] sm:text-[13px] flex items-center gap-2 whitespace-nowrap shrink-0 transition-colors">
                <span>2. Deliverable Matrix</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-[#d1fae5] text-[#047857] text-[10.5px] font-bold">
                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>{{ count($deliverableRows) }} Artefak</span>
                </span>
            </button>

            <button type="button" data-tab="timeline" class="matrix-tab-btn pb-3 border-b-2 border-transparent text-nimbus-slate hover:text-nimbus-ink font-display font-semibold text-[12.5px] sm:text-[13px] flex items-center gap-2 whitespace-nowrap shrink-0 transition-colors">
                <span>3. Timeline Matrix</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-[#d1fae5] text-[#047857] text-[10.5px] font-bold">
                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>{{ count($timelineRows) }} Jadwal</span>
                </span>
            </button>
        </div>

        <!-- TAB 1: SCOPE MATRIX -->
        <div id="tab-scope" class="matrix-tab-panel p-4 sm:p-6">
            <div>
                <h2 class="text-[15px] sm:text-[15.5px] font-display font-bold text-nimbus-ink">
                    Spesifikasi Ruang Lingkup Proyek (Scope Matrix)
                </h2>
                <p class="text-[12px] sm:text-[12.5px] text-nimbus-muted mt-0.5">
                    Definisikan batasan modul, fungsionalitas inti, dan penanggung jawab teknis.
                </p>
            </div>

            <div class="mt-5 overflow-x-auto">
                <table class="w-full min-w-[680px] border-collapse">
                    <thead>
                        <tr class="bg-[#eef4ff] text-left text-[10.5px] font-bold tracking-wider text-[#334155] uppercase">
                            <th class="py-3 px-4 rounded-l-lg w-[72px]">NO</th>
                            <th class="py-3 px-4 w-[280px]">MODULE</th>
                            <th class="py-3 px-4">SCOPE DESCRIPTION</th>
                            <th class="py-3 px-4 w-[210px] text-center">PIC</th>
                            <th class="py-3 px-4 rounded-r-lg w-[80px] text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="scopeTableBody" class="divide-y divide-[#f1f5f9] text-[13px]">
                        @foreach($scopeRows as $idx => $row)
                        <tr class="group">
                            <td class="py-4 px-4 font-mono text-[12.5px] font-semibold text-nimbus-slate">#{{ str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-4 px-4">
                                <input type="text" value="{{ $row['module'] }}" class="w-full rounded-lg border border-[#eef2f7] bg-[#fcfdff] px-3.5 py-2.5 text-[13px] font-medium text-nimbus-ink focus:outline-none focus:border-nimbus-primary" />
                            </td>
                            <td class="py-4 px-4">
                                <input type="text" value="{{ $row['description'] }}" class="w-full rounded-lg border border-[#eef2f7] bg-[#fcfdff] px-3.5 py-2.5 text-[13px] font-medium text-nimbus-ink focus:outline-none focus:border-nimbus-primary" />
                            </td>
                            <td class="py-4 px-4">
                                <input type="text" value="{{ $row['picRole'] }}" class="w-full rounded-lg border border-[#eef2f7] bg-[#fcfdff] px-3.5 py-2.5 text-[13px] font-medium text-nimbus-ink text-center focus:outline-none focus:border-nimbus-primary" />
                            </td>
                            <td class="py-4 px-4 text-center">
                                <button type="button" class="btn-delete-row inline-flex items-center justify-center p-2 rounded-lg text-red-600 hover:bg-red-50 transition-colors" title="Hapus Baris">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18"/>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        <line x1="10" y1="11" x2="10" y2="17"/>
                                        <line x1="14" y1="11" x2="14" y2="17"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 pt-3 border-t border-[#f1f5f9]">
                <button type="button" id="btnAddScopeRow" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#e8f0fe] hover:bg-[#dbeafe] text-nimbus-primary text-[12.5px] font-bold transition-colors">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="16"/>
                        <line x1="8" y1="12" x2="16" y2="12"/>
                    </svg>
                    <span>+ Tambah Baris Scope</span>
                </button>
            </div>
        </div>

        <!-- TAB 2: DELIVERABLE MATRIX -->
        <div id="tab-deliverable" class="matrix-tab-panel hidden p-4 sm:p-6">
            <div>
                <h2 class="text-[15px] sm:text-[15.5px] font-display font-bold text-nimbus-ink">
                    Spesifikasi Artefak Serah Terima (Deliverable Matrix)
                </h2>
                <p class="text-[12px] sm:text-[12.5px] text-nimbus-muted mt-0.5">
                    Daftar luaran dokumen dan artefak teknis per modul sesuai standar WI-02.
                </p>
            </div>
            <div class="mt-5 overflow-x-auto">
                <table class="w-full min-w-[680px] border-collapse">
                    <thead>
                        <tr class="bg-[#eef4ff] text-left text-[10.5px] font-bold tracking-wider text-[#334155] uppercase">
                            <th class="py-3 px-4 rounded-l-lg w-[72px]">NO</th>
                            <th class="py-3 px-4 w-[280px]">MODULE</th>
                            <th class="py-3 px-4">DELIVERABLE SPECIFICATION</th>
                            <th class="py-3 px-4 w-[210px] text-center">PIC</th>
                            <th class="py-3 px-4 rounded-r-lg w-[80px] text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9] text-[13px]">
                        @foreach($deliverableRows as $idx => $row)
                        <tr>
                            <td class="py-4 px-4 font-mono text-[12.5px] font-semibold text-nimbus-slate">#{{ str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-4 px-4"><input type="text" value="{{ $row['module'] }}" class="w-full rounded-lg border border-[#eef2f7] bg-[#fcfdff] px-3.5 py-2.5 text-[13px] font-medium text-nimbus-ink" /></td>
                            <td class="py-4 px-4"><input type="text" value="{{ $row['description'] }}" class="w-full rounded-lg border border-[#eef2f7] bg-[#fcfdff] px-3.5 py-2.5 text-[13px] font-medium text-nimbus-ink" /></td>
                            <td class="py-4 px-4"><input type="text" value="{{ $row['picRole'] }}" class="w-full rounded-lg border border-[#eef2f7] bg-[#fcfdff] px-3.5 py-2.5 text-[13px] font-medium text-nimbus-ink text-center" /></td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center p-2 text-red-600"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg></span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 3: TIMELINE MATRIX -->
        <div id="tab-timeline" class="matrix-tab-panel hidden p-4 sm:p-6">
            <div>
                <h2 class="text-[15px] sm:text-[15.5px] font-display font-bold text-nimbus-ink">
                    Linimasa Eksekusi Modul (Timeline Matrix)
                </h2>
                <p class="text-[12px] sm:text-[12.5px] text-nimbus-muted mt-0.5">
                    Rentang tanggal mulai dan selesai setiap modul pada baseline proyek.
                </p>
            </div>
            <div class="mt-5 overflow-x-auto">
                <table class="w-full min-w-[680px] border-collapse">
                    <thead>
                        <tr class="bg-[#eef4ff] text-left text-[10.5px] font-bold tracking-wider text-[#334155] uppercase">
                            <th class="py-3 px-4 rounded-l-lg w-[72px]">NO</th>
                            <th class="py-3 px-4 w-[280px]">MODULE</th>
                            <th class="py-3 px-4">TIMELINE SCHEDULE</th>
                            <th class="py-3 px-4 w-[210px] text-center">PIC</th>
                            <th class="py-3 px-4 rounded-r-lg w-[80px] text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9] text-[13px]">
                        @foreach($timelineRows as $idx => $row)
                        <tr>
                            <td class="py-4 px-4 font-mono text-[12.5px] font-semibold text-nimbus-slate">#{{ str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-4 px-4"><input type="text" value="{{ $row['module'] }}" class="w-full rounded-lg border border-[#eef2f7] bg-[#fcfdff] px-3.5 py-2.5 text-[13px] font-medium text-nimbus-ink" /></td>
                            <td class="py-4 px-4"><input type="text" value="{{ $row['description'] }}" class="w-full rounded-lg border border-[#eef2f7] bg-[#fcfdff] px-3.5 py-2.5 text-[13px] font-mono font-medium text-nimbus-ink" /></td>
                            <td class="py-4 px-4"><input type="text" value="{{ $row['picRole'] }}" class="w-full rounded-lg border border-[#eef2f7] bg-[#fcfdff] px-3.5 py-2.5 text-[13px] font-medium text-nimbus-ink text-center" /></td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center p-2 text-red-600"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg></span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- BOTTOM ACTION FOOTER -->
    <section class="bg-white border border-nimbus-border rounded-xl px-4 sm:px-6 py-4 mt-5 shadow-card flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-2.5 sm:gap-3">
        <button type="button" id="btnResetBaseline" class="w-full sm:w-auto px-4 py-2.5 rounded-lg bg-[#f1f5f9] hover:bg-[#e2e8f0] text-nimbus-ink text-[12.5px] font-bold transition-colors">
            Reset / Batal
        </button>
        <button type="button" id="btnSaveDraft" class="w-full sm:w-auto px-4 py-2.5 rounded-lg bg-[#e8f0fe] hover:bg-[#dbeafe] text-nimbus-primary text-[12.5px] font-bold transition-colors">
            Simpan sebagai Draf
        </button>
        <button type="button" id="btnSaveBaseline" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-nimbus-primary hover:bg-nimbus-primaryHover text-white text-[12.5px] font-bold shadow-xs transition-colors">
            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            <span>Simpan Baseline</span>
        </button>
    </section>
@endsection

@push('scripts')
<script>
    (function () {
        // Tab Switching
        const tabButtons = document.querySelectorAll('.matrix-tab-btn');
        const tabPanels = {
            scope: document.getElementById('tab-scope'),
            deliverable: document.getElementById('tab-deliverable'),
            timeline: document.getElementById('tab-timeline')
        };

        tabButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                const target = btn.getAttribute('data-tab');
                tabButtons.forEach((b) => {
                    b.classList.remove('border-nimbus-primary', 'text-nimbus-primary', 'font-bold');
                    b.classList.add('border-transparent', 'text-nimbus-slate', 'font-semibold');
                });
                btn.classList.add('border-nimbus-primary', 'text-nimbus-primary', 'font-bold');
                btn.classList.remove('border-transparent', 'text-nimbus-slate', 'font-semibold');

                Object.keys(tabPanels).forEach((k) => {
                    tabPanels[k].classList.toggle('hidden', k !== target);
                });
            });
        });

        // Add & Delete Scope Row
        const scopeBody = document.getElementById('scopeTableBody');
        const btnAddScopeRow = document.getElementById('btnAddScopeRow');
        const countBadgeScope = document.getElementById('countBadgeScope');

        function renumberRows() {
            const rows = scopeBody.querySelectorAll('tr');
            rows.forEach((tr, idx) => {
                const numCell = tr.querySelector('td:first-child');
                numCell.textContent = '#' + String(idx + 1).padStart(2, '0');
            });
            countBadgeScope.innerHTML = `
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <span>${rows.length} Modul</span>
            `;
        }

        btnAddScopeRow.addEventListener('click', () => {
            const count = scopeBody.querySelectorAll('tr').length + 1;
            const tr = document.createElement('tr');
            tr.className = 'group';
            tr.innerHTML = `
                <td class="py-4 px-4 font-mono text-[12.5px] font-semibold text-nimbus-slate">#${String(count).padStart(2, '0')}</td>
                <td class="py-4 px-4">
                    <input type="text" value="Modul Pelaporan / MOD-0${count}" class="w-full rounded-lg border border-[#eef2f7] bg-[#fcfdff] px-3.5 py-2.5 text-[13px] font-medium text-nimbus-ink focus:outline-none focus:border-nimbus-primary" />
                </td>
                <td class="py-4 px-4">
                    <input type="text" value="Agregasi laporan eksekutif dan ekspor audit regulasi" class="w-full rounded-lg border border-[#eef2f7] bg-[#fcfdff] px-3.5 py-2.5 text-[13px] font-medium text-nimbus-ink focus:outline-none focus:border-nimbus-primary" />
                </td>
                <td class="py-4 px-4">
                    <input type="text" value="Technical Lead" class="w-full rounded-lg border border-[#eef2f7] bg-[#fcfdff] px-3.5 py-2.5 text-[13px] font-medium text-nimbus-ink text-center focus:outline-none focus:border-nimbus-primary" />
                </td>
                <td class="py-4 px-4 text-center">
                    <button type="button" class="btn-delete-row inline-flex items-center justify-center p-2 rounded-lg text-red-600 hover:bg-red-50 transition-colors" title="Hapus Baris">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/>
                        </svg>
                    </button>
                </td>
            `;
            scopeBody.appendChild(tr);
            renumberRows();
        });

        scopeBody.addEventListener('click', (e) => {
            const btn = e.target.closest('.btn-delete-row');
            if (!btn) return;
            const rows = scopeBody.querySelectorAll('tr');
            if (rows.length <= 1) return; // Minimal 1 baris
            btn.closest('tr').remove();
            renumberRows();
        });

        document.getElementById('btnSaveBaseline').addEventListener('click', async () => {
            const PROJECT_ID = @json($state['project']['projectId'] ?? '01924b1e-7f32-7a81-9b12-45e8a1234567');
            const rows = [];
            scopeBody.querySelectorAll('tr').forEach((tr, idx) => {
                const inputs = tr.querySelectorAll('input');
                rows.push({
                    rowId: idx + 1,
                    module: inputs[0]?.value || '',
                    description: inputs[1]?.value || '',
                    picRole: inputs[2]?.value || '',
                });
            });

            try {
                const res = await fetch(`/api/v1/projects/${PROJECT_ID}/baselines`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer mock-token',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        incrementVersion: true,
                        matrices: { scope: rows },
                    }),
                });
                const payload = await res.json();
                if (res.ok && payload.baseline) {
                    document.getElementById('baselineDateMain').textContent = payload.baseline.createdAt || '2026-10-12 09:40:00 WIB';
                    document.getElementById('baselineVersionBadge').textContent = payload.baseline.versionLabel || 'v1.0';
                    document.getElementById('baselineDraftStatus').textContent = 'Baseline ' + (payload.baseline.versionLabel || 'v1.0') + ' Tersimpan';
                }
            } catch (e) {}
        });

        document.getElementById('btnSaveDraft').addEventListener('click', async () => {
            const PROJECT_ID = @json($state['project']['projectId'] ?? '01924b1e-7f32-7a81-9b12-45e8a1234567');
            try {
                const res = await fetch(`/api/v1/projects/${PROJECT_ID}/baselines`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer mock-token',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ incrementVersion: false }),
                });
                const payload = await res.json();
                if (res.ok && payload.baseline) {
                    document.getElementById('baselineDateMain').textContent = payload.baseline.createdAt;
                    document.getElementById('baselineDraftStatus').textContent = 'Draf Tersimpan';
                }
            } catch (e) {}
        });
    })();
</script>
@endpush
