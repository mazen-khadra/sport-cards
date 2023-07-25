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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('to_user_id');
            $table->unsignedBigInteger('creat_by_user_id');
            $table->boolean('is_accepted')->default(false);

            $table->timestamps();


            $table->foreign('to_user_id')->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('creat_by_user_id')->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
