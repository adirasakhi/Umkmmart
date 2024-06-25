<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductClicksTable extends Migration
{
    public function up()
    {
        Schema::create('product_clicks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('device_id');
            $table->timestamp('clicked_at');
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('product_clicks');
    }
}
