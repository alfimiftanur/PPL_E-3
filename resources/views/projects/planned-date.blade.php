@extends('layouts.app', ['title' => 'Penentuan Tanggal Rencana Project Plan | PT Anaheim Nimbus Universal'])

@section('content')
    <!-- PAGE HEADER -->
    <div>
        <h1 class="text-[20px] sm:text-[23px] lg:text-[25px] font-display font-extrabold text-nimbus-ink tracking-tight">
            Penentuan Tanggal Rencana Project Plan
        </h1>
        <p class="text-[13px] sm:text-[13.5px] text-nimbus-slate leading-relaxed mt-1.5">
            Konfigurasi jadwal rencana pelaksanaan proyek oleh Project Manager dan perhitungan otomatis dengan tenggat H-1 berbasis hari kerja.
        </p>
    </div>

    <!-- TOP 2-COLUMN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 mt-5 sm:mt-6 items-start">
        <!-- LEFT COLUMN: SCHEDULE CONFIGURATION -->
        <section class="lg:col-span-7 bg-white border border-nimbus-border rounded-xl p-4 sm:p-6 shadow-card">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#eef4ff] text-nimbus-primary flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                        <path d="m9 16 2 2 4-4"/>
                    </svg>
                </div>
                <h2 class="text-[15.5px] font-display font-bold text-nimbus-ink">
                    Konfigurasi Jadwal Pelaksanaan
                </h2>
            </div>

            <div class="mt-6">
                <label for="plannedDateInput" class="block text-[12.5px] font-bold text-nimbus-ink">
                    Tanggal Rencana PM <span class="text-red-600">*</span>
                </label>

                <div class="relative mt-2">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-nimbus-slate">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="plannedDateInput"
                        value="10/19/2026"
                        placeholder="MM/DD/YYYY atau YYYY-MM-DD"
                        class="w-full rounded-lg border border-[#e2e8f0] bg-[#fcfdff] pl-10 pr-4 py-3 text-[14px] font-medium text-nimbus-ink focus:outline-none focus:border-nimbus-primary focus:ring-2 focus:ring-nimbus-primary/15 transition-all"
                    />
                </div>
                <p id="dateErrorMsg" class="hidden text-[12px] font-semibold text-red-600 mt-1.5">Tanggal rencana tidak valid.</p>
                <p class="text-[11.5px] text-nimbus-muted mt-2">
                    Tetapkan tanggal mulai pelaksanaan resmi.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3">
                <button type="button" id="btnSaveDate" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-nimbus-primary hover:bg-nimbus-primaryHover text-white text-[13px] font-semibold shadow-xs transition-colors">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    <span>Simpan Tanggal</span>
                </button>

                <button type="button" id="btnResetDate" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[#e8f0fe] hover:bg-[#dbeafe] text-nimbus-ink text-[12.5px] font-semibold transition-colors">
                    <svg class="w-3.5 h-3.5 text-nimbus-slate shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                        <path d="M3 3v5h5"/>
                    </svg>
                    <span>Reset / Hitung Ulang</span>
                </button>
            </div>

            <!-- Timestamp Footer -->
            <div class="mt-7 pt-4 border-t border-[#f1f5f9] flex items-start sm:items-center gap-2 text-[11.5px] text-nimbus-slate">
                <svg class="w-3.5 h-3.5 text-nimbus-muted shrink-0 mt-0.5 sm:mt-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                    <path d="M3 3v5h5"/>
                    <path d="M12 7v5l4 2"/>
                </svg>
                <span class="leading-relaxed">
                    Terakhir disimpan: <strong id="lastSavedTime" class="font-mono font-bold text-nimbus-ink">2026-10-08 14:15:00 WIB</strong> • Otorisasi: <strong class="font-bold text-nimbus-ink">Project Manager</strong>
                </span>
            </div>
        </section>

        <!-- RIGHT COLUMN: AUTOMATIC H-1 DEADLINE -->
        <section class="lg:col-span-5 bg-[#eef4ff] border border-[#d8e6ff] rounded-xl p-4 sm:p-6">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-nimbus-primary text-white flex items-center justify-center shrink-0 shadow-xs">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <h2 class="text-[15.5px] font-display font-bold text-nimbus-ink">
                        Tenggat H-1 Otomatis
                    </h2>
                </div>

                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-white border border-[#cfe0ff] text-nimbus-primary text-[10px] font-bold tracking-wider uppercase">
                    <svg class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <span>AUTO-CALCULATED</span>
                </span>
            </div>

            <!-- Inner White Card -->
            <div class="mt-5 bg-white border border-[#dbeafe] rounded-xl p-5">
                <div class="text-[12px] font-medium text-nimbus-slate">
                    Tenggat Waktu Efektif:
                </div>

                <div class="mt-2 flex items-baseline gap-2">
                    <span id="dueDateDisplay" class="text-[28px] font-display font-extrabold text-nimbus-primary tracking-tight">2026-10-16</span>
                    <span id="dueDayName" class="text-[16px] font-semibold text-nimbus-slate">(Jumat)</span>
                </div>

                <div class="mt-3.5 flex items-center gap-2 text-[12.5px] text-nimbus-slate font-mono">
                    <svg class="w-3.5 h-3.5 text-nimbus-primary shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="13" r="8"/>
                        <path d="M12 9v4l2 2"/>
                        <path d="M5 3 2 6"/>
                        <path d="m22 6-3-3"/>
                    </svg>
                    <span>Batas Waktu:</span>
                    <span class="px-2 py-0.5 rounded bg-[#e8f0fe] text-nimbus-ink font-mono font-bold text-[12px]">23:59:59 WIB</span>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between text-[11.5px]">
                <span class="inline-flex items-center gap-2 font-medium text-nimbus-ink">
                    <span class="w-2 h-2 rounded-full bg-nimbus-primary"></span>
                    <span>Kalender Kerja Standar ANU (ID-JKT)</span>
                </span>
                <span class="font-mono text-nimbus-muted">UTC+07:00</span>
            </div>
        </section>
    </div>

    <!-- BOTTOM SECTION: PROJECT PLAN DETAIL (SPRINT 2 LOCKED) -->
    <section class="mt-10 pt-6 border-t border-nimbus-border">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
            <div>
                <h2 class="text-[15.5px] font-display font-bold text-nimbus-ink">
                    Project Plan Detail (Scope, Deliverable, Timeline, Roadmap)
                </h2>
                <p class="text-[12.5px] text-nimbus-slate mt-1 leading-relaxed">
                    Area empat bagian detail project plan saat ini dinonaktifkan sementara hingga penetapan tanggal rencana PM dikunci dan disetujui.
                </p>
            </div>

            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-[#e8eef7] text-[#334155] text-[11px] font-bold shrink-0">
                <svg class="w-3.5 h-3.5 text-[#475569]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <span>Terkunci: Menunggu Pengesahan Baseline</span>
            </span>
        </div>

        <!-- 4 Kartu Terkunci Sprint 2 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mt-5">
            <!-- 01/04 Scope Detail Matrix -->
            <div class="bg-[#f4f7fb] border border-[#e6ecf5] rounded-xl p-5 flex flex-col justify-between min-h-[195px]">
                <div>
                    <div class="flex items-center justify-between text-[#64748b]">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="4" width="16" height="16" rx="2"/>
                            <line x1="8" y1="9" x2="16" y2="9"/>
                            <line x1="8" y1="13" x2="14" y2="13"/>
                        </svg>
                        <span class="font-mono text-[11.5px]">01/04</span>
                    </div>
                    <h3 class="text-[14.5px] font-display font-bold text-[#475569] mt-3.5">
                        Scope Detail Matrix
                    </h3>
                    <p class="text-[11.5px] text-[#64748b] leading-relaxed mt-1.5">
                        WBS Breakdown, sub-modul integrasi, dan batasan operasional modul core.
                    </p>
                </div>
                <div class="flex justify-end mt-4">
                    <span class="font-mono text-[10.5px] px-2.5 py-0.5 rounded bg-[#eaf0f8] text-[#64748b]">Sprint 2</span>
                </div>
            </div>

            <!-- 02/04 Deliverable Specifications -->
            <div class="bg-[#f4f7fb] border border-[#e6ecf5] rounded-xl p-5 flex flex-col justify-between min-h-[195px]">
                <div>
                    <div class="flex items-center justify-between text-[#64748b]">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="4" width="16" height="16" rx="2"/>
                            <path d="m8 12 2 2 4-4"/>
                            <line x1="8" y1="17" x2="16" y2="17"/>
                        </svg>
                        <span class="font-mono text-[11.5px]">02/04</span>
                    </div>
                    <h3 class="text-[14.5px] font-display font-bold text-[#475569] mt-3.5">
                        Deliverable Specifications
                    </h3>
                    <p class="text-[11.5px] text-[#64748b] leading-relaxed mt-1.5">
                        Daftar artefak teknis, dokumentasi API Swagger, dan pengujian SIT/UAT.
                    </p>
                </div>
                <div class="flex justify-end mt-4">
                    <span class="font-mono text-[10.5px] px-2.5 py-0.5 rounded bg-[#eaf0f8] text-[#64748b]">Sprint 2</span>
                </div>
            </div>

            <!-- 03/04 Timeline & Milestone Gantt -->
            <div class="bg-[#f4f7fb] border border-[#e6ecf5] rounded-xl p-5 flex flex-col justify-between min-h-[195px]">
                <div>
                    <div class="flex items-center justify-between text-[#64748b]">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <span class="font-mono text-[11.5px]">03/04</span>
                    </div>
                    <h3 class="text-[14.5px] font-display font-bold text-[#475569] mt-3.5">
                        Timeline &amp; Milestone Gantt
                    </h3>
                    <p class="text-[11.5px] text-[#64748b] leading-relaxed mt-1.5">
                        Alokasi critical path, ketergantungan tugas, dan buffer resiko implementasi.
                    </p>
                </div>
                <div class="flex justify-end mt-4">
                    <span class="font-mono text-[10.5px] px-2.5 py-0.5 rounded bg-[#eaf0f8] text-[#64748b]">Sprint 2</span>
                </div>
            </div>

            <!-- 04/04 Strategic Architecture Roadmap -->
            <div class="bg-[#f4f7fb] border border-[#e6ecf5] rounded-xl p-5 flex flex-col justify-between min-h-[195px]">
                <div>
                    <div class="flex items-center justify-between text-[#64748b]">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="6" height="6" rx="1"/>
                            <rect x="15" y="9" width="6" height="6" rx="1"/>
                            <rect x="3" y="15" width="6" height="6" rx="1"/>
                            <path d="M9 6h3v6h3"/>
                            <path d="M9 18h3v-6"/>
                        </svg>
                        <span class="font-mono text-[11.5px]">04/04</span>
                    </div>
                    <h3 class="text-[14.5px] font-display font-bold text-[#475569] mt-3.5">
                        Strategic Architecture Roadmap
                    </h3>
                    <p class="text-[11.5px] text-[#64748b] leading-relaxed mt-1.5">
                        Diagram arsitektur microservices, skalabilitas database, dan gateway sync.
                    </p>
                </div>
                <div class="flex justify-end mt-4">
                    <span class="font-mono text-[10.5px] px-2.5 py-0.5 rounded bg-[#eaf0f8] text-[#64748b]">Sprint 2</span>
                </div>
            </div>
        </div>
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

        const input = document.getElementById('plannedDateInput');
        const errorMsg = document.getElementById('dateErrorMsg');
        const dueDateDisplay = document.getElementById('dueDateDisplay');
        const dueDayName = document.getElementById('dueDayName');
        const lastSavedTime = document.getElementById('lastSavedTime');
        const btnSave = document.getElementById('btnSaveDate');
        const btnReset = document.getElementById('btnResetDate');

        function renderPlanState(plan) {
            if (!plan) return;
            if (plan.plannedDateInput) {
                input.value = plan.plannedDateInput;
            }
            if (plan.dueDateH1) {
                dueDateDisplay.textContent = plan.dueDateH1;
            }
            if (plan.dueDayName) {
                dueDayName.textContent = `(${plan.dueDayName})`;
            }
            if (plan.lastSavedAt && lastSavedTime) {
                lastSavedTime.textContent = plan.lastSavedAt;
            }
        }

        // Load initial state from API
        fetch(`${API_BASE}/overview`, { headers: HEADERS })
            .then((r) => r.json())
            .then((data) => {
                if (data?.state?.projectPlan) {
                    renderPlanState(data.state.projectPlan);
                }
            })
            .catch(() => {});

        async function saveDateViaApi(dateStr) {
            errorMsg.classList.add('hidden');
            try {
                const res = await fetch(`${API_BASE}/planned-date`, {
                    method: 'POST',
                    headers: HEADERS,
                    body: JSON.stringify({ plannedDate: dateStr }),
                });
                const payload = await res.json();
                if (!res.ok) {
                    errorMsg.textContent = payload.message || 'Tanggal rencana tidak valid.';
                    errorMsg.classList.remove('hidden');
                    return;
                }
                renderPlanState(payload.projectPlan);
            } catch (e) {}
        }

        const presets = @json($state['plannedDatePresets'] ?? []);
        let presetIndex = 0;

        btnSave.addEventListener('click', () => saveDateViaApi(input.value));
        input.addEventListener('change', () => saveDateViaApi(input.value));

        btnReset.addEventListener('click', () => {
            if (presets.length) {
                presetIndex = (presetIndex + 1) % presets.length;
                const nextDate = presets[presetIndex].plannedDateInput;
                input.value = nextDate;
                saveDateViaApi(nextDate);
            } else {
                input.value = '10/19/2026';
                saveDateViaApi('10/19/2026');
            }
        });
    })();
</script>
@endpush
