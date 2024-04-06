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
        Schema::create('response__bodies', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('data_type');
            $table->longText('description');
            $table->unsignedBigInteger('response_id')->nullable();
            $table->foreign('response_id')->references('id')->on('responses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response__bodies');
    }
};
