@section("nav")
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="/">
        <img src="img/brand.png" height="50px" alt="">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/teams">Teams <span class="sr-only">(current)</span></a>
            </li>

            @if(Auth::check())
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout<span class="sr-only">(current)</span></a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">Register<span class="sr-only">(current)</span></a>
                </li>
            @endif
        </ul>
    </div>
</nav>
@stop