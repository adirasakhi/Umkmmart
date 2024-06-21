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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->longText('description');
            $table->string('image');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('seller_id');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['seller_id']);
        });

        Schema::dropIfExists('product');
    }
};
