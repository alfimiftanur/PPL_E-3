<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kickoff_approvals', function (Blueprint $table) {
            $table->id('approval_id');
            $table->unsignedBigInteger('mom_id');
            $table->string('participant_name', 255);
            $table->string('participant_role', 128)->nullable();
            $table->string('user_id', 64)->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->foreign('mom_id')->references('mom_id')->on('mom_kickoffs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kickoff_approvals');
    }
};
