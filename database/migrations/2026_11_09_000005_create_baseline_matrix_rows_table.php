<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baseline_matrix_rows', function (Blueprint $table) {
            $table->id('row_id');
            $table->unsignedBigInteger('baseline_id');
            $table->string('baseline_item_id', 64)->nullable();
            $table->string('matrix_type', 32); // scope, deliverable, timeline
            $table->string('module', 255);
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('pic_role', 64);
            $table->timestamps();

            $table->foreign('baseline_id')->references('baseline_id')->on('baselines')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baseline_matrix_rows');
    }
};
