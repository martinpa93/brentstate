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
            $table->char('property_id',20);
            $table->char('renter_id',9);
            $table->date('dstart');
            $table->date('dend');
            $table->boolean('iva');
            $table->decimal('watertax', 6, 2)->nullable;
            $table->decimal('gastax', 6, 2)->nullable;
            $table->decimal('electricitytax', 6, 2)->nullable;
            $table->decimal('communitytax', 6, 2)->nullable;
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('renter_id')->references('id')->on('renters')->onDelete('cascade');
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
