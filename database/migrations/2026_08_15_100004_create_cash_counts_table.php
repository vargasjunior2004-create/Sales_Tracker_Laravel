<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_counts', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->unsignedSmallInteger('coin_050')->default(0);
            $table->unsignedSmallInteger('coin_1')->default(0);
            $table->unsignedSmallInteger('coin_2')->default(0);
            $table->unsignedSmallInteger('coin_5')->default(0);
            $table->unsignedSmallInteger('bill_10')->default(0);
            $table->unsignedSmallInteger('bill_20')->default(0);
            $table->unsignedSmallInteger('bill_50')->default(0);
            $table->unsignedSmallInteger('bill_100')->default(0);
            $table->unsignedSmallInteger('bill_200')->default(0);
            $table->foreignId('createdBy_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_counts');
    }
};
