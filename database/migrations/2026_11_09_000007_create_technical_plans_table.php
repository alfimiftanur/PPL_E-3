<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technical_plans', function (Blueprint $table) {
            $table->id('estimate_id');
            $table->unsignedBigInteger('baseline_id');
            $table->unsignedBigInteger('row_id');
            $table->decimal('estimate_hours', 8, 2);
            $table->string('estimated_by', 64);
            $table->timestamps();

            $table->foreign('baseline_id')->references('baseline_id')->on('baselines')->onDelete('cascade');
            $table->foreign('row_id')->references('row_id')->on('baseline_matrix_rows')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technical_plans');
    }
};
