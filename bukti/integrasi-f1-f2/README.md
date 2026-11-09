# Bukti uji lintas layanan E-3, D-1, F-1, F-2

Diambil 2026-11-09 (17:51–17:59 WIB) di satu mesin lokal (Windows 11, PowerShell, `curl.exe`), mengikuti `panduan-uji-lintas-layanan.md`.

| Layanan | Commit | Alamat | Catatan |
|---|---|---|---|
| E-3 (konsumen) | `2170c3d` (branch `feat/integrasi-d1`; bukti ini di-commit setelahnya) | http://localhost:8000 | `D1_MODE=real`, `D1_BASE_URL=http://localhost:3000/api/v1`, PHP 8.4.15 |
| D-1 | `40d9e5d` (= `origin/main`) | http://localhost:3000 | Panduan menyebut `df003ce`, tetapi commit itu **tidak ada lagi** di riwayat D-1 (setelah `git fetch`); bukti Pertemuan 6 di `bukti/integrasi` memakai `df003ce`. `npx prisma db push` + `npm run db:seed`; seed berjalan saat F-2 belum hidup ("MODE MANDIRI D1"). |
| F-1 | `93c12da` | http://127.0.0.1:4100 | server demo in-memory (`npm start`) |
| F-2 | `ad0b959` | http://localhost:8080 | `npm run dev`; dijalankan dengan Node 24.11.0 (panduan: Node 20) |

Kode repo D-1, F-1, dan F-2 tidak diubah. Token JWT pada berkas disamarkan (`eyJ...[disamarkan]`); token simulasi (`mock-token`, `token-coo`, `token-karyawan`) bukan rahasia. Tiap berkas `.txt` berisi perintah, token (disamarkan), body, waktu, header dan body respons.

## E-3

| ID | Berkas | Hasil aktual |
|---|---|---|
| E3-00 | `E3-00_php-artisan-test.txt` | 23 tes lulus, 110 assertion (10 ApiContract, 4 D1Integration, 9 ProjectWorkflow) |
| E3-01 | `E3-01.txt` | 200, `readyForExecution: true`, kickoffId 101, momId 201 |
| E3-02 | `E3-02.txt` | 200, baselineId 301, baselineVersion 1, planId 401 |
| E3-03 | `E3-03.txt` | 401 UNAUTHENTICATED |
| E3-04 | `E3-04.txt` | 400 INVALID_PROJECT_ID_FORMAT |
| E3-05 | `E3-05.txt` | 404 PROJECT_NOT_FOUND |
| E3-06 | `E3-06.txt` (+ `E3-06a`…`E3-06g`) | Alur dijalankan **lewat API** (state dihapus dulu): analisis awal 200, baseline v1 DRAFT 200, tanggal 10/19/2026 → 2026-10-19, H-1 2026-10-16 (Jumat) 200, mode 1 200, persetujuan 200 APPROVED; lima halaman UI HTTP 200, Ringkasan Data memuat analisis yang disimpan. **Tangkapan layar UI belum diambil.** Hash akhir E3-06 tidak tercatat (galat skrip). |
| E3-07 | `E3-07.txt` (+ `E3-07a`, `E3-07b`, `E3-07c0`, `E3-07c`) | Isian kosong 422 VALIDATION_ERROR; tanggal tidak valid 422 INVALID_PLANNED_DATE; mode 2 lalu setujui 422 BASELINE_INCOMPLETE; sha256 `workflow_state.json` sebelum = sesudah pada ketiga kasus (`6C930BD8…3BBB`) |

## D-1

| ID | Berkas | Harapan panduan | Hasil aktual |
|---|---|---|---|
| D1-01 | `D1-01.txt` | 200, `pmEmployeeId` "SDM-0004", ada `indicativeValue`, `auditLogs` | 200, kode 202601, **`pmEmployeeId` `01929b4a-5f10-7a22-9d44-3c8f1b2e7a01`** (bentuk UUID v7), PM Haekal Khadafy; **tidak ada** `indicativeValue`, `auditLogs`, `rejectionNotes`; `amName`, `pmName` masih ada; `createdAt` sudah +07:00 |
| D1-02 | `D1-02.txt` | 200 (INT-01) | **401** UNAUTHORIZED (header Authorization wajib) |
| D1-02b | `D1-02b.txt` | (tambahan) | token acak `token-acak` → **200**: D-1 hanya memeriksa keberadaan header, bukan keabsahan token |
| D1-03 | `D1-03.txt` | 404 (INT-02) | **400** INVALID_PROJECT_ID_FORMAT |
| D1-04 | `D1-04.txt` | 200 | **400** INVALID_PROJECT_ID_FORMAT (kode kanonis tidak lagi diterima sebagai path) |
| D1-05 | `D1-05.txt` | "Sumber data proyek: D-1" | 200, "Sumber data proyek: D-1 … mode nyata", kode 202601, Implementasi Sistem ERP Cloud Phase 1, PT Fikri Solusi Mandiri, PM Haekal Khadafy, REGISTERED |
| D1-06 | `D1-06.txt` | "(D1_UNREACHABLE)", sha256 sama | 200, "Data proyek tidak tersedia dari D-1 (D1_UNREACHABLE)", analisis awal tetap tampil; sha256 sama |

## F-1

| ID | Berkas | Hasil aktual |
|---|---|---|
| F1-01 | `F1-01.txt` | 200, `accessToken`, `roleCode` COO, `expiresIn` 3600 |
| F1-02 | `F1-02.txt` | header `{"alg":"HS256","typ":"JWT"}`; payload `accountId`, `roleCode`, `iat`, `exp` (tanpa `employeeId`) |
| F1-03 | `F1-03.txt` | 200; admin `accountId` `01929b4a-6e2a-7b3f-8c71-0ab4e3d9f2a1`, `employeeId` `01929b4a-5f10-7a22-9d44-3c8f1b2e7a9f`, `roleCode` ADMIN |
| F1-04 | `F1-04.txt` | 401 INVALID_TOKEN "Token tidak ada." |
| F1-05 | `F1-05.txt` | 401 INVALID_TOKEN "Token tidak valid: invalid token" |
| F1-06 | `F1-06.txt` | 403 ACCOUNT_INACTIVE (`icha.aprilia`, PM): tidak ada token PM yang dapat diperoleh dari akun demo |
| F1-06b | `F1-06b.txt` | (tambahan) `amaliyah` 403 ACCOUNT_LOCKED |
| F1-07 | `F1-07.txt` | 401 INVALID_CREDENTIALS |
| F1-08 | `F1-08.txt` | 403 INSUFFICIENT_PERMISSION (token EMPLOYEE) |
| F1-09 | `F1-09.txt`, `F1-09b.txt` | 201 akun `demo.pm` (PM); login `demo.pm` dengan `Password123!` → 401 INVALID_CREDENTIALS |
| F1-10 | `F1-10.txt` | 200, `roleCode` ADMIN, `status` active |

## F-2

| ID | Berkas | Hasil aktual |
|---|---|---|
| F2-01 | `F2-01.txt` | 200; `employeeId`, `nomorPegawai` SDM-2026-001, `namaLengkap`, `jabatanId`, `namaJabatan` Project Manager, `statusKerja`; tanpa email/telepon |
| F2-02 | `F2-02.txt` | 401, `code` angka `401` (F-1 memakai string `INVALID_TOKEN`; INT-08) |
| F2-03 | `F2-03.txt` | 401 "Token tidak valid." |
| F2-04 | `F2-04.txt` | 404 EMPLOYEE_NOT_FOUND untuk `SDM-0004` |
| F2-04b | `F2-04b.txt` | (tambahan) 404 EMPLOYEE_NOT_FOUND untuk `pmEmployeeId` D-1 aktual `01929b4a-…7a01`: INT-04/INT-06 tetap berlaku walau formatnya kini UUID |
| F2-05 | `F2-05.txt` | 403 (token-karyawan) |
| F2-06 | `F2-06.txt` | 201, `employeeId` UUID v7 baru `01a1bff1-fecf-7eea-9e0c-bbbeb95e9de6`, `nomorPegawai` SDM-0004 |
| F2-07 | `F2-07.txt` | 200, `namaJabatan` "Project Manager" (diturunkan dari `jabatanId`; INT-09) |
| F2-08 | `F2-08.txt` | 422 "Field wajib belum diisi." |

## Lintas layanan

| ID | Berkas | Hasil aktual | Arti |
|---|---|---|---|
| X-01 | `X-01.txt` | JWT F-1 ke F-2 → 401 "Token tidak valid." | INT-05 terbukti |
| X-02 | `X-02.txt` | JWT F-1 ke E-3 → 401 UNAUTHENTICATED | E-3 belum memakai JWT F-1 |
| X-03 | `X-03.txt` | `employeeId` F-1 admin ke F-2 → 404 EMPLOYEE_NOT_FOUND | ID pegawai F-1 dan F-2 tidak selaras (OPEN-06) |
| X-04 | `X-04.txt` | JWT F-1 ke D-1 → 200 | D-1 menerima token apa pun yang ada (lihat D1-02b); INT-01 berubah dari "tanpa token diterima" menjadi "token tidak divalidasi" |

## Temuan tambahan

- `accountId` admin F-1 (`01929b4a-6e2a-7b3f-8c71-0ab4e3d9f2a1`) sama dengan `amEmployeeId` proyek 202601 di D-1. Kemungkinan D-1 memakai accountId F-1 sebagai ID pegawai AM; perlu dikonfirmasi ke D-1 dan F-1.
- Status INT-01, INT-02, INT-03 pada laporan perlu diperbarui: D-1 commit `40d9e5d` sudah memperbaiki sebagian (401 tanpa header, 400 untuk format salah, field di luar skema berkurang).

## Belum dikerjakan (perlu tindakan manual)

- Tangkapan layar terminal `php artisan test` dan UI lima langkah (E3-06).
- Koordinasi chat dengan F-1, F-2, D-1 (`koordinasi/`).
