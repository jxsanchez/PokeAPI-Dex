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
Route::get("/login", "LoginController@showLogin");
Route::get("/logout", function () {
    Auth::logout();

    return redirect("/");
});

Route::get("/", "HomeController@index");
Route::get("/pokemon/{pokemonName}", "PokemonController@showPokemon");

/* POST REQUESTS */
Route::post("/pokemon", "PokemonController@showPokemon");
Route::post("/team/add", "TeamController@add");
Route::post("/team/remove", "TeamController@remove");

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
