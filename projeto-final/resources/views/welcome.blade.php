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
                                <li><a class="dropdown-item" href="{{URL('/editarperfil')}}">Editar Perfil <i class=" bi bi-pencil-square"></i></a></li>
                                <li><a class="dropdown-item" href="{{URL('/logout')}}">Logout <i class=" bi bi-box-arrow-right"></i></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- Links -->
            </div>



        </nav>

    @endif



    <div class="home-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>
                        A Estgame é uma plataforma de gamification na qual é possível criar questões de diversos tipos para os alunos responderem. <br>
                    </h1>
                    <a href="#" class="btn btn-primary">Saber Mais</a>
                </div>
                <div class="col-md-6">
                    <img src="{{asset('/images/home-image.svg')}}">
                </div>
            </div>
        </div>

    </div>


</header>


<main class="home-main">
{{--    <div class="section-home section-home-1">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-6">--}}

{{--                </div>--}}
{{--                <div class="col-md-6">--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="section-home section-home-2">
        <div class="container ">
            <div class="row text-center">
                <div class="col-md-6">
                    <div>
                        <h1 class="text-start">Aprendizagem</h1>
                        <p class="text-start">
                            O objetivo da Estgame é que o docente crie quiz para os seus alunos praticarem fora e dentro da aula o que aprenderam.
                        </p>
                    </div>

                </div>
                <div class="col-md-6">
                    <img class="img-fluid mx-auto" src="{{asset('/images/book.svg')}}">
                </div>
            </div>
        </div>
    </div>

    <div class="section-home section-home-3">
        <div class="container text-center">
            <div class="row justify-content-md-center">
                <div class="col-md-6">
                    <img class="img-fluid mx-auto" src="{{asset('/images/competition.svg')}}">
                </div>
                <div class="col-md-6">
                    <h1 class="text-start">Competição</h1>
                    <p class="text-start">
                        A aplicação permite que alunos compitam de forma saudável com os seus colegas e acumulem pontos  respondendo a quizz´s ao longo do semestre para formação do pódio.
                        Com a acumulação dos pontos, os alunos obtêm selos de participação e prémios.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <div class="section-home section-home-4">
        <div class="container text-center">
            <div class="row justify-content-md-center">
                <div class="col-md-6">
                    <h1 class="text-start">Avaliação</h1>
                    <p class="text-start">
                        A aplicação permite obter uma monitorização e avaliação da performance dos alunos durante o semestre através de tabelas disponibilizadas ao professor.
                        O docente pode utilizar a plataforma nas suas aulas como um suporte de apoio e de avaliação.
                    </p>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid mx-auto" src="{{asset('/images/checklist.svg')}}">
                </div>
            </div>
        </div>
    </div>

    <div class="section-home section-home-5">
        <div class="container text-center">
            <div class="row justify-content-md-center">
                <div class="col-md-6">
                    <img class="img-fluid mx-auto" src="{{asset('/images/gamepad.svg')}}">
                </div>
                <div class="col-md-6">
                    <h1 class="text-start">Diversão</h1>
                    <p class="text-start">
                        A ideia da plataforma é trazer a gamificação que permite a utilização de mecânicas de jogos e pensamentos para impactar pontos como engajamento, produtividade, foco e determinação dos alunos.                    </p>
                </div>

            </div>
        </div>
    </div>

</main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</html>
