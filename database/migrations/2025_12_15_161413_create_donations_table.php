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
        Schema::create('donations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('donor_name')->nullable();
            $table->string('member_id');
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending', 'paid', 'failed']);
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('payment_id')->references('id')->on('payments')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
