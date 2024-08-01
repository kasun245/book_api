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
        Schema::create('usertable', function (Blueprint $table) {
            $table->id();
            $table->string('userid');
            $table->string('username');
            $table->string('usermobileno');
            $table->string('email');
            $table->string('password');
            $table->string('date');
            $table->string('time');
            $table->string('usertype');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usertable');
    }
};
