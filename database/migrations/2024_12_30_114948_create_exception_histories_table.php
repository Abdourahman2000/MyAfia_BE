<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exception_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('ssn')->nullable();
            $table->string('compte_cotisant')->nullable();
            $table->string('nom');
            $table->date('date_fin_exception');
            $table->enum('type_exception', ['patient', 'employer'])->default('patient');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exception_histories');
    }
};