<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->string('nom_dep');
            $table->integer('montant_dep', false, true);
            $table->text('description_dep')->nullable();
            $table->integer('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->integer('categorie_dep_id');
            $table->foreign('categorie_dep_id')
                  ->references('id')
                  ->on('categorie_deps')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->integer('sous_categorie_dep_id')->nullable();
            $table->foreign('sous_categorie_dep_id')
                  ->references('id')
                  ->on('sous_categorie_deps')
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
        Schema::dropIfExists('depenses');
    }
}
