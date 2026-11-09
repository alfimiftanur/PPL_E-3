<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raci_templates', function (Blueprint $table) {
            $table->id('raci_id');
            $table->unsignedInteger('process_no');
            $table->string('process_name', 255);
            $table->string('role_code', 32);
            $table->string('raci_value', 8);
            $table->timestamps();

            $table->unique(['process_no', 'role_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raci_templates');
    }
};
