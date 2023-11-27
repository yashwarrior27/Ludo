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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->foreignId('created_id')->references('id')->on('users');
            $table->foreignId('accepted_id')->nullable()->references('id')->on('users');
            $table->decimal('amount',20,3);
            $table->integer('room_code')->nullable();
            $table->enum('status',[0,1,2,3,4])->default(0)->comment('0=>matching,1=>start,2=>ongoing,3=>complete,4=>canceled');
            $table->text('comment')->nullable();
            $table->foreignId('winner_id')->nullable()->references('id')->on('users');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
