# Bukti integrasi E-3 dengan D-1, F-1, dan F-2

Folder ini berisi dua kelompok bukti:

1. **I-01 sampai I-06b**: E-3 ke D-1 (API 7, API-K01-07), diambil 2026-11-03.
2. **I-07 sampai I-16**: verifikasi JWT F-1, referensi SDM F-2, dan uji lintas layanan, diambil 2026-11-10.

Token JWT tidak ditampilkan pada bukti. Tab Authorization di Postman hanya menampilkan nama variabel (`{{adminToken}}`, `{{cooToken}}`, `{{empToken}}`, `{{tamperedToken}}`). `mock-token` dan `token-coo` adalah token tiruan.

## 1. E-3 ke D-1 (2026-11-03)

Diambil 2026-11-03 (sekitar 12:16–12:18 WIB) di satu mesin lokal.

- Konsumen: E-3 branch `feat/integrasi-d1` (dasar `dev` 9877599), `D1_MODE=real`, `http://localhost:8000`
- Produsen: D-1 commit `df003ce`, `http://localhost:3000`, DB SQLite dari `npx prisma migrate deploy` dan `npm run db:seed`, dijalankan dengan `DEBUG=express:router` agar request tercatat (kode D-1 tidak diubah)
- Token pada bukti disamarkan (`Bearer ***`); nilai yang dipakai adalah token tiruan `mock-token`

| ID | Berkas | Hasil |
|---|---|---|
| I-01, I-03 | `I-01_I-03_overview-sumber-d1.txt`, `I-01_overview-sumber-d1.png`, `I-03_overview-data-d1.png` | Ringkasan Data HTTP 200; "Sumber data proyek: D-1"; kode 202601, Modernisasi Gedung Operasional, PT Cakra Infrastruktur, PM Budi Santoso, REGISTERED |
| I-02, I-05 | `I-02_I-05_d1-dengan-token.txt`, `I-02_d1-respons-200.png` | D-1 HTTP 200 dengan token |
| I-03b | `I-03b_jejak-e3-d1.txt`, `I-03b_log-e3.png` | Log E-3 (`D-1 GET ... status 200`) dan log D-1 (`dispatching GET ...`) pada detik yang sama (05:16:34 UTC) |
| I-04a | `I-04a_d1-404.txt`, `I-04a_overview-404.txt`, `I-04a_404.png` | D-1 404 PROJECT_NOT_FOUND; E-3 menampilkan "Data proyek tidak tersedia dari D-1 (PROJECT_NOT_FOUND)", analisis awal tetap tampil |
| I-04b | `I-04b_overview-d1-mati.txt`, `I-04b_d1-mati.png` | D-1 dihentikan; E-3 HTTP 200 dengan pesan "(D1_UNREACHABLE)" dan log WARNING |
| I-04c | `I-04c_state-tidak-berubah.txt`, `I-04c_workflow_state_sebelum.json`, `I-04c_workflow_state_sesudah.json` | `workflow_state.json` sebelum dan sesudah identik (sha256 sama) |
| I-06a | `I-06a_d1-tanpa-token.txt`, `I-06_tanpa-token.png` | Kontrak: 401. Aktual: **200** dengan data lengkap (INT-01 terbukti) |
| I-06b | `I-06b_d1-id-salah-format.txt`, `I-06b_id-salah.png` | Kontrak: 400. Aktual: **404** PROJECT_NOT_FOUND (INT-02 terbukti) |

Uji 403 ke D-1 tidak berlaku: kontrak endpoint D-1 ini tidak mendefinisikan 403.

Temuan tambahan dari respons I-02, dibandingkan dengan skema `ProjectCanonicalResponse` (openapi D-1 v0.2.0): semua 13 field wajib ada, tetapi 5 field di luar skema ikut terkirim: `indicativeValue`, `auditLogs`, `rejectionNotes`, `amName`, `pmName` (INT-03). E-3 hanya mengambil projectId, canonicalCode, projectName, clientName, pmEmployeeId, pmName, status. Catatan: `pmName` yang ditampilkan E-3 **tidak ada di kontrak**, jadi E-3 bergantung pada field di luar kontrak; perlu disepakati dengan D-1 (masukkan `pmName` ke skema) atau nama PM diambil dari F-2 lewat `pmEmployeeId`. `createdAt` bernilai `2026-02-15T08:30:00.000Z` (UTC, bukan +07:00) dan `pmEmployeeId` bernilai `SDM-0004`, bukan UUID v7 (INT-04).

> Catatan 2026-11-10: commit `df003ce` sudah tidak ada di riwayat D-1. Pada D-1 `40d9e5d`, sebagian temuan di atas sudah berubah: tanpa header 401, ID salah format 400, `indicativeValue`/`auditLogs`/`rejectionNotes` tidak lagi terkirim, `createdAt` +07:00, `pmEmployeeId` berbentuk UUID. Lihat I-13.

## 2. JWT F-1, F-2, dan lintas layanan (2026-11-10)

Diambil 2026-11-10 (sekitar 13:10–13:48 WIB) lewat Postman di satu mesin lokal.

- E-3: branch `dev` (kode `c1cc42e`), `http://localhost:8000`, `D1_MODE=real`, `F1_MODE=real`, `F2_MODE=real`
- D-1 `40d9e5d` (`http://localhost:3000`), F-1 `93c12da` (`http://127.0.0.1:4100`), F-2 `ad0b959` (`http://localhost:8080`)
- D-1 di-seed (`npm run db:seed`) saat F-2 aktif, sehingga PM proyek 202601 memakai ID pegawai F-2 (Sandy Walsh)
- JWT diambil dari `POST /auth/login` F-1 untuk akun demo `super.admin` (ADMIN), `yuril.salsabila` (COO), `dwi.saputra` (EMPLOYEE)

| ID | Berkas | Hasil |
|---|---|---|
| I-07 | `I-07_jwt-admin-ke-e3.png` | JWT F-1 ADMIN ke E-3 `execution-readiness`: 200, `readyForExecution` true |
| I-08 | `I-08_jwt-coo-ke-e3-planning-references.png` | JWT F-1 COO ke E-3 `planning-references`: 200, ada `baselineItems` (openapi v0.3.0) |
| I-09 | `I-09_jwt-employee-ke-e3-403.png` | JWT F-1 EMPLOYEE ke E-3: 403 FORBIDDEN, "Peran pengguna (EMPLOYEE) tidak memiliki hak akses" |
| I-10 | `I-10_mock-token-mode-real-401.png` | `mock-token` pada `F1_MODE=real`: 401 UNAUTHENTICATED |
| I-11 | `I-11_jwt-f1-ke-f2-401.png` | JWT F-1 ke F-2 `referensi/sdm`: 401 "Token tidak valid.", `code` berupa angka (INT-05, INT-08) |
| I-12 | `I-12_employeeid-f1-ke-f2-404.png` | `employeeId` akun `super.admin` F-1 ke F-2: 404 EMPLOYEE_NOT_FOUND; ID pegawai F-1 dan F-2 tidak selaras (OPEN-06) |
| I-13 | `I-13_jwt-f1-ke-d1.png` | JWT F-1 ke D-1: 200, D-1 tidak memvalidasi token (INT-01); `createdAt` +07:00; `amName` dan `pmName` masih di luar kontrak (INT-03) |
| I-14 | `I-14_pm-d1-ke-f2.png` | `pmEmployeeId` D-1 ke F-2: 200, Sandy Walsh, Project Manager |
| I-15 | `I-15_overview-sumber-d1-f2.png` | Ringkasan Data: "Sumber data proyek: D-1 … mode nyata" dan "Sumber data SDM: F-2 … mode nyata"; PM Sandy Walsh |
| I-16 | `I-16_jwt-signature-diubah-401.png`, `I-16b_jwt-signature-diubah-script.png` | JWT F-1 ADMIN dengan 3 karakter terakhir signature diubah (dibuat oleh pre-request script): 401; JWT yang sama tanpa diubah diterima (I-07), sehingga E-3 terbukti memverifikasi tanda tangan HS256 |
