<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('property_id',20);
            $table->string('renter_id',9);
            $table->date('dstart');
            $table->date('dend');
            $table->timestamps();

            $table->foreign('property_id')->references('cref')->on('properties')->onDelete('cascade');
            $table->foreign('renter_id')->references('dni')->on('renters')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
