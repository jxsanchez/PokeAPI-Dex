<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pokemon;
use PokePHP\PokeApi;

class StorePokemonFromPokeAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pokemon:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $api = new PokeApi;

        // Start at first Pokémon.
        $i = 1;

        // Get data for Pokémon
        $pokemonResponse = json_decode($api->pokemon($i), true);

        // Call PokéAPI with current number until string (error) is returned.
        while(!is_string($pokemonResponse)) {
            $speciesResponse = json_decode($api->pokemonSpecies($i), true);

            // Skip Pokémon if data already exists.
            if(Pokemon::where([
                ['pokedex_number', '=', $pokemonResponse['id']],
                ['name', '=', $pokemonResponse['name']]
            ])->exists()) {
                // Attempt to get info for next number
                $pokemonResponse = json_decode($api->pokemon($i++), true);
                continue;
            }
            
            echo "Creating Pokedex entry for ".$pokemonResponse['name']."\r\n";

            // Store Pokémon info in database
            $pokemon = new Pokemon();

            $pokemon->pokedex_number = $pokemonResponse['id'];
            $pokemon->generation     = $this->getGeneration($speciesResponse['generation']['url']);
            $pokemon->name           = $pokemonResponse['name'];
            $pokemon->description    = $this->getDexDescription($speciesResponse['flavor_text_entries']);
            $pokemon->type1          = $pokemonResponse['types'][0]['type']['name'];
            $pokemon->type2          = count($pokemonResponse['types']) > 1 ? $pokemonResponse['types'][1]['type']['name'] : null;
            $pokemon->artwork_url    = $pokemonResponse['sprites']['other']['official-artwork']['front_default'];
            $pokemon->sprite_url     = $pokemonResponse['sprites']['versions']['generation-viii']['icons']['front_default'];

            $pokemon->save();

            // Update response to next Pokémon
            $pokemonResponse = json_decode($api->pokemon($i++), true);
        }
    }

    /**
     * Use the Pokémon generation url returned from species endpoint to get generation
     */
    public function getGeneration($url) {
        $urlArr = explode('/', $url);

        return $urlArr[count($urlArr) - 2];
    }

    /**
     * Find the first English Pokédex entry for the specified Pokémon
     */
    public function getDexDescription($descriptions) {
        $i = 0;
        
        while($descriptions[$i]['language']['name'] !== 'en') {
            $i++;
        }

        return $descriptions[$i]['flavor_text'];
    }
}
