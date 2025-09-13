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
        Schema::create('kontens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_koten_id');
            $table->foreign('kategori_koten_id')->references('id')->on('kategori_kotens')->onDelete('cascade');
            $table->string('title');
            $table->text('body');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->string('author')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontens');
    }
};
