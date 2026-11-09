<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mom_kickoffs', function (Blueprint $table) {
            $table->id('mom_id');
            $table->unsignedBigInteger('kickoff_id');
            $table->string('mom_attachment', 255)->nullable();
            $table->string('status', 32)->default('IN_PROGRESS'); // IN_PROGRESS, COMPLETED
            $table->timestamp('completed_at')->nullable();
            $table->string('recorded_by', 64)->nullable();
            $table->timestamps();

            $table->foreign('kickoff_id')->references('kickoff_id')->on('kickoffs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mom_kickoffs');
    }
};
