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
        Schema::create('entry_office', function (Blueprint $table) {
            $table->id();
            $table->string('ref')->nullable();
            $table->string('name')->nullable();
            $table->string('member_id')->nullable();
            $table->string('relation_code')->nullable();
            $table->string('ssn')->nullable();
            $table->string('birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->string('regime')->nullable();
            $table->string('access_soin')->nullable();
            $table->string('taken_by_name')->nullable();
            $table->string('taken_place')->nullable();
            $table->string('mother_name')->nullable();
            $table->longText('photo')->nullable();
            $table->string('exception_status')->nullable();
            $table->longText('exception_reason')->nullable();
            $table->unsignedBigInteger('taken_by')->nullable();
            $table->foreign('taken_by')->references('id')->on('users')->onDelete('cascade');
            $table->longText('history')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entry_office');
    }
};