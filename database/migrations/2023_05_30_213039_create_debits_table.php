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
        Schema::create('debits', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('external_id');
            $table->unsignedInteger('customer_id');
            $table->decimal('amount', 10, 2);
            $table->string('paid_by')->nullable();
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('due_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debits');
    }
};
