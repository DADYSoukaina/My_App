<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('des');
            $table->integer('pr_cl_fi');
            $table->integer('pr_cl_di');
            $table->integer('pr_cl_in');
            $table->integer('pr_cl_au');
            $table->integer('quan_mi');
            $table->string('unite');
            $table->integer('famille_id');
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
        Schema::drop('produits');
    }
}
