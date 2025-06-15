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
        Schema::create('tb_order_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('menu_id');
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('tb_order')->onDelete('cascade');
            $table->foreign('menu_id')->references('id')->on('tb_menu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_order_item');
    }
};
