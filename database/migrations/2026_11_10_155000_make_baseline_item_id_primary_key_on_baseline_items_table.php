<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('baseline_items', 'id')) {
            $rows = DB::table('baseline_items')->get()->map(function ($r) {
                return [
                    'baseline_item_id' => $r->baseline_item_id,
                    'baseline_id' => $r->baseline_id,
                    'project_id' => $r->project_id,
                    'name' => $r->name,
                    'type' => $r->type,
                    'created_at' => $r->created_at,
                    'updated_at' => $r->updated_at,
                ];
            })->toArray();

            Schema::dropIfExists('baseline_items');

            Schema::create('baseline_items', function (Blueprint $table) {
                $table->string('baseline_item_id', 64)->primary();
                $table->unsignedBigInteger('baseline_id');
                $table->uuid('project_id');
                $table->string('name', 255);
                $table->enum('type', ['SCOPE', 'TIMELINE'])->default('SCOPE');
                $table->timestamps();

                $table->foreign('baseline_id')->references('baseline_id')->on('baselines')->onDelete('cascade');
                $table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade');
            });

            if (! empty($rows)) {
                DB::table('baseline_items')->insert($rows);
            }
        }
    }

    public function down(): void
    {
        // No reversal needed for surrogate key drop
    }
};
