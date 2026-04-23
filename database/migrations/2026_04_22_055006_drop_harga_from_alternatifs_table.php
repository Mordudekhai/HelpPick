<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('alternatifs', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }

    public function down()
    {
        Schema::table('alternatifs', function (Blueprint $table) {
            $table->integer('harga')->nullable();
        });
    }
};