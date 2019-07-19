<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    

    public function up()
    {
        Schema::create('renters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dni',9)->unique();
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('surname');
            $table->date('dbirth');
            $table->string('address');
            $table->string('cp');
            $table->string('population');
            $table->string('phone',9);
            $table->string('iban',24);
            $table->string('job')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('renters');
    }
}
