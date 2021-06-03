<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreatePokemonTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemon_teams', function (Blueprint $table) {
            $table->id();
            $table->string("userId");
            $table->string("team");
            $table->smallInteger("pokemonCount")->default(0);
            $table->integer("likeCount")->default(0);
            $table->timestamps()->default(Carbon::now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pokemon_teams');
    }
}
