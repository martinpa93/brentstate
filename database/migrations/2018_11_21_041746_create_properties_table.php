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
            $table->char('cref', 20)->unique();
            $table->integer('user_id')->unsigned();
            $table->string('address');
            $table->string('population');
            $table->string('province');
            $table->char('cp',5);
            $table->enum('type', ['Vivienda', 'Local comercial', 'Garaje']);
            $table->unsignedInteger('m2');
            $table->boolean('ac')->nullable();
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
