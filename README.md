# Kontrak API E-3 (Analisis, Baseline, dan Perencanaan Proyek)

Versi 0.1.0, data fiktif. Satu operasi: `GET /api/v1/e3/projects/{projectId}/execution-readiness` (API-K-E3-01, FTR-K-E3-10), dibaca E-4.

## Isi
- `openapi.yaml`: spesifikasi OpenAPI 3.0.3.
- `examples/success.json`: HTTP 200, MoM selesai, `readyForExecution: true`.
- `examples/success-not-ready.json`: HTTP 200, MoM belum selesai, `readyForExecution: false`.
- `examples/success-no-mom.json`: HTTP 200, kickoff dan MoM belum ada, field terkait null.
- `examples/error.json`: HTTP 404, `PROJECT_NOT_FOUND`.

## Membuka dan mencoba
- Buka `openapi.yaml` di https://editor.swagger.io atau Swagger UI.
- Mock lokal (contoh): `npx @stoplight/prism-cli mock openapi.yaml`, lalu
  `curl -H "Authorization: Bearer mock-token" http://localhost:4010/api/v1/e3/projects/PRJ-DEMO-001/execution-readiness`

## Catatan
- ID, path, dan autentikasi masih usulan E-3, belum dikonfirmasi F-1, D-1, dan E-4.
- Tidak ada endpoint berjalan. Bukti yang tersedia saat ini adalah mock dari spesifikasi.
