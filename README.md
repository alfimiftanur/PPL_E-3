# API E-3 (Laravel) - Kontrak Pertemuan 3

Kelompok E-3, capstone ERP PT. Anaheim Nimbus Universal. Kontrak ada di `openapi.yaml` (OpenAPI 3.0.3, v0.3.0).
Implementasi contoh memakai Laravel 13 (PHP 8.3) tanpa database: data diambil dari `data/seed.json`. Seluruh data fiktif.

## Operasi

- `GET /api/v1/projects/{projectId}/execution-readiness` (API-K-E3-01, FTR-K-E3-10), dibaca E-4: apakah proyek siap dieksekusi (status MoM kickoff `COMPLETED`).
- `GET /api/v1/projects/{projectId}/planning-references` (API-K-E3-02, FTR-K-E3-04 dan FTR-K-E3-05), usulan untuk E-5 dan D-3: ID baseline `APPROVED` terbaru dan ID project plan. Kebutuhan konsumen belum dikonfirmasi.

Awalan `/api` ditambahkan Laravel pada `routes/api.php`. Autentikasi memakai `Authorization: Bearer <MOCK_TOKEN>` (pengganti sementara token F-1, lihat OPEN-02 pada dokumen kontrak).

## Berkas

- `openapi.yaml`: kontrak. Nilai status: MoM `IN_PROGRESS`/`COMPLETED`, baseline `DRAFT`/`APPROVED`.
- `examples/`: contoh respons; dipakai tes dan dirujuk `openapi.yaml`.
- `routes/api.php`, `app/Http/Controllers/`, `app/Http/Middleware/MockBearerToken.php`, `app/Services/ProjectData.php`: implementasi.
- `tests/Feature/ApiContractTest.php`: 10 tes, respons harus sama dengan `examples/`.
- `bukti-mock.md`: hasil permintaan ke mock Prism.

## Menjalankan

```
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

```
curl -H "Authorization: Bearer mock-token" http://localhost:8000/api/v1/projects/01924b1e-7f32-7a81-9b12-45e8a1234567/execution-readiness
curl -H "Authorization: Bearer mock-token" http://localhost:8000/api/v1/projects/01924b1e-7f32-7a81-9b12-45e8a1234567/planning-references
```

Proyek contoh: `01924b1e-7f32-7a81-9b12-45e8a1234567` (MoM `COMPLETED`) dan `01924b1e-7f32-7a81-9b12-45e8a1234568` (belum ada kickoff, baseline masih `DRAFT`). UUID v7 lain mengembalikan 404; nilai yang bukan UUID v7 mengembalikan 400.

## Tes, lint, dan mock

```
php artisan test
npx @redocly/cli lint openapi.yaml
npx @stoplight/prism-cli mock openapi.yaml -p 4010
```

## Catatan

- Kode 403 dan 503 ada di spesifikasi tetapi belum diimplementasikan.
- `ProjectData` membaca JSON; pada implementasi sungguhan diganti query ke tabel E-3 (lihat dokumen Skema Data Awal).
