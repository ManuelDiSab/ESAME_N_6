<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Film-preferiti', function (Blueprint $table) {
            $table->id('idFilmPreferito');
            $table->unsignedBigInteger('idFilm')->unsigned();
            $table->unsignedBigInteger('idUSer')->unsigned();
            $table->timestamps();
            $table->foreign('idFilm')->references('idFilm')->on('film');
            $table->foreign("idUser")->references("idUser")->on("users");
        });
        Schema::create('Serie-preferite', function (Blueprint $table) {
            $table->id('idSeriePreferita');
            $table->unsignedBigInteger('idSerie')->unsigned();
            $table->unsignedBigInteger('idUSer')->unsigned();
            $table->timestamps();
            $table->foreign('idSerie')->references('idSerie')->on('serie_tv');
            $table->foreign("idUser")->references("idUser")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Serie-preferite');
        Schema::dropIfExists('Film-preferiti');
    }
};
