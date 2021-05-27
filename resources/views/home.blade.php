@extends("master")

<!-- Set title of page -->
@section("title", "Home | PokéAPI Dex")

@section("nav")
    @include("nav")
@stop

<!-- Set page content -->
@section("content")
    <h1>PokéAPI Dex</h1>

    @if(count($pokeList) == 0)
        <form action="/generation" method="POST">
            <label for="gens">Choose Generation:</label>

            <!-- Create <select> options for generations 1-8 -->
            <select name="gens" id="#gen-select" onchange="this.form.submit()">
                <option value="none" selected disabled hidden>-- Select --</option>
                @for($i = 1; $i <= 8; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor

                {{csrf_field() }}
            </select>
        </form>
    @else
        <form action="/pokemon" method="POST">
            <label for="pokemon-select">Choose a Pokemon:</label>

            <!-- Create <select> options using list of Pokémon -->
            <select name="pokemon" id="#pokemon-select" onchange="this.form.submit()">
                <option value="none" selected disabled hidden>Select a Pokemon</option>
                @foreach($pokeList as $pokemon)
                    <option value="{{$pokemon["name"]}}">{{$pokemon["name"]}}</option>
                @endforeach
                
                {{csrf_field() }}
            </select>
        </form>

        <a href="/">back</a>
    @endif
@endsection

@section("footer")
    @include("footer")
@stop