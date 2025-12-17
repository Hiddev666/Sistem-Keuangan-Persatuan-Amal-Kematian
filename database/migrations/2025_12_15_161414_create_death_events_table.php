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
        Schema::create('death_events', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('member_id');
            $table->date('date_of_death');
            $table->string('heir_name');
            $table->text('heir_address');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('member_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('death_events');
    }
};
