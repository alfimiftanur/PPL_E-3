# Bukti mock berjalan (Prism)

Perintah: `npx @stoplight/prism-cli mock openapi.yaml -p 4010`
Header: `Authorization: Bearer mock-token`. Hasil diambil 2026-10-12.

```
## 200 (default example)
{"projectId":"PRJ-DEMO-001","kickoffId":"101","momId":"201","status":"selesai","completedAt":"2026-10-30T04:00:00Z","readyForExecution":true}
[HTTP 200]
## 200 belumSiap
{"projectId":"PRJ-DEMO-001","kickoffId":"101","momId":"201","status":"belum_selesai","completedAt":null,"readyForExecution":false}
[HTTP 200]
## 404
{"code":"PROJECT_NOT_FOUND","message":"Proyek tidak ditemukan."}
[HTTP 404]
## tanpa token
{"code":"UNAUTHENTICATED","message":"Token tidak ada atau tidak valid."}
[HTTP 401]
```
