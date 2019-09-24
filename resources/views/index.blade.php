<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>

</head>
<body>
  <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Navbar</a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
              </li>
            </ul>
            <button class="btn btn-primary " onclick=" location.href='{{ route('acertados') }}' " type="">Partidos Acertados</button>
              <button class="btn btn-success " onclick=" location.href='{{ route('todos') }}' " type="">Todos los partidos</button>
              <button class="btn btn-success " onclick=" location.href='{{ route('nueva') }}' " type="">nueva pagina</button>
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              </form>
              
          </div>
        </nav>
  </header>
    <table class="table table-dark">
        <thead>
          <tr class="text-center">
            <th scope="col">liga</th>
            <th scope="col">local vs visita</th>
            <th scope="col">fecha Hora</th>
            <th scope="col">gana local</th>
            <th scope="col">empate</th>
            <th scope="col">gana visita</th>
            <th scope="col">prediccion</th>
            <th scope="col">resultado Exacto</th>
            <th scope="col">goles Exacto</th>
            <th scope="col">resultado Real</th>
          </tr>
        </thead>
        <tbody>
            {{-- @foreach ($partidos as $partido)
            <tr class="text-center">
                @if ($partido != null)
                <th scope="row">{{$partido['liga']}}</th>
                <td>{{$partido['local']}} vs<br/> {{$partido['visita']}}</td>

                <td>{{$partido['fechaHora']}}</td>
                <td>{{$partido['ganaLocal']}}</td>
                <td>{{$partido['empata']}}</td>
                <td>{{$partido['ganaVisita']}}</td>
                <td>{{$partido['prediccion']}}</td>
                <td>{{$partido['resultadoExacto']}}</td>
                <td>{{$partido['golesExacto']}}</td>
                <td>{{$partido['resultadoReal']}}</td>
                <td>{{$partido['prediccionAcertada']}}</td>
                @endif
                
            </tr>
            @endforeach --}}
          
        </tbody>
      </table>
</body>
</html>