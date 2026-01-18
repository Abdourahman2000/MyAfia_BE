<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->boolean('canexcept')->default(0); // 0 = désactivé, 1 = activé
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('canexcept');
    });
}
};
