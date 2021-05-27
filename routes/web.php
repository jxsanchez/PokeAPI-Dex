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
// Display homepage using index function in HomeController
Route::get("/", "HomeController@index");

Route::get("/generation", "HomeController@index");
Route::get("/generation/{gens}", "GenController@getGenPokemon");

Route::get("/pokemon", "HomeController@index");
Route::get("/pokemon/{pokemon}", "PokemonController@showPokemon");

/* POST REQUESTS */
Route::post("/generation", "GenController@getGenPokemon");
Route::post("/pokemon", "PokemonController@showPokemon");
