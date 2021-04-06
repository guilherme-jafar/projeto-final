<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projeto Final</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
    <!-- viewport -->
    <meta name='viewport' content='width=device-width'>
    <meta name='viewport' content='width=1024'>

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link rel="shortcut icon" type="image/x-icon" href="">

    {{--    CSS--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

</head>
<body class="antialiased">

<header >



    @if(!session()->exists('utilizador'))

        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand"><img class="img-fluid" src="{{URL('/assets/logo.png')}}" alt=""></a>
                <div class="d-flex">
                    <a class="btn btn-primary me-3" href="{{URL('/registo')}}">REGISTO</a>
                    <a class="btn btn-ghost" href="{{URL('/login')}}">LOGIN &nbsp;<i class="bi bi-box-arrow-in-right"></i></a>

                </div>
            </div>
        </nav>

    @else

        <nav class="navbar navbar-expand-md navbar-light">

            <div class="container">
                <!-- Links -->
                <div class="collapse navbar-collapse" id="basicExampleNav5">
                    <a class="navbar-brand" href="/"><img class="img-fluid" src="{{URL('/assets/logo.png')}}" alt=""></a>
                    <!-- Right -->


                </div>
                <div class="d-flex">
                    <ul class="navbar-nav nav-flex-icons ml-auto">
                        <li class="nav-item avatar dropdown d-flex align-items-center">
                            <a href="{{url( '/' . session('utilizador')['tipo'] . '/dashboard')}}" class="btn btn-primary" >Dashboard</a>
                        </li>
                        <li class="nav-item avatar dropdown d-flex align-items-center">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="@if(session('utilizador')['foto'] == null){{asset('/images/imgDefault.jpg')}}@else {{asset('/images/' . session('utilizador')['foto'])}} @endif" class="rounded-circle z-depth-0"
                                     alt="avatar image" style="width: 5rem">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#">Editar Perfil <i class=" bi bi-pencil-square"></i></a></li>
                                <li><a class="dropdown-item" href="{{URL('/logout')}}">Logout <i class=" bi bi-box-arrow-right"></i></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- Links -->
            </div>



        </nav>

    @endif



    <div class="">


    </div>



</header>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</html>
