# Catatan Verifikasi Skema Data E-3

**Nama:** Ananda Rizky Maulana  
**Kelompok:** E-3 / Kelas E  
**Tanggal:** 28 Oktober 2026  
**Dokumen yang diperiksa:** Skema Data Awal E-3 v0.2 (27 Oktober 2026)

## Tujuan

Dokumen Skema Data Awal E-3 sudah diperbarui dari v0.1 menjadi v0.2. Pemeriksaan ini dilakukan untuk melihat apakah isi dokumen tersebut sudah menggambarkan data dan alur yang digunakan pada proyek E-3, terutama bagian analisis awal, baseline, dan project plan.

Pengecekan dilakukan dengan membandingkan dokumen, file JSON, kode penyimpanan dan validasi, serta kontrak API yang ada di repositori. Pemeriksaan kemudian dilengkapi dengan **pengujian Laravel lokal pada 28 Oktober 2026**. Hasil uji milik Alfi tetap digunakan sebagai pembanding terpisah.

## Hasil pemeriksaan

| No. | Bagian yang diperiksa | Hasil |
|---|---|---|
| U-01 | Data analisis awal | **Sesuai.** Sepuluh field `initialAnalysis` sudah tercantum pada dokumen. `projectId` juga sama dengan ID proyek yang sedang digunakan. |
| U-02 | Validasi isian analisis awal | **Sesuai berdasarkan kode dan test lokal.** Isian kosong ditolak dengan status 422 beserta pesan wajib isi untuk kedua field. Penyimpanan input valid juga lulus. |
| U-03 | Data saat dibuat dan diubah | **Sesuai berdasarkan bukti lama.** `createdAt` tetap, sedangkan `updatedAt` berubah ketika analisis diperbarui. Data juga tidak berubah setelah isian ditolak. |
| U-04 | Tipe ID dan referensi | **Sesuai untuk data yang sudah digunakan.** `analysisId`, `baselineId`, dan `planId` berupa string angka, `resourceId` pada data dummy berupa angka, sedangkan `projectId` memakai UUID v7. Ada catatan pada tipe referensi di entitas yang masih berupa rancangan. |
| U-05 | Baseline dan project plan | **Sesuai dengan kondisi yang ditulis di dokumen.** Matriks baseline tersimpan dalam array dan penyimpanan ulang belum membuat versi baru. Project plan sudah menyimpan tanggal rencana serta H-1, tetapi belum seluruh bagian perencanaan. |
| U-06 | Kontrak API dan sumber data | **Sesuai berdasarkan berkas dan test lokal.** Respons `execution-readiness` dan `planning-references` cocok dengan contoh JSON; skenario 200, 400, 401, dan 404 lulus. Data API kontrak dan workflow tetap berasal dari sumber berbeda. |

## Catatan hasil pemeriksaan

1. Pada file `workflow_state.json`, `initialAnalysis` memiliki 10 field: `analysisId`, `projectId`, `projectNeed`, `projectCondition`, `status`, `isSaved`, `createdBy`, `createdAt`, `updatedBy`, dan `updatedAt`. Dalam keadaan belum disimpan, statusnya `Belum dicatat` dan metadata waktunya masih `null`.
2. Bukti `state-setelah-buat.json` dan `state-setelah-ubah.json` menunjukkan bahwa `createdAt` tetap pada `2026-10-26 21:07:18 WIB`, sementara `updatedAt` berubah menjadi `2026-10-26 21:07:20 WIB`. Bukti tersebut berasal dari arsip pengujian sebelumnya, bukan pengujian baru.
3. Masih ada perbedaan tipe pada beberapa **relasi rancangan**, yaitu `planId` di entitas Kickoff dan `baselineId` di entitas Technical Plan yang tertulis `bigint`, sementara ID aktif yang dirujuk memakai string angka. Kedua bagian tersebut belum menjadi alur penyimpanan lengkap pada demo. Catatan ini tidak mengubah keputusan kelompok untuk menggunakan dokumen v0.2.
4. ID akun resmi pada kontrak F-1 adalah `akunId`, sedangkan data contoh E-3 masih menggunakan identitas PM mock. Integrasi langsung dengan F-1, F-2, dan D-1 belum dibuktikan dalam pemeriksaan ini.

## Pembanding dari hasil uji ketua kelompok

Sebagai pembanding, `bukti/review/hasil-uji-ulang-alfi.txt` mencatat hasil pengujian pada **mesin Alfi, 27 Oktober 2026**. Pengujian buat, ubah, validasi analisis awal, serta kedua endpoint kontrak dilaporkan lulus. Alfi juga mencatat **19 test lulus dengan 95 assertions**.

Hasil tersebut adalah **pengujian Alfi**, bukan hasil pengujian yang dijalankan sendiri dalam pemeriksaan dokumen ini.

## Kesimpulan

Secara umum, **Dokumen Skema Data Awal E-3 v0.2 sudah menggambarkan struktur data dan kondisi aplikasi saat ini**. Bagian yang belum selesai diimplementasikan juga sudah dijelaskan sebagai batasan atau rancangan, sehingga tidak dianggap sebagai fitur yang sudah berjalan.

Dokumen v0.2 digunakan sebagai **bukti kerja revisi dokumen**, sedangkan catatan ini dan `bukti-verifikasi-skema-ananda.txt` digunakan sebagai **bukti pengecekan kesesuaiannya**. Pengujian lokal tambahan lulus dan mendukung hasil pemeriksaan. Catatan tipe referensi pada bagian rancangan tetap disimpan sebagai bahan evaluasi berikutnya.

## Pengujian lokal tambahan

Kedua perintah berikut sudah dijalankan pada **28 Oktober 2026, pukul 16:02:05-16:02:09 WIB**, di branch `dev`, commit `bab2601538ed0f5d615139beac3cfecbd6d30004`, menggunakan PHP 8.4.14:

```powershell
php artisan test --filter=ApiContractTest
php artisan test --filter=ProjectWorkflowTest
```

| Pengujian | Hasil |
|---|---|
| `ApiContractTest` | 10 test lulus, 22 assertions; exit code 0 |
| `ProjectWorkflowTest` | 9 test lulus, 73 assertions; exit code 0 |
| **Total** | **19 test lulus, 95 assertions** |

Bukti ringkas dan keluaran terminal disimpan dalam satu file: [hasil-uji-lokal.txt](pendukung-ananda/hasil-uji-lokal.txt).

Test workflow juga memeriksa kesamaan `projectId`, normalisasi state lama, `createdAt` dan `createdBy` yang tetap saat pembaruan, perhitungan H-1 hari kerja, serta persetujuan baseline. Perubahan `updatedAt` dan data yang tetap setelah penolakan pada U-03 masih merujuk bukti lama; kedua hal tersebut tidak diperiksa khusus oleh test lokal ini.

Pengujian memakai aplikasi Laravel lokal tanpa server HTTP terpisah. Integrasi langsung F-1/F-2/D-1 dan persistensi setelah restart server belum diuji. Kode aplikasi tidak diubah. File `storage/app/workflow_state.json` belum ada sebelum uji; file yang dibuat test sudah dihapus untuk mengembalikan kondisi semula. Untuk pengujian berikutnya, tetap cadangkan state jika sudah ada.
