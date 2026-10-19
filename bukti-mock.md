# Bukti mock berjalan (Prism)

Perintah: `npx @stoplight/prism-cli mock openapi.yaml -p 4010`
Header: `Authorization: Bearer mock-token`. Hasil diambil 2026-10-19.

## API-K-E3-01 (execution-readiness)
```
## 200 siap (default example)
{"projectId":"01924b1e-7f32-7a81-9b12-45e8a1234567","kickoffId":"101","momId":"201","status":"COMPLETED","completedAt":"2026-10-16T11:00:00+07:00","readyForExecution":true}
[HTTP 200]
## 200 belumSiap
{"projectId":"01924b1e-7f32-7a81-9b12-45e8a1234567","kickoffId":"101","momId":"201","status":"IN_PROGRESS","completedAt":null,"readyForExecution":false}
[HTTP 200]
## 404
{"code":"PROJECT_NOT_FOUND","message":"Proyek tidak ditemukan."}
[HTTP 404]
## projectId bukan UUID v7 (400)
{"code":"INVALID_PROJECT_ID_FORMAT","message":"Format projectId tidak valid.","details":["projectId harus berformat UUID v7"]}
[HTTP 400]
## tanpa token (401)
{"code":"UNAUTHENTICATED","message":"Token tidak ada atau tidak valid."}
[HTTP 401]
```

## API-K-E3-02 (planning-references)
```
## 200 lengkap (default example)
{"projectId":"01924b1e-7f32-7a81-9b12-45e8a1234567","baselineId":"301","baselineVersion":1,"approvedAt":"2026-10-14T10:00:00+07:00","planId":"401"}
[HTTP 200]
## 200 kosong
{"projectId":"01924b1e-7f32-7a81-9b12-45e8a1234568","baselineId":null,"baselineVersion":null,"approvedAt":null,"planId":null}
[HTTP 200]
## 404
{"code":"PROJECT_NOT_FOUND","message":"Proyek tidak ditemukan."}
[HTTP 404]
## projectId bukan UUID v7 (400)
{"code":"INVALID_PROJECT_ID_FORMAT","message":"Format projectId tidak valid.","details":["projectId harus berformat UUID v7"]}
[HTTP 400]
## tanpa token (401)
{"code":"UNAUTHENTICATED","message":"Token tidak ada atau tidak valid."}
[HTTP 401]
```
