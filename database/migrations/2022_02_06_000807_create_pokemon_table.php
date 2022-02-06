<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePokemonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemon', function (Blueprint $table) {
            $table->id();
            $table->integer('pokedex_number')->nullable();
            $table->integer('generation')->nullable();
            $table->string('name')->nullable();
            $table->mediumtext('description')->nullable();
            $table->string('type1')->nullable();
            $table->string('type2')->nullable();
            $table->string('artwork_url')->nullable();
            $table->string('sprite_url')->nullable();
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
        Schema::dropIfExists('pokemon');
    }
}
