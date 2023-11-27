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
        Schema::create('users', function (Blueprint $table) {
           $table->id();
           $table->string('username')->unique();
           $table->string('mobile')->unique();
           $table->string('email')->nullable();
           $table->integer('parent_id');
           $table->decimal('wallet',20,3)->default(0);
           $table->integer('otp')->nullable();
           $table->timestamps();
           $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
