<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_plans', function (Blueprint $table) {
            $table->id('plan_id');
            $table->uuid('project_id');
            $table->date('planned_date')->nullable();
            $table->date('due_date_h1')->nullable();
            $table->unsignedBigInteger('baseline_id')->nullable();
            $table->text('scope_section')->nullable();
            $table->text('deliverable_section')->nullable();
            $table->text('timeline_section')->nullable();
            $table->text('roadmap_section')->nullable();
            $table->json('target_progress')->nullable(); // array of {date: string, progress: int}
            $table->string('updated_by', 64)->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade');
            $table->foreign('baseline_id')->references('baseline_id')->on('baselines')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_plans');
    }
};
