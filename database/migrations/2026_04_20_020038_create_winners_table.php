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
        Schema::create('winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained();
            $table->foreignId('candidate_id')->constrained('ward_candidates');
            $table->string('post'); // e.g., 'Mayor', 'Ward Member'
            $table->foreignId('palika_id')->nullable()->constrained();
            $table->foreignId('ward_id')->nullable()->constrained();
            $table->integer('vote_count');
            $table->boolean('is_tie')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winners');
    }
};
