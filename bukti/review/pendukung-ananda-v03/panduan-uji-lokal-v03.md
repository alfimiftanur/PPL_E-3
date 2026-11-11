# Panduan melengkapi bukti pengujian v0.3

Jalankan dari **repositori asli** E-3 pada branch yang akan dipakai untuk asesmen. Jangan menyalin klaim hasil tes dari arsip ini tanpa menjalankan ulang.

## Sebelum pengujian

Pada PowerShell, dari root proyek:

```powershell
git status --short
git branch --show-current
git rev-parse HEAD
php -v
```

Simpan branch dan commit yang keluar. Pastikan `vendor/` sudah tersedia dan `.env` sudah disiapkan; jangan memasukkan nilai `.env`, token, kata sandi, atau rahasia JWT ke folder `bukti/`.

## A. Jalankan uji Laravel

```powershell
php artisan test --filter=ApiContractTest
$hasilApi = $LASTEXITCODE
php artisan test --filter=ProjectWorkflowTest
$hasilWorkflow = $LASTEXITCODE
"Exit code API: $hasilApi; Workflow: $hasilWorkflow"
```

Jika ingin memeriksa khusus tambahan E-5:

```powershell
php artisan test --filter=test_api02_memuat_baseline_items_dan_target_progress_untuk_e5
$hasilE5 = $LASTEXITCODE
"Exit code E5: $hasilE5"
```

**Catatan:** `phpunit.xml` menetapkan `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`. Keberhasilan PHPUnit **bukan** bukti uji terhadap server MySQL. Catat ringkasan hasil apa adanya dalam dokumen verifikasi yang sudah ada, termasuk bila ada tes gagal; tidak perlu membuat berkas keluaran tambahan. Uji workflow dapat membuat/mengubah `storage/app/workflow_state.json`; cadangkan lalu pulihkan file state bila berisi data yang masih diperlukan.

## B. Pemeriksaan struktur MySQL aktual (jika sudah ada database uji)

Jangan menjalankan `migrate:fresh` pada database yang berisi data penting. Gunakan database uji atau backup jika akan memigrasi ulang.

```powershell
php artisan migrate:status
```

Dari klien SQL yang terhubung ke database MySQL proyek, jalankan query **baca saja** berikut dan catat hasil pemeriksaannya pada dokumen verifikasi yang sudah ada (tanpa kredensial):

```sql
SHOW COLUMNS FROM baseline_items;
SHOW KEYS FROM baseline_items WHERE Key_name = 'PRIMARY';
SHOW COLUMNS FROM project_plans LIKE 'target_progress';
SHOW CREATE TABLE baseline_matrix_rows;
```

Yang perlu terlihat: `baseline_item_id` sebagai PK, tidak ada kolom `id` di `baseline_items`, `target_progress` bertipe `json`, serta `baseline_matrix_rows.baseline_item_id` belum menjadi FK ke `baseline_items`.

## C. Pemeriksaan aturan P3 setelah implementasi Aufa

Penguncian baseline `APPROVED` **belum ada** dalam source code yang diperiksa. Setelah Aufa menerapkannya, mintakan dan jalankan skenario pengujian ini:

1. Simpan baseline `DRAFT` dan periksa perubahan tetap pada versi tersebut.
2. Setujui baseline, lalu coba simpan kembali: harus ditolak dengan `409 BASELINE_LOCKED` dan data lama tetap.
3. Coba mengubah status dengan simulator pada baseline `APPROVED`: harus ditolak/ditangani sesuai keputusan tim.
4. Jalankan aksi Buat Revisi Baseline: versi berikutnya `DRAFT`, versi lama `APPROVED` dan itemnya tetap.
5. Pastikan API E-5 tetap merujuk baseline `APPROVED` terbaru yang tersedia.

Jangan menuliskan lima skenario ini sebagai tes **lulus** sebelum hasilnya benar-benar tersedia.

## D. Setelah hasil siap

Perbarui `hasil-verifikasi-skema-v03-ananda.md` dan `bukti-verifikasi-skema-v03-ananda.txt` dengan tanggal, branch/commit sumber, perintah, status/angka tes, hasil pemeriksaan MySQL, dan cakupan yang belum diuji. Gunakan dokumen tersebut untuk melengkapi bukti tanpa membuat dokumen hasil uji terpisah. Lakukan review bersama Alfi.

Hash sumber aplikasi yang diuji dicatat sebagai acuan pengujian. Hash commit penambahan dokumen bukti dicatat terpisah setelah commit berhasil; keduanya mengidentifikasi perubahan yang berbeda.
