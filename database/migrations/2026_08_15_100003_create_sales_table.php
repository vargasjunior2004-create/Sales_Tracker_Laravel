<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('clientCode', 40);
            $table->string('clientName', 160);
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('serviceType', 10);
            $table->string('requestType', 20)->default('nuevo_contrato');
            $table->string('changeReason', 120)->nullable()->default('');
            $table->string('planFrom', 60)->nullable()->default('');
            $table->decimal('totalFrom', 12, 2)->nullable();
            $table->string('notes', 255)->nullable()->default('');
            $table->decimal('total', 12, 2);
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('createdBy_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('lastEditedBy_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('lastEditedAt')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['date', 'id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
