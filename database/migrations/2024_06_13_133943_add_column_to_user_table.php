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
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('phone');
            $table->string('photo')->nullable();
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->unsignedBigInteger('social_media_id')->nullable();
            $table->foreignId('role_id')->constrained('role')->onDelete('cascade');
            $table->foreign('social_media_id')->references('id')->on('social_media')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['social_media_id']);

            $table->dropColumn('address');
            $table->dropColumn('phone');
            $table->dropColumn('photo');
            $table->dropColumn('social_media_id');
            $table->dropColumn('role_id');
        });
    }
};
