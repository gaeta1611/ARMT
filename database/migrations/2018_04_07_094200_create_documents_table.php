<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {/*
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',[
                'CV',
                'Lettre de motivation',
                'Lettre de recommandation',
                'Réalisation',
                'Autre',
                'Contrat',
                'Job description',
                "Rapport d''interview",
                'Offre',
                ]);
            
            $table->string('description',50)->nullable();
            $table->string('url_document');
            $table->string('filename');
            $table->integer('candidat_id')->nullable();
            $table->integer('mission_id')->nullable();
            $table->integer('user_id')->unsigned();
            $table->index('candidat_id');
            $table->index('mission_id');
            $table->index('user_id');
            

            $table->foreign('candidat_id')->references('id')->on('candidat')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
            $table->foreign('mission_id')->references('id')->on('mission')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('documents');
    }
}
