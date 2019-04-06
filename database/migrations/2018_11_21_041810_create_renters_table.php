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
            $table->string('dni',9)->unique();
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('surname');
            $table->date('dbirth');
            $table->string('address');
            $table->string('population');
            $table->string('phone',30);
            $table->char('iban',27);
            $table->string('job')->nullable();
            $table->decimal('salary', 6, 2)->nullable();
            $table->timestamps();

            $table->primary('dni');
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
