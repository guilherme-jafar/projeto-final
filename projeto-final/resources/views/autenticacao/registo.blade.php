<!DOCTYPE html>
<html lang="pt">
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/autenticacao.css') }}">

</head>
<body class="antialiased">

<header >

    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand"><img class="img-fluid" src="{{URL('/assets/logo.png')}}" alt=""></a>
            <div class="d-flex">
                <a class="btn btn-ghost" href="{{URL('/login')}}">LOGIN &nbsp;<i class="bi bi-box-arrow-in-right"></i></a>


            </div>
        </div>
    </nav>

</header>

<main>

    <section class="section-autenticacao section-registo-1" >
        <div class="container">
            <div class="row">
                <div class="box">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="box-registo box-registo-1 me-5" href="/registo/user/aluno">
                                <h3>Aluno</h3>

                                <div class="mx-auto ">        <i class="bi bi-person align-middle"></i></div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="box-registo box-registo-2 ms-5" href="/registo/user/prof">
                                <h3>Professor</h3>
                                <div class="mx-auto">  <i class="bi bi-book-fill align-bottom"></i></div>

                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <div class="mx-auto">

        {{--        <button><a><img src="{{URL('/assets/registo_aluno.png')}}" width="400" height="400"></a></button>--}}
        {{--        <button><a href="/registo/rgsProfessor"><img src="{{URL('/assets/registo_professor.png')}}" width="400" height="400"></a></button>--}}



    </div>

</main>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>


</html>
