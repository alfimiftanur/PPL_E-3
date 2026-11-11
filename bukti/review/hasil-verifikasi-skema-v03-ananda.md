# Catatan Perancangan dan Verifikasi Skema Data E-3 v0.3

**Nama:** Ananda Rizky Maulana  
**Kelompok:** E-3 / Kelas E  
**Acuan:** Dokumen 03 — Skema Data Awal E-3 v0.3 (10 November 2026)  
**Bahan pemeriksaan:** arsip `PPL_E-3-dev.zip` dan checkout repositori `dev` pada 11 November 2026  
**Commit sumber aplikasi:** `0acbab92d39fa0afdff242ae9d772db67198007d`  
**Pelaksana perancangan dan dokumentasi:** Ananda  
**Implementasi migration/model Laravel:** Aufa  
**Pemeriksaan hasil tim:** Alfi (PM)

## Pekerjaan yang ditinjau

Saya bertanggung jawab menyusun rancangan skema data E-3 beserta Dokumen 03, mulai dari penentuan entitas, atribut, tipe data, primary key, foreign key, relasi, sampai aturan proses. Dokumen berkembang dari v0.1/v0.2 menjadi v0.3 karena penyesuaian penyimpanan MySQL dan kebutuhan kelompok E-5. Implementasi ke kode Laravel dikerjakan oleh Aufa, lalu saya memeriksa kesesuaiannya dengan rancangan. Hasil pekerjaan tetap melalui review Alfi selaku PM.

Catatan v0.2 dan pengujian lama tetap tersedia di `hasil-verifikasi-skema-ananda.md`, `bukti-verifikasi-skema-ananda.txt`, dan `pendukung-ananda/hasil-uji-lokal.txt`. Berkas ini menambah pemeriksaan untuk v0.3, bukan menggantikan bukti lama.

## Hasil pemeriksaan v0.3

| No. | Bagian | Hasil pemeriksaan |
|---|---|---|
| V3-01 | Struktur entitas | Dokumen 03 v0.3 memuat sepuluh entitas utama E-3 serta Item Baseline sebagai sub-entitas pendukung E-5. Migration tabel-tabel terkait ditemukan dalam arsip source code. **Sesuai secara struktur berkas.** |
| V3-02 | Primary key Item Baseline | Migration `create_baseline_items_table.php` memakai `baseline_item_id` string(64) sebagai PK, tanpa kolom `id`. Model `BaselineItem.php` menggunakan PK yang sama dengan `incrementing=false` dan `keyType=string`. **Sesuai.** |
| V3-03 | Relasi Item Baseline | `baseline_items` memiliki `baseline_id` dan `project_id` sebagai FK lokal, sesuai dokumen terbaru. Usulan menghapus `projectId` belum diterapkan sehingga field tetap ditulis di Dokumen 03. **Sesuai dengan implementasi yang diperiksa.** |
| V3-04 | Item Baseline vs Baris Matriks | `baseline_matrix_rows.baseline_item_id` masih string nullable dan belum FK ke `baseline_items`. Kode matriks seperti `MOD-ENG-001` tidak sama dengan UUID item E-5. Perbedaan ini sudah dijelaskan dalam dokumen. **Sesuai, tetapi belum ada penyatuan referensi.** |
| V3-05 | Target progres E-5 | Migration `project_plans` memiliki `target_progress` JSON nullable dan model `ProjectPlan` memakai cast array. Seeder serta respons `planningReferences()` juga memuat `targetProgress`. **Sesuai secara struktur dan pemetaan kode.** |
| V3-06 | Kontrak API-K-E3-02 | `ProjectData.php` mengambil baseline `APPROVED`, `baselineItems`, dan `targetProgress`. Test `test_api02_memuat_baseline_items_dan_target_progress_untuk_e5()` lulus bersama suite kontrak API. Pembacaan service MySQL menghasilkan 4 item baseline dan 5 target progres yang cocok dengan database. **Sesuai pada pengujian kontrak dan pembacaan service; alur tulis MySQL end-to-end belum diuji.** |
| V3-07 | Rancangan penguncian baseline | Keputusan tim: `DRAFT` boleh diubah; `APPROVED` dikunci; perubahan melalui revisi versi baru tanpa menimpa versi lama. Dalam `saveBaseline()` masih ada perubahan status menjadi `DRAFT` dan penghapusan/pembuatan ulang baris; `setSimulatorMode()` juga dapat mengubah status. **Rancangan sudah didokumentasikan, implementasi belum selesai.** |
| V3-08 | Identitas F-1 dan penyimpanan | Dokumentasi menggunakan `accountId` sebagai identitas resmi F-1. Middleware API sudah memverifikasi JWT dan role; atribut audit di workflow masih menggunakan ID PM mock. `phpunit.xml` menggunakan SQLite in-memory; alur UI masih memiliki state JSON. **Batasan implementasi dicatat, tidak dianggap selesai seluruhnya.** |

## Pemeriksaan source code yang dijalankan

Pemeriksaan pada arsip source code dilakukan tanpa mengubah file aplikasi:

- **13/13 pemeriksaan statis sesuai** melalui `pendukung-ananda-v03/cek-skema-v03.php` (mengecek definisi migration, model, seeder, pemetaan API, dan keberadaan test E-5).
- **10 file PHP** yang terkait pemeriksaan lolos `php -l` tanpa kesalahan sintaks.
- Keluaran pemeriksaan disimpan pada `pendukung-ananda-v03/hasil-pemeriksaan-statis-v03.txt`.

Pemeriksaan awal pada arsip terbatas pada isi berkas dan sintaks PHP karena dependensi, database, dan metadata Git tidak tersedia di lingkungan arsip. Pemeriksaan lanjutan pada checkout repositori dengan dependensi dan database tersedia dijelaskan di bawah.

## Pengujian aplikasi dan pemeriksaan database

Pengujian dilakukan pada **11 November 2026**, branch `dev`, commit sumber `0acbab92d39fa0afdff242ae9d772db67198007d`, menggunakan **PHP 8.4.14**. Hash tersebut mengidentifikasi kode aplikasi yang diperiksa, bukan commit penambahan dokumen bukti v0.3.

| Pengujian | Hasil |
|---|---|
| Pemeriksaan statis skema | 13/13 sesuai; exit code 0 |
| Pemeriksaan sintaks PHP | 10 berkas lolos |
| `ApiContractTest` dan `ProjectWorkflowTest` | **20 tes lulus, 132 assertions; exit code 0** |
| Struktur MySQL 8.4.13 | PK/FK terkait sesuai; `target_progress` bertipe JSON nullable |
| Status migration | Seluruh 14 migration lokal tercatat; tidak ada migration tertunda |
| Pembacaan service E-5 | `baselineId`, `planId`, 4 item baseline, dan 5 target progres cocok dengan database |
| Migration dari database kosong, MySQL 8.0.30 | **14/14 migration selesai**, kondisi awal 0 tabel; exit code 0 |
| Seeder pada database baru | Berhasil dijalankan; jumlah baris sesuai seed, tetapi ditemukan ketidaksesuaian relasi antarproyek |

Suite dijalankan melalui `php artisan test --filter="ApiContractTest|ProjectWorkflowTest" --do-not-cache-result --no-ansi`. Hasilnya juga dikonfirmasi melalui runner `vendor/phpunit/phpunit/phpunit` dengan filter yang sama dan ekstensi SQLite aktif pada konfigurasi PHP CLI sementara. Sebelas tes berasal dari `ApiContractTest`, termasuk tambahan E-5, dan sembilan tes berasal dari `ProjectWorkflowTest`.

Pemeriksaan MySQL pada database `ppl_e3` mengonfirmasi `baseline_items.baseline_item_id` sebagai PK tunggal `varchar(64)` tanpa kolom `id`; FK `baseline_id` ke `baselines` dan `project_id` ke `projects`; serta enum `type` berisi `SCOPE`/`TIMELINE`. `baseline_matrix_rows.baseline_item_id` belum menjadi FK ke `baseline_items`, sesuai batasan rancangan. Pembacaan `ProjectData::planningReferences()` untuk proyek contoh mencatat empat kueri MySQL berhasil dan hasil yang cocok dengan pembacaan tabel langsung.

**Batas pengujian:** PHPUnit memakai SQLite in-memory sesuai `phpunit.xml`. Suite tidak menjalankan migration/seeder dan layanan dapat memakai fixture JSON ketika tabel belum tersedia. Hasil suite tersebut tidak dianggap sebagai bukti pengujian tulis MySQL. Pemeriksaan awal struktur dan pembacaan service MySQL dilakukan terpisah dengan kueri baca saja dalam transaksi read-only. Uji migration/seeder dari database kosong kemudian dilakukan pada database uji tersendiri seperti dijelaskan di bawah. State JSON setelah pengujian dikembalikan ke kondisi sebelumnya. Ringkasan hasil dicatat langsung dalam dokumen ini tanpa membuat berkas hasil uji tambahan.

## Uji migration dan seeder dari database kosong

Dilakukan pada **11 November 2026, 15:46:39–15:46:41 WIB**, menggunakan **PHP 8.4.14 dan MySQL 8.0.30**. Database uji baru bernama `ppl_e3_migration_test_20261111_154639`. Keberadaan database diperiksa sebelum dibuat; jumlah tabel sebelum migration adalah **0**. Konfigurasi database diarahkan ke database uji hanya untuk proses pengujian. Database aplikasi `ppl_e3` dan berkas `.env` tidak diubah.

Perintah `migrate:fresh --database=mysql --seed --force --no-interaction` dijalankan melalui Artisan. Seluruh **14 migration selesai**, seeder selesai, **exit code 0**, dan tidak ada migration tertunda. Pemeriksaan struktur memastikan PK `baseline_item_id`, tidak adanya kolom `id`, serta `target_progress` bertipe JSON nullable. Tidak ditemukan item baseline yang merujuk baseline atau proyek yang tidak ada.

| Tabel | Jumlah setelah seeder | Kesesuaian jumlah |
|---|---|---|
| `projects` | 5 | Sesuai |
| `initial_analyses` | 1 | Sesuai |
| `baselines` | 5 | Sesuai |
| `baseline_items` | 4 | Sesuai |
| `baseline_matrix_rows` | 15 | Sesuai |
| `project_plans` | 5 | Sesuai |
| `kickoffs` | 5 | Sesuai |
| `mom_kickoffs` | 5 | Sesuai |
| `resource_matrices` | 5 | Sesuai |
| `raci_templates` | 23 | Sesuai |
| `technical_plans`, `kickoff_approvals`, `sessions` | 0 masing-masing | Belum diisi oleh seeder |

**Temuan konsistensi data seed:**

1. `project_plans.baseline_id` selalu diisi `301` oleh `DatabaseSeeder`, sehingga empat plan berbeda dari fixture `data/seed.json`: plan `402` seharusnya memakai baseline `302`; plan `403` memakai `303`; plan `404` dan `405` memakai `304`. Empat relasi plan–baseline tersebut menghubungkan proyek berbeda.
2. `kickoffs.plan_id` selalu diisi `401`, sehingga empat kickoff terhubung ke plan milik proyek berbeda.
3. `baselines.analysis_id` selalu diisi `1`, sedangkan analisis tersebut hanya milik satu proyek. Empat baseline terhubung ke analisis milik proyek berbeda.

FK tetap dapat menerima ID tersebut karena baris yang dirujuk ada. Namun, kesesuaian pemilik proyek belum terjaga. Karena itu, hasil dinyatakan **migration dan eksekusi seeder lulus; konsistensi relasi data seed belum lulus**. Temuan perlu ditangani pada seeder, lalu diuji kembali sebelum menyatakan seluruh data contoh sesuai. Kode seeder belum diubah dalam pengujian ini.

Pembacaan service E-5 setelah seeding untuk proyek contoh menghasilkan baseline `301`, plan `401`, **4 item baseline**, dan **5 target progres**, dengan empat kueri MySQL berhasil. Hasil untuk proyek contoh tersebut tidak menutup temuan relasi pada proyek lainnya. Database uji dipertahankan agar hasil dapat diperiksa kembali.

## Catatan untuk tindak lanjut

1. **P3 — Baseline APPROVED:** implementasi penguncian, pembuatan versi baru, dan test penolakannya merupakan pekerjaan backend Aufa, kemudian diperiksa Alfi. Saya sudah mencatatnya sebagai rancangan yang disepakati, bukan fitur yang selesai.
2. **E-5:** pengujian kontrak API dan pembacaan service MySQL sudah lulus. Penyimpanan melalui workflow MySQL dan pemanggilan HTTP layanan antarkelompok secara end-to-end belum diuji dalam sesi ini.
3. **Data contoh:** `data/seed.json` masih memuat contoh Item Baseline domain rumah sakit, sedangkan README proyek menyebut konteks ERP. Contoh perlu diselaraskan jika dipakai untuk demo akhir; ini bukan alasan mengubah PK/FK.
4. **Versi repo untuk laporan:** checkout `dev` pada commit `0acbab9` sudah memuat merge migrasi MySQL. Keterangan laporan asesmen yang masih menyebut belum merge perlu disesuaikan dengan versi kode yang akan digunakan.
5. **Dokumen acuan dan review:** Dokumen 03 v0.3 dan Dokumen Asesmen 1 asli tidak tersedia pada berkas repositori yang diperiksa. Kesesuaian seluruh atribut, perubahan istilah `akunId` pada bukti v0.2 menjadi `accountId` pada v0.3, serta persetujuan PM masih perlu dicocokkan dengan dokumen acuan terbaru. Hasil pengujian tidak menggantikan review Alfi.
6. **Seeder dan aturan proses:** migration/seeder dari database kosong sudah dijalankan. Perbaikan relasi antarproyek pada seeder masih diperlukan, kemudian hasilnya diuji kembali. Aturan penguncian/revisi baseline belum diuji karena implementasinya belum selesai, sehingga belum dapat dinyatakan lulus.

## Kesimpulan

Struktur Item Baseline dan target progres E-5 **sesuai pada source code dan database yang diperiksa**. Sebanyak **20 tes dengan 132 assertions lulus**, dan pembacaan service E-5 cocok dengan data MySQL. Migration serta eksekusi seeder dari database kosong berhasil, tetapi konsistensi relasi data seed antarproyek **belum lulus**. Penguncian baseline `APPROVED` **baru berupa keputusan rancangan** dan belum dinyatakan selesai. Perbaikan seeder, pencocokan dengan Dokumen 03 asli, pengujian yang belum tercakup, serta review PM tetap perlu dilengkapi sebelum bukti digunakan untuk asesmen.
