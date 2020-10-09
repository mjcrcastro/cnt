<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogs', function (Blueprint $table) {
            $table->id();
            $table->integer('cta')->default(0);
            $table->integer('scta')->default(0);
            $table->integer('sscta')->default(0);
            $table->unique(['cta','scta','sscta']);
            $table->integer('autocentro')->default(0);
            $table->char('nivel',1)->default('N');
            $table->integer('grupo_sscta_id')->default(0);
            $table->string('descripcion',500);
            $table->boolean('usa_centro');
            $table->integer('moneda_base'); //either 1 or 2
            $table->integer('naturaleza_cta_id');
            $table->integer('tipo_cuenta_id');
            $table->char('created_by',255);
            $table->char('updated_by',255);
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
        Schema::dropIfExists('catalogs');
    }
}
