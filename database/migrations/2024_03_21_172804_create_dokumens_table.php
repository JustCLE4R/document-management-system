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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('Kategoris')->onDelete('cascade');
            $table->string('name');
            $table->string('sub_kategori')->nullable()->default('-');
            $table->text('catatan')->nullable();
            $table->string('tipe');
            $table->string('path');
            $table->enum('status', ['private', 'share', 'borrow'])->default('private');
            $table->unsignedBigInteger('borrow_from')->nullable();
            $table->foreign('borrow_from')->references('id')->on('dokumens')->nullOnDelete();

            // for statistic
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('revisions')->default(0);

            // timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
