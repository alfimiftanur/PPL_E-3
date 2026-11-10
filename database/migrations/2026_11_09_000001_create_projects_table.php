<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('project_id')->primary();
            $table->string('canonical_code', 64)->nullable();
            $table->string('project_name', 255);
            $table->string('client_name', 255);
            $table->string('client_division', 255)->nullable();
            $table->string('intake_status', 64)->default('diterima PM');
            $table->date('handover_date')->nullable();
            $table->string('pm_name', 255)->nullable();
            $table->string('pm_employee_id', 64)->nullable();
            $table->string('pm_user_id', 64)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
