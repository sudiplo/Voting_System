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
        Schema::create('c_mayors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citizen_id')->constrained();
            $table->foreignId('district_id')->constrained();
            $table->foreignId('palika_id')->constrained();
            $table->foreignId('election')->constrained();
            $table->enum('post', ['Mayor', 'Deputy Mayor']);
            $table->text('party');
            $table->text('goal');
            $table->text('vote');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_mayors');
    }
};
