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
        Schema::create('tb_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelanggan_id');
            $table->unsignedBigInteger('waiter_id')->nullable();
            $table->enum('status', ['pembayaran', 'disajikan', 'selesai'])->default('pembayaran');
            $table->timestamps();

            $table->foreign('pelanggan_id')->references('id')->on('tb_user')->onDelete('cascade');
            $table->foreign('waiter_id')->references('id')->on('tb_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_order');
    }
};
