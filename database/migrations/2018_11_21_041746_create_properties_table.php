<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->char('cref', 20);
            $table->string('address');
            $table->string('population');
            $table->string('province');
            $table->char('cp',5);
            $table->enum('type', ['Vivienda', 'Local comercial', 'Garage']);
            $table->unsignedInteger('m2');
            $table->boolean('ac');
            $table->unsignedInteger('nroom');
            $table->unsignedInteger('nbath');
            $table->timestamps();

            $table->primary('cref');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            ; 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
