<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('family_number_id');
            $table->string('name');
            $table->string('district');
            $table->string('income')->nullable();
            $table->string('spending')->nullable();
            $table->string('job')->nullable();
            $table->string('disability_type')->nullable();
            $table->string('residence_condition')->nullable();
            $table->string('electricity_capacity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
