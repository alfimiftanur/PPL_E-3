@extends('layouts.app', ['title' => 'Pencatatan Analisis Awal Proyek | PT Anaheim Nimbus Universal'])

@section('content')
    <!-- PAGE HEADER -->
    <div>
        <div class="flex items-center gap-2.5">
            <h1 class="text-[20px] sm:text-[23px] lg:text-[25px] font-display font-extrabold text-nimbus-ink tracking-tight">
                Pencatatan Analisis Awal Proyek
            </h1>
            <svg class="w-5 h-5 text-nimbus-primary shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="3"/>
                <path d="m9 12 2 2 4-4"/>
            </svg>
        </div>
        <p class="text-[13px] sm:text-[13.5px] text-nimbus-slate leading-relaxed mt-1.5">
            Dokumentasi kebutuhan awal dan kondisi awal proyek oleh Project Manager (PM) sebagai landasan penyusunan proyek (Project Charter) serta baseline ruang lingkup dan jadwal.
        </p>
    </div>

    <!-- READ-ONLY PROJECT DATA CARD -->
    <section class="bg-white border border-nimbus-border rounded-xl p-4 sm:p-6 mt-5 sm:mt-6 shadow-card">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-nimbus-primary shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <ellipse cx="12" cy="5" rx="9" ry="3"/>
                    <path d="M3 5V19A9 3 0 0 0 21 19V5"/>
                    <path d="M3 12A9 3 0 0 0 21 12"/>
                </svg>
                <h2 class="text-[13.5px] font-display font-bold text-nimbus-ink">Data Proyek (Read-Only)</h2>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-[#10b981] shrink-0"></span>
                <span class="font-mono text-[10.5px] sm:text-[11px] font-semibold tracking-wider text-nimbus-muted uppercase">TERHUBUNG SECARA REAL-TIME</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3.5 sm:gap-4 mt-4">
            <!-- 1. Project Name -->
            <div class="bg-[#f8fafc] border border-[#e6ecf5] rounded-lg p-4 flex flex-col justify-between min-h-[118px]">
                <div>
                    <div class="flex items-center gap-1.5 text-[10.5px] font-bold tracking-wider text-nimbus-muted uppercase">
                        <span>NAMA PROYEK</span>
                        <svg class="w-3 h-3 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                    <div class="text-[13.5px] font-display font-bold text-nimbus-ink leading-snug mt-1.5">
                        Sistem Terpadu Nimbus Core Enterprise ERP
                    </div>
                </div>
                <div class="font-mono text-[11.5px] font-semibold text-nimbus-primary mt-3">
                    ID: PRJ-ANU-2026-001
                </div>
            </div>

            <!-- 2. Contractual Client -->
            <div class="bg-[#f8fafc] border border-[#e6ecf5] rounded-lg p-4 flex flex-col justify-between min-h-[118px]">
                <div>
                    <div class="flex items-center gap-1.5 text-[10.5px] font-bold tracking-wider text-nimbus-muted uppercase">
                        <span>KLIEN KONTRAKTUAL</span>
                        <svg class="w-3 h-3 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="2" width="16" height="20" rx="2" ry="2"/>
                            <path d="M9 22v-4h6v4"/>
                            <path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M16 10h.01"/><path d="M8 14h.01"/><path d="M16 14h.01"/>
                        </svg>
                    </div>
                    <div class="text-[13.5px] font-display font-bold text-nimbus-ink leading-snug mt-1.5">
                        PT Nusantara Sejahtera Pratama, Tbk.
                    </div>
                </div>
                <div class="text-[11.5px] text-nimbus-muted mt-3">
                    Divisi: Perbankan &amp; Finansial
                </div>
            </div>

            <!-- 3. Project Status -->
            <div class="bg-[#f8fafc] border border-[#e6ecf5] rounded-lg p-4 flex flex-col justify-between min-h-[118px]">
                <div>
                    <div class="flex items-center gap-1.5 text-[10.5px] font-bold tracking-wider text-nimbus-muted uppercase">
                        <span>STATUS PROYEK</span>
                        <svg class="w-3 h-3 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#d1fae5] border border-[#a7f3d0] text-[#047857] text-[11.5px] font-semibold">
                            <svg class="w-3.5 h-3.5 text-[#059669]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                            diterima PM
                        </span>
                    </div>
                </div>
                <div class="font-mono text-[11px] text-nimbus-muted mt-3">
                    Tgl Serah Terima: 2026-10-06
                </div>
            </div>

            <!-- 4. Initial Analysis Status -->
            <div class="bg-[#f8fafc] border border-[#e6ecf5] rounded-lg p-4 flex flex-col justify-between min-h-[118px]">
                <div>
                    <div class="flex items-center gap-1.5 text-[10.5px] font-bold tracking-wider text-nimbus-muted uppercase">
                        <span>STATUS ANALISIS AWAL</span>
                        <svg class="w-3 h-3 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="3" width="16" height="18" rx="2"/>
                            <line x1="8" y1="9" x2="16" y2="9"/>
                            <line x1="8" y1="13" x2="14" y2="13"/>
                        </svg>
                    </div>
                    <div class="mt-2" id="analysisStatusBadgeWrap">
                        <span id="analysisStatusBadge" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#fef3c7] border border-[#f59e0b]/60 text-[#b45309] text-[11.5px] font-semibold">
                            <svg class="w-3.5 h-3.5 text-[#b45309]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 22h14"/>
                                <path d="M5 2h14"/>
                                <path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"/>
                                <path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/>
                            </svg>
                            <span id="analysisStatusText">Belum dicatat</span>
                        </span>
                    </div>
                </div>
                <div id="analysisStatusSub" class="font-mono text-[11.5px] text-nimbus-muted mt-3">
                    Wajib diisi
                </div>
            </div>
        </div>
    </section>

    <!-- INFORMATION BANNER -->
    <div id="infoBanner" class="bg-[#eef4ff] border border-[#cfe0ff] rounded-xl px-5 py-4 mt-5 flex items-start gap-3.5">
        <div class="w-8 h-8 rounded-lg bg-white border border-[#dbeafe] flex items-center justify-center shrink-0 text-nimbus-primary mt-0.5">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
        </div>
        <div class="leading-relaxed">
            <div id="bannerTitle" class="text-[12.5px] font-bold text-nimbus-ink">
                Analisis awal belum dicatat. Isi kebutuhan dan kondisi awal, lalu simpan.
            </div>
            <div id="bannerDesc" class="text-[12.5px] text-nimbus-primary mt-0.5">
                Pengisian dokumen ini merupakan prasyarat mutlak sebelum penerbitan Proyek (Project Charter) dan pembentukan Baseline Ruang Lingkup serta Jadwal.
            </div>
        </div>
    </div>

    <!-- INITIAL ANALYSIS FORM CARD -->
    <section class="bg-white border border-nimbus-border rounded-xl p-4 sm:p-6 mt-5 shadow-card">
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2">
            <div>
                <h2 class="text-[15px] sm:text-[15.5px] font-display font-bold text-nimbus-ink">Formulir Analisis Awal</h2>
                <p class="text-[12px] sm:text-[12.5px] text-nimbus-muted mt-0.5">
                    Lengkapi kedua bidang wajib di bawah ini secara ringkas dan faktual.
                </p>
            </div>
            <div class="text-[12px] text-nimbus-slate font-medium shrink-0">
                <span class="text-red-600 font-bold">*</span> Bidang wajib diisi
            </div>
        </div>

        <form id="analysisForm" class="mt-6" novalidate>
            <!-- Field 1: Initial Project Need -->
            <div>
                <div class="flex items-center justify-between">
                    <label for="projectNeed" class="text-[12.5px] font-bold text-nimbus-ink">
                        Kebutuhan Awal Proyek <span class="text-red-600">*</span>
                    </label>
                    <span id="needCharCount" class="font-mono text-[11.5px] text-nimbus-muted">314 karakter</span>
                </div>
                <textarea
                    id="projectNeed"
                    rows="3"
                    placeholder="Tuliskan kebutuhan awal bisnis, ekspektasi pemangku kepentingan kunci, arsitektur modul fungsional yang diharapkan, batasan cakupan, dan target operasional..."
                    class="mt-2 w-full rounded-lg border border-[#dce4f0] bg-white px-4 py-3 text-[13px] text-nimbus-ink placeholder:text-[#94a3b8] leading-relaxed focus:outline-none focus:border-nimbus-primary focus:ring-2 focus:ring-nimbus-primary/15 transition-all"
                ></textarea>
                <p id="needError" class="hidden text-[12px] font-semibold text-red-600 mt-1.5">Kebutuhan awal wajib diisi.</p>
                <p class="text-[11.5px] text-nimbus-muted mt-2">
                    Contoh: Migrasi core transaction ke arsitektur microservices berdaya tampung 5.000 TPS, enkripsi mTLS, serta integrasi settlement otomatis SNAP BI-FAST.
                </p>
            </div>

            <!-- Field 2: Initial Project Condition -->
            <div class="mt-6">
                <div class="flex items-center justify-between">
                    <label for="projectCondition" class="text-[12.5px] font-bold text-nimbus-ink">
                        Kondisi Awal Proyek <span class="text-red-600">*</span>
                    </label>
                    <span id="conditionCharCount" class="font-mono text-[11.5px] text-nimbus-muted">262 karakter</span>
                </div>
                <textarea
                    id="projectCondition"
                    rows="3"
                    placeholder="Deskripsikan kondisi awal infrastruktur klien, kesiapan server, ketersediaan SDM pengembang, status dokumen kontrak, serta risiko awal yang teridentifikasi..."
                    class="mt-2 w-full rounded-lg border border-[#dce4f0] bg-white px-4 py-3 text-[13px] text-nimbus-ink placeholder:text-[#94a3b8] leading-relaxed focus:outline-none focus:border-nimbus-primary focus:ring-2 focus:ring-nimbus-primary/15 transition-all"
                ></textarea>
                <p id="conditionError" class="hidden text-[12px] font-semibold text-red-600 mt-1.5">Kondisi awal wajib diisi.</p>
                <p class="text-[11.5px] text-nimbus-muted mt-2 leading-relaxed">
                    Contoh: Server klien on-premise telah terpasang CentOS 9 Stream, tim lead architect telah disiagakan, namun otorisasi firewall koneksi database masih dalam proses persetujuan IT Security klien.
                </p>
            </div>

            <!-- Data Governance & Lock Notice -->
            <div class="mt-6 bg-[#f8fafc] border border-[#e6ecf5] rounded-lg px-4 py-3.5 flex items-start gap-2.5">
                <svg class="w-4 h-4 text-nimbus-primary shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <path d="m9 12 2 2 4-4"/>
                </svg>
                <p class="text-[12.5px] text-nimbus-slate leading-relaxed">
                    <strong class="font-bold text-nimbus-ink">Tata Kelola &amp; Penguncian Data:</strong> Setelah disimpan oleh Project Manager, data analisis awal ini akan menjadi referensi saat penyusunan <strong class="font-bold text-nimbus-ink">Baseline Proyek.</strong>
                </p>
            </div>

            <!-- Action Buttons Row -->
            <div class="mt-6 pt-5 border-t border-[#f1f5f9] flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                    <button type="button" id="btnLoadSample" class="flex-1 sm:flex-initial justify-center inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-[#f1f5f9] hover:bg-[#e2e8f0] border border-[#dce4f0] text-[12.5px] font-semibold text-nimbus-ink transition-colors">
                        <svg class="w-3.5 h-3.5 text-nimbus-slate shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                            <path d="M7 8h10"/>
                            <path d="M7 12h6"/>
                        </svg>
                        <span>Muat Contoh Data</span>
                    </button>

                    <button type="button" id="btnClearForm" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-[12.5px] font-medium text-nimbus-muted hover:text-nimbus-ink transition-colors">
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                            <path d="M3 3v5h5"/>
                        </svg>
                        <span>Kosongkan</span>
                    </button>
                </div>

                <button type="submit" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-nimbus-primary hover:bg-nimbus-primaryHover text-white text-[13px] font-semibold shadow-xs transition-colors">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    <span>Simpan Analisis Awal</span>
                </button>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
<script>
    (function () {
        const PROJECT_ID = @json($state['project']['projectId'] ?? '01924b1e-7f32-7a81-9b12-45e8a1234567');
        const API_BASE = `/api/v1/projects/${PROJECT_ID}`;
        const HEADERS = {
            'Authorization': 'Bearer mock-token',
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        };

        const needInput = document.getElementById('projectNeed');
        const condInput = document.getElementById('projectCondition');
        const needCount = document.getElementById('needCharCount');
        const condCount = document.getElementById('conditionCharCount');
        const needError = document.getElementById('needError');
        const condError = document.getElementById('conditionError');
        const btnLoadSample = document.getElementById('btnLoadSample');
        const btnClearForm = document.getElementById('btnClearForm');
        const form = document.getElementById('analysisForm');

        const samples = @json($state['initialAnalysisSamples'] ?? []);
        let currentSampleIndex = 0;

        function updateCounter(input, label, defaultCount) {
            const len = input.value.length;
            label.textContent = (len === 0 ? defaultCount : len) + ' karakter';
        }

        function renderAnalysisState(analysis) {
            if (!analysis) return;
            if (analysis.projectNeed) {
                needInput.value = analysis.projectNeed;
                updateCounter(needInput, needCount, 314);
            }
            if (analysis.projectCondition) {
                condInput.value = analysis.projectCondition;
                updateCounter(condInput, condCount, 262);
            }

            const badgeWrap = document.getElementById('analysisStatusBadgeWrap');
            if (analysis.isSaved) {
                badgeWrap.innerHTML = `
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#d1fae5] border border-[#a7f3d0] text-[#047857] text-[11.5px] font-semibold">
                        <svg class="w-3.5 h-3.5 text-[#059669]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="m9 12 2 2 4-4"/>
                        </svg>
                        <span>Tersimpan</span>
                    </span>
                `;
                document.getElementById('analysisStatusSub').textContent = analysis.updatedAt || 'Tercatat pada ENT-K-E3-01';
                document.getElementById('bannerTitle').textContent = 'Analisis awal tersimpan.';
                document.getElementById('bannerDesc').textContent = 'Data analisis awal telah dikunci melalui API dan siap dijadikan acuan pada Penyusunan Baseline Proyek.';
            } else {
                badgeWrap.innerHTML = `
                    <span id="analysisStatusBadge" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#fef3c7] border border-[#f59e0b]/60 text-[#b45309] text-[11.5px] font-semibold">
                        <svg class="w-3.5 h-3.5 text-[#b45309]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"/><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/>
                        </svg>
                        <span id="analysisStatusText">Belum dicatat</span>
                    </span>
                `;
                document.getElementById('analysisStatusSub').textContent = 'Wajib diisi';
                document.getElementById('bannerTitle').textContent = 'Analisis awal belum dicatat. Isi kebutuhan dan kondisi awal, lalu simpan.';
                document.getElementById('bannerDesc').textContent = 'Pengisian dokumen ini merupakan prasyarat mutlak sebelum penerbitan Proyek (Project Charter) dan pembentukan Baseline Ruang Lingkup serta Jadwal.';
            }
        }

        // Load initial state from API
        fetch(`${API_BASE}/overview`, { headers: HEADERS })
            .then((r) => r.json())
            .then((data) => {
                if (data && data.state && data.state.initialAnalysis) {
                    renderAnalysisState(data.state.initialAnalysis);
                }
            })
            .catch(() => {});

        needInput.addEventListener('input', () => {
            needError.classList.add('hidden');
            needCount.textContent = needInput.value.length + ' karakter';
        });

        condInput.addEventListener('input', () => {
            condError.classList.add('hidden');
            condCount.textContent = condInput.value.length + ' karakter';
        });

        btnLoadSample.addEventListener('click', () => {
            if (!samples.length) return;
            const item = samples[currentSampleIndex % samples.length];
            currentSampleIndex++;
            needInput.value = item.projectNeed;
            condInput.value = item.projectCondition;
            needError.classList.add('hidden');
            condError.classList.add('hidden');
            updateCounter(needInput, needCount, 314);
            updateCounter(condInput, condCount, 262);
        });

        btnClearForm.addEventListener('click', async () => {
            needInput.value = '';
            condInput.value = '';
            needError.classList.add('hidden');
            condError.classList.add('hidden');
            needCount.textContent = '314 karakter';
            condCount.textContent = '262 karakter';

            try {
                const res = await fetch(`${API_BASE}/initial-analysis`, {
                    method: 'DELETE',
                    headers: HEADERS,
                });
                const payload = await res.json();
                if (payload.initialAnalysis) {
                    renderAnalysisState(payload.initialAnalysis);
                }
            } catch (e) {}
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            needError.classList.add('hidden');
            condError.classList.add('hidden');

            try {
                const res = await fetch(`${API_BASE}/initial-analysis`, {
                    method: 'POST',
                    headers: HEADERS,
                    body: JSON.stringify({
                        projectNeed: needInput.value,
                        projectCondition: condInput.value,
                    }),
                });
                const payload = await res.json();

                if (!res.ok) {
                    if (payload.errors?.projectNeed) {
                        needError.textContent = payload.errors.projectNeed;
                        needError.classList.remove('hidden');
                    }
                    if (payload.errors?.projectCondition) {
                        condError.textContent = payload.errors.projectCondition;
                        condError.classList.remove('hidden');
                    }
                    return;
                }

                renderAnalysisState(payload.initialAnalysis);
            } catch (err) {}
        });
    })();
</script>
@endpush
