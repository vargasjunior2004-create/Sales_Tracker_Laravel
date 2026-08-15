<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('label', 120);
            $table->string('type', 10);
            $table->unsignedInteger('speed')->nullable();
            $table->decimal('monthly', 12, 2);
            $table->decimal('installation', 12, 2);
            $table->boolean('active')->default(true);
            $table->boolean('legacy')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
