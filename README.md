# Kontrak API E-3 (Analisis, Baseline, dan Perencanaan Proyek)

Kelompok 3 / E, ERP PT. Anaheim Nimbus Universal. Penyusun: Aufa Ramadhan, reviewer internal: Alfi Mifta Nurhakim.
Versi 0.1.0, seluruh data fiktif.

Satu operasi: `GET /api/v1/e3/projects/{projectId}/execution-readiness` (API-K-E3-01, FTR-K-E3-10), dibaca E-4 untuk mengetahui apakah proyek siap dieksekusi (status MoM kickoff selesai).

## Isi
- `openapi.yaml`: spesifikasi OpenAPI 3.0.3 (sumber kebenaran kontrak).
- `examples/success.json`: HTTP 200, MoM selesai, `readyForExecution: true`.
- `examples/success-not-ready.json`: HTTP 200, MoM belum selesai, `readyForExecution: false`.
- `examples/success-no-mom.json`: HTTP 200, kickoff dan MoM belum ada, field terkait null.
- `examples/error.json`: HTTP 404, `PROJECT_NOT_FOUND`.
- `server.js`: server contoh (Node.js, Express) yang memvalidasi request dan respons terhadap `openapi.yaml`.
- `test.js`: tes yang membandingkan respons server dengan berkas di `examples/`.
- `bukti-mock.md`: hasil menjalankan mock Prism (200, 404, 401).

## Menjalankan
Butuh Node.js 18 atau lebih baru.

```
npm install
npm start      # server contoh di http://localhost:3000
npm test       # 4 tes: 200, 200 tanpa MoM, 404, 401
npm run mock   # alternatif: mock Prism dari openapi.yaml di http://localhost:4010
```

Contoh request (token mock):

```
curl -H "Authorization: Bearer mock-token" http://localhost:3000/api/v1/e3/projects/PRJ-DEMO-001/execution-readiness
```

Proyek contoh: `PRJ-DEMO-001` (MoM selesai) dan `PRJ-DEMO-002` (belum ada kickoff). ID lain mengembalikan 404.

Spesifikasi juga dapat dibuka di https://editor.swagger.io.

## Catatan
- ID, path, dan autentikasi masih usulan E-3, belum dikonfirmasi F-1, D-1, dan E-4.
- Server contoh memakai data di memori. Daftar proyek (pengganti D-1) dan token (pengganti F-1) adalah mock. Belum ada database dan belum terintegrasi dengan kelompok lain.
- Kode 403, 422, dan 503 ada di spesifikasi tetapi belum diuji pada server.
