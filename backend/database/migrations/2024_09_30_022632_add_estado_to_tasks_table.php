<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('state_id')->nullable(); // Agregar la relación
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade'); // Definir la relación
        });
    }


    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
