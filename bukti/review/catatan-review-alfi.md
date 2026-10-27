# Catatan review Alfi Mifta Nurhakim (E-3, Pertemuan 5)

Tanggal: 2026-10-27
Versi yang direview: commit `ddad94f` pada branch `dev`; `openapi.yaml` v0.2.0; `Laporan_Pertemuan_5_Operasi_Data_Validasi_dan_Endpoint.docx` v0.1

---

## 1. Menjalankan ulang alur B-01 sampai B-07 dan K-01 sampai K-05

Koleksi Postman `bukti/postman/E3_Pertemuan5.postman_collection.json` tidak ada di repo, sehingga alur diulang lewat request langsung dengan skrip `bukti/review/uji-ulang.ps1` (PowerShell, `Invoke-WebRequest`) pada mesin Alfi. `php artisan test` juga dijalankan ulang.

Cara menjalankan (dari data bersih):
1. Hapus `storage/app/workflow_state.json`, jalankan `php artisan serve`
2. B-01 sampai B-03 (Buat, Lihat, Ubah)
3. Hentikan dan jalankan ulang `php artisan serve`
4. B-04 sampai B-07 (Lihat ulang, kasus valid, kasus ditolak, cek data setelah ditolak)
5. K-01 sampai K-05 (API kontrak)

Hasil:

| Kelompok | Request | Lulus | Gagal |
|---|---|---|---|
| 1. Buat, Lihat, Ubah (B-01 sampai B-03) | 3 | 3 | 0 |
| 2. Setelah restart (B-04 sampai B-07) | 5 | 5 | 0 |
| 3. API kontrak (K-01 sampai K-05) | 5 | 5 | 0 |
| `php artisan test` | 19 test | 19 (95 assertions) | 0 |

Hal yang dicek, bukan hanya kode status: analysisId tetap 1; createdAt tidak berubah dan updatedAt berubah setelah Ubah; data tetap ada setelah restart server; respons 422 hanya memuat `errors.projectCondition`; updatedAt sama sebelum dan sesudah penolakan.

Bukti: `bukti/review/hasil-uji-ulang-alfi.txt` dan `bukti/review/uji-ulang.ps1`

## 2. Review isi

Format temuan: **lokasi → temuan → saran → kepada siapa**.

- Laporan, baris "Kesiapan endpoint" (bukti gagal) dan kontribusi Aufa/Alfi → laporan merujuk `bukti/postman/` dan koleksi B-01 sampai B-07, K-01 sampai K-05, tetapi folder dan berkas koleksi tidak ada di repo (branch `dev`, `ddad94f`) → push koleksi Postman ke `bukti/postman/`, atau ganti rujukan ke bukti yang ada → Aufa
- Laporan, "Repositori dan versi demo" → tertulis commit demo `cae80d6` (2026-10-21), padahal laporan memakai fitur dari commit setelahnya: perbaikan createdBy/createdAt (`3277254`, 2026-10-26) dan halaman Ringkasan Data (`ae6a99b`). Di `cae80d6` belum ada halaman `/projects/overview` → ganti versi demo menjadi `ddad94f` (atau commit yang dipakai saat demo 2026-10-26) → Aufa
- Laporan, catatan uji API B-06 dan "Versi kontrak yang dipakai" → tertulis endpoint initial-analysis "tidak ada di openapi.yaml" dan "tidak ada perubahan dari kesepakatan minggu 4". Kenyataannya, `openapi.yaml` di `ddad94f` sudah memuat `/initial-analysis` dan `/overview` (pesan commit: "perbarui spesifikasi openapi.yaml v0.2.0 dengan endpoint analisis awal, overview..."), tetapi versinya tetap 0.2.0 dan tanpa change log → putuskan apakah kedua endpoint memang bagian kontrak; jika ya, naikkan versi (mis. v0.3.0) dan tambahkan change log; jika tidak, keluarkan dari `openapi.yaml` → Aufa
- Laporan, review E-4 → ringkasan E-4 menyebut `readyForExecution` bergantung pada baseline APPROVED. Di `openapi.yaml` v0.2.0 ("true hanya bila status adalah COMPLETED") dan di kode (`app/Services/ProjectData.php`, `readyForExecution => $done`), nilainya hanya ditentukan status MoM. Catatan E-3 di laporan sudah benar → luruskan dengan E-4 sesuai rencana → Aufa
- Laporan, catatan uji API B-06 → tertulis header Authorization "disamarkan pada bukti", tetapi `bukti/curl/planning-references-curl-test.png` menampilkan `Bearer mock-token` apa adanya. Token ini fiktif sehingga tidak berbahaya, tetapi kalimatnya tidak akurat → ubah menjadi "token fiktif mock-token, bukan rahasia" → Aufa
- Laporan, "Instruksi menjalankan" → tautan README menunjuk branch `main`, sedangkan demo memakai `dev` → arahkan ke README di `dev` → Aufa
- Laporan, kontribusi Aditya (log komunikasi) → D-1, F-1, F-2, dan D-3 ditulis "Kebutuhan sudah terkonfirmasi", sedangkan bagian lain menyebut pertanyaan status endpoint D-1/F-1/F-2 belum dikirim dan D-3 belum mereview (OPEN-05). Kolom "Bukti" semuanya kosong → samakan pernyataannya (mis. "dokumen sudah dikirim, belum ada jawaban") dan lampirkan bukti chat dengan nomor disamarkan → Aditya
- Laporan, kontribusi Ananda → masih ada `[ISI: hash]` dan `[ISI: commit atau artefak; hasil uji]`. Selisih createdBy dan createdAt ditutup pada `3277254` → isi dengan `3277254` dan hasil perbandingan Dokumen 03 → Ananda
- Laporan, "Produsen dan konsumen" dan "Versi kontrak" → masih ada sisa teks templat "Isi dengan:" sebelum hash → hapus teks templat → Aufa

## 3. Pemeriksaan konsistensi laporan

- [ ] Hash commit sama di semua tempat dalam laporan. Belum: versi demo `cae80d6`, versi kontrak `ddad94f` (lihat bagian 2). Semua hash yang disebut ada di `origin/dev`.
- [ ] Nama berkas bukti di laporan ada di folder `bukti/`. Belum: `bukti/postman/` tidak ada. `bukti/operasi-crud/`, `bukti/curl/`, `bukti-mock.md`, dan `bukti/test/` ada.
- [x] Setiap hasil B-01 sampai B-07 punya screenshot (`bukti/operasi-crud/B-01-Buat.png` sampai `B-07-Cek-Data-Setelah-Ditolak.png`)
- [ ] Status F-1, F-2, D-1 sesuai jawaban mereka. Belum: tidak konsisten dan tanpa bukti (lihat bagian 2).
- [x] Tidak ada token atau data rahasia pada screenshot yang diperiksa (`bukti/curl/planning-references-curl-test.png`, `bukti/operasi-crud/B-06-Kasus-Ditolak.png`). Hanya ada `mock-token` fiktif.
- [ ] Tidak ada `[ISI]` atau `[KONFIRMASI]` tersisa di laporan. Belum: `[KONFIRMASI]` pada baris Alfi, `[ISI]` pada baris Ananda.

## 4. Kesimpulan

Alur B-01 sampai B-07, K-01 sampai K-05, dan `php artisan test` (19 passed / 95 assertions) lulus semua di mesin Alfi dari data bersih. Laporan masih perlu diperbaiki sebelum dikumpulkan: koleksi Postman yang dirujuk tidak ada di repo, versi demo dan versi kontrak tidak konsisten, dan masih ada sisa isian templat. Temuan diteruskan ke Aufa, Aditya, dan Ananda.
