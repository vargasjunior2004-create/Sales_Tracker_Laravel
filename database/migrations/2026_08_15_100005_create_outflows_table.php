<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outflows', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('personName', 160);
            $table->decimal('amount', 12, 2);
            $table->string('concept', 255)->nullable()->default('');
            $table->foreignId('createdBy_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->index('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outflows');
    }
};
