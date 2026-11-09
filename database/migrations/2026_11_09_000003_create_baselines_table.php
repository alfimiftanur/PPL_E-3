<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baselines', function (Blueprint $table) {
            $table->id('baseline_id');
            $table->uuid('project_id');
            $table->unsignedBigInteger('analysis_id')->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->date('baseline_date')->nullable();
            $table->string('status', 32)->default('DRAFT');
            $table->string('approved_by', 128)->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedTinyInteger('simulator_mode')->default(1);
            $table->boolean('is_complete')->default(true);
            $table->string('created_by', 64)->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade');
            $table->foreign('analysis_id')->references('analysis_id')->on('initial_analyses')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baselines');
    }
};
