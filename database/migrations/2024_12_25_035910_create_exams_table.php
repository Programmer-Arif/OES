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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('examName');
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->string('date');
            $table->string('time');
            $table->integer('no_of_attempts_possible')->default(0);
            $table->float('marks_per_q')->default(4);
            $table->float('passing_marks')->default(35);
            $table->string('entrance_id');
            $table->integer('plan')->default(0)->comment('0->free 1->paid');
            $table->json('prices')->nullable;
            $table->string('entrance_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
