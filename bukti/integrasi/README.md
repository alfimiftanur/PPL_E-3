# Bukti integrasi E-3 → D-1 (API 7, API-K01-07)

Diambil 2026-11-03 (sekitar 12:16–12:18 WIB) di satu mesin lokal.

- Konsumen: E-3 branch `feat/integrasi-d1` (dasar `dev` 9877599), `D1_MODE=real`, `http://localhost:8000`
- Produsen: D-1 commit `df003ce`, `http://localhost:3000`, DB SQLite dari `npx prisma migrate deploy` dan `npm run db:seed`, dijalankan dengan `DEBUG=express:router` agar request tercatat (kode D-1 tidak diubah)
- Token pada bukti disamarkan (`Bearer ***`); nilai yang dipakai adalah token tiruan `mock-token`

| ID | Berkas | Hasil |
|---|---|---|
| I-01, I-03 | `I-01_I-03_overview-sumber-d1.txt` | Ringkasan Data HTTP 200; "Sumber data proyek: D-1"; kode 202601, Modernisasi Gedung Operasional, PT Cakra Infrastruktur, PM Budi Santoso, REGISTERED |
| I-02, I-05 | `I-02_I-05_d1-dengan-token.txt` | D-1 HTTP 200 dengan token |
| I-03b | `I-03b_jejak-e3-d1.txt` | Log E-3 (`D-1 GET ... status 200`) dan log D-1 (`dispatching GET ...`) pada detik yang sama (05:16:34 UTC) |
| I-04a | `I-04a_d1-404.txt`, `I-04a_overview-404.txt` | D-1 404 PROJECT_NOT_FOUND; E-3 menampilkan "Data proyek tidak tersedia dari D-1 (PROJECT_NOT_FOUND)", analisis awal tetap tampil |
| I-04b | `I-04b_overview-d1-mati.txt` | D-1 dihentikan; E-3 HTTP 200 dengan pesan "(D1_UNREACHABLE)" dan log WARNING |
| I-04c | `I-04c_state-tidak-berubah.txt` | `workflow_state.json` sebelum dan sesudah identik (sha256 sama) |
| I-06a | `I-06a_d1-tanpa-token.txt` | Kontrak: 401. Aktual: **200** dengan data lengkap (INT-01 terbukti) |
| I-06b | `I-06b_d1-id-salah-format.txt` | Kontrak: 400. Aktual: **404** PROJECT_NOT_FOUND (INT-02 terbukti) |
| I-07 | - | Tidak berlaku: kontrak endpoint ini tidak mendefinisikan 403 |

Temuan tambahan dari respons I-02, dibandingkan dengan skema `ProjectCanonicalResponse` (openapi D-1 v0.2.0): semua 13 field wajib ada, tetapi 5 field di luar skema ikut terkirim: `indicativeValue`, `auditLogs`, `rejectionNotes`, `amName`, `pmName` (INT-03). E-3 hanya mengambil projectId, canonicalCode, projectName, clientName, pmEmployeeId, pmName, status. Catatan: `pmName` yang ditampilkan E-3 **tidak ada di kontrak**, jadi E-3 bergantung pada field di luar kontrak; perlu disepakati dengan D-1 (masukkan `pmName` ke skema) atau nama PM diambil dari F-2 lewat `pmEmployeeId`. `createdAt` bernilai `2026-02-15T08:30:00.000Z` (UTC, bukan +07:00) dan `pmEmployeeId` bernilai `SDM-0004`, bukan UUID v7 (INT-04).
