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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('book_name');
            $table->string('email')->nullable();;
            $table->string('author_name');
            $table->string('book_type');
            $table->string('book_category');
            $table->string('conclusion')->nullable();
            $table->string('cover_picture')->nullable();
            $table->date('finish_date')->nullable();
            $table->date('modify_date')->nullable();
            $table->string('book_title');
            $table->enum('status', ['pending', 'complete'])->default('pending');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
