<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baseline_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('baseline_id');
            $table->uuid('project_id');
            $table->string('baseline_item_id', 64);
            $table->string('name', 255);
            $table->enum('type', ['SCOPE', 'TIMELINE'])->default('SCOPE');
            $table->timestamps();

            $table->foreign('baseline_id')->references('baseline_id')->on('baselines')->onDelete('cascade');
            $table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baseline_items');
    }
};
