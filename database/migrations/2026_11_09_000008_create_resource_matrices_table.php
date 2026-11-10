<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resource_matrices', function (Blueprint $table) {
            $table->id('resource_id');
            $table->uuid('project_id');
            $table->string('role', 64);
            $table->string('person_name', 255);
            $table->boolean('is_dummy')->default(true);
            $table->string('employee_id', 64)->nullable();
            $table->string('module', 255);
            $table->unsignedInteger('allocation_percent')->default(100);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('updated_by', 64)->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resource_matrices');
    }
};
