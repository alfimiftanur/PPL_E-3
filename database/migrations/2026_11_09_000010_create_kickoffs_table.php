<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kickoffs', function (Blueprint $table) {
            $table->id('kickoff_id');
            $table->uuid('project_id');
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->text('agenda')->nullable();
            $table->text('material')->nullable();
            $table->string('created_by', 64)->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade');
            $table->foreign('plan_id')->references('plan_id')->on('project_plans')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kickoffs');
    }
};
