<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('empleados', function(Blueprint $table){
            $table->increments('ide');
            $table->string('nombre', 40);
            $table->string('apellido', 40);
            $table->string('email', 40);
            $table->string('celular', 10);
            $table->string('sexo', 1);
            $table->string('img', 255)->nullable();

            $table->integer('idd')->unsigned();
            $table->foreign('idd')->references('idd')->on('departamentos');

            $table->text('descripcion');
            $table->integer('edad')->nullable();
            $table->double('salario')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('empleados');
    }
};
