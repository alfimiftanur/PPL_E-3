<?php
/**
 * Pemeriksaan statis Skema Data E-3 v0.3.
 * Jalankan dari root repositori: php bukti/review/pendukung-ananda-v03/cek-skema-v03.php
 * Tidak membutuhkan vendor/, tidak membuka DB, dan tidak mengubah data.
 */
$root = dirname(__DIR__, 3);
function src(string $path): string {
    global $root;
    $file = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path);
    if (!is_file($file)) { fwrite(STDERR, "BERKAS TIDAK DITEMUKAN: {$path}\n"); exit(2); }
    return file_get_contents($file);
}
function has(string $path, string $needle): bool { return str_contains(src($path), $needle); }
function lacks(string $path, string $needle): bool { return !has($path, $needle); }
$items = 'database/migrations/2026_11_09_000004_create_baseline_items_table.php';
$matrix = 'database/migrations/2026_11_09_000005_create_baseline_matrix_rows_table.php';
$plans = 'database/migrations/2026_11_09_000006_create_project_plans_table.php';
$modelItem = 'app/Models/BaselineItem.php';
$modelPlan = 'app/Models/ProjectPlan.php';
$seeder = 'database/seeders/DatabaseSeeder.php';
$api = 'app/Services/ProjectData.php';
$tests = 'tests/Feature/ApiContractTest.php';
$workflow = 'app/Services/ProjectWorkflowService.php';
$checks = [
  ['S-01', 'baseline_items memakai baseline_item_id sebagai PK string(64)', has($items, "\$table->string('baseline_item_id', 64)->primary()")],
  ['S-02', 'migration awal baseline_items tidak membuat kolom id', lacks($items, "\$table->id(")],
  ['S-03', 'baseline_items memiliki FK baseline_id dan project_id', has($items, "\$table->foreign('baseline_id')") && has($items, "\$table->foreign('project_id')")],
  ['S-04', 'baseline_items membatasi type SCOPE/TIMELINE', has($items, "\$table->enum('type', ['SCOPE', 'TIMELINE'])")],
  ['S-05', 'model BaselineItem memakai PK non-incrementing bertipe string', has($modelItem, "protected \$primaryKey = 'baseline_item_id'") && has($modelItem, 'public $incrementing = false') && has($modelItem, "protected \$keyType = 'string'")],
  ['S-06', 'baseline_matrix_rows.baseline_item_id nullable, bukan FK ke baseline_items', has($matrix, "\$table->string('baseline_item_id', 64)->nullable()") && lacks($matrix, "->on('baseline_items')")],
  ['S-07', 'project_plans.target_progress bertipe JSON nullable', has($plans, "\$table->json('target_progress')->nullable()")],
  ['S-08', 'model ProjectPlan melakukan cast target_progress ke array', has($modelPlan, "'target_progress' => 'array'")],
  ['S-09', 'seeder mengisi baseline_item_id dan target_progress', has($seeder, "'baseline_item_id' => \$item['baselineItemId']") && has($seeder, "'target_progress' => \$p['targetProgress'] ?? []")],
  ['S-10', 'planning-references memilih baseline berstatus APPROVED', has($api, "->where('status', 'APPROVED')")],
  ['S-11', 'planning-references memuat baselineItems dan targetProgress', has($api, "'baselineItems' =>") && has($api, "'targetProgress' =>")],
  ['S-12', 'pengujian kontrak E-5 tersedia dalam source', has($tests, 'test_api02_memuat_baseline_items_dan_target_progress_untuk_e5')],
  ['S-13', 'konfigurasi unit test memakai SQLite in-memory', has('phpunit.xml', 'name="DB_CONNECTION" value="sqlite"') && has('phpunit.xml', 'name="DB_DATABASE" value=":memory:"')],
];
$passed = 0;
foreach ($checks as [$id, $desc, $ok]) {
    echo sprintf("%-5s %-6s %s\n", $id, $ok ? 'SESUAI' : 'GAGAL', $desc);
    if ($ok) ++$passed;
}
echo "TOTAL: {$passed}/" . count($checks) . " pemeriksaan statis sesuai.\n";
echo "CATATAN: Verifikasi ini hanya membaca source code, bukan menjalankan migration, endpoint, atau test Laravel.\n";
echo "CATATAN: Keputusan penguncian APPROVED belum bisa dinyatakan terimplementasi; periksa saveBaseline()/setSimulatorMode().\n";
exit($passed === count($checks) ? 0 : 1);
