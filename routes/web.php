<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* GET REQUESTS */
Route::get("/", "HomeController@index");
Route::get("/login", "LoginController@showLogin");
Route::get("/pokemon/{pokemonName}", "PokemonController@showPokemon");

/* POST REQUESTS */
Route::post("/pokemon", "PokemonController@showPokemon");