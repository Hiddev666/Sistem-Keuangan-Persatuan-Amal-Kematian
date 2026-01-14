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
        Schema::create('contributions', function (Blueprint $table) {
            $table->increments('id');
            $table->string(column: 'family_card_id');
            $table->unsignedBigInteger('death_event_id')->nullable();
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending', 'paid', 'failed', 'expired']);
            $table->integer('payment_id')->nullable();
            $table->timestamps();

            $table->foreign('family_card_id')->references('id')->on('family_cards');
            $table->foreign('payment_id')->references('id')->on('payments')->nullOnDelete();
            $table->foreign('death_event_id')->references('id')->on('death_events')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
