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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('image')->nullable();
            // $table->integer('cookingtime')->nullable(true);
            // $table->integer('frozen_storage')->nullable(true);
            // $table->integer('cold_storage')->nullable(true);
            // $table->boolean('is_post')->nullable(true);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};