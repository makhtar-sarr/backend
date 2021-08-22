<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSousCategorieDepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sous_categorie_deps', function (Blueprint $table) {
            $table->id();
            $table->string('nom_sous_cat')->unique();
            $table->text('desc_sous_cat')->nullable();
            $table->integer('categorie_dep_id');
            $table->foreign('categorie_dep_id')
                  ->references('id')
                  ->on('categorie_deps')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->integer('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
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
        Schema::dropIfExists('sous_categorie_deps');
    }
}
