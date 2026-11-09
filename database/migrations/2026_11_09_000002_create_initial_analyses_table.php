<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('initial_analyses', function (Blueprint $table) {
            $table->id('analysis_id');
            $table->uuid('project_id')->unique();
            $table->text('project_need');
            $table->text('project_condition');
            $table->string('status', 64)->default('Tersimpan');
            $table->boolean('is_saved')->default(false);
            $table->string('created_by', 64)->nullable();
            $table->string('updated_by', 64)->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('initial_analyses');
    }
};
