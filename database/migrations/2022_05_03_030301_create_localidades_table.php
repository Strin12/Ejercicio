<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localidades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_asenta');
            $table->string('d_asenta');
            $table->string('d_tipo_asenta');
            $table->string('cod_postal');
            $table->string('d_codigo');
            $table->string('d_ciudad');
            $table->string('c_oficina');
            $table->string('d_zona');
            $table->string('c_tipo_asenta');
            $table->string('claveciudad');
            $table->string('c_mnpio');
            $table->integer('municipios_id')->unsigned();
            $table->foreign('municipios_id')->references('id')->on('municipios'); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localidades');
    }
}
