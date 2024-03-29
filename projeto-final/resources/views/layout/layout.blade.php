<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
    <!-- viewport -->
    <meta name='viewport' content='width=device-width'>
    <meta name='viewport' content='width=1024'>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ua -->
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
    <!-- viewport -->


    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link rel="shortcut icon" type="image/x-icon" href="">

    {{--    CSS--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />


</head>
<body class="antialiased">

<header >

    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light">

        <div class="container">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Links -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <a class="navbar-brand" href="/"><img class="img-fluid" src="{{URL('/assets/logo.png')}}" alt=""></a>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{URL('/editarperfil')}}">Editar Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{URL('/logout')}}">Logout</a>
                </li>


            </div>


            <div class="d-flex">
                <ul class="navbar-nav nav-flex-icons ml-auto">
                    <li class="nav-item avatar dropdown d-flex align-items-center">


                        @if(strpos(request()->path(), 'prof/Disciplina') === 0)
                            <button class="btn btn-primary" id="newTopic" data-bs-toggle="modal" data-bs-target="#exampleModal">NOVO TÓPICO</button>
                            <button class="btn btn-primary d-none" id="newQuiz" data-bs-toggle="modal" data-bs-target="#exampleModal2">NOVO QUIZ</button>
                            <button class="btn btn-primary d-none" id="newForum" data-bs-toggle="modal" data-bs-target="#modalAdicionarForum">NOVO FÓRUM</button>
                        @elseif(strpos(request()->path(), 'editarperfil') === 0)
                            <a class="btn btn-primary" href="{{url( session('utilizador')['tipo'] . '/dashboard')}}" >Dashboard</a>
                        @elseif(strpos(request()->path(), 'prof/dashboard') === 0 || strpos(request()->path(), 'aluno/dashboard') === 0)
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">NOVA DISCIPLINA</button>
                        @endif
                    </li>
                    <li class="nav-item avatar dropdown d-flex align-items-center">
                        <button class="btn btn-secondary dropdown-toggle btn-nav" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="@if(session('utilizador')['foto'] == null){{asset('/images/imgDefault.jpg')}}@else {{asset('/images/' . session('utilizador')['foto'])}} @endif" class="rounded-circle z-depth-0 "
                                 alt="avatar image" style="width: 5rem; height: 5rem">
                        </button>
                        <img src="@if(session('utilizador')['foto'] == null){{asset('/images/imgDefault.jpg')}}@else {{asset('/images/' . session('utilizador')['foto'])}} @endif" class="rounded-circle z-depth-0 img-nav ms-3"
                             alt="avatar image" style="width: 5rem; height: 5rem">

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
    <!-- Navbar -->

</header>

<main>

    <section class="">
        <div class="container">
            <div class="row">
                @yield('content')
            </div>
        </div>
    </section>




</main>

</body>
<script src="https://unpkg.com/read-excel-file@4.1.0/bundle/read-excel-file.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

<script  src="{{ asset('js/app.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js" integrity="sha512-wBcFatf7yQavHQWtf4ZEjvtVz4XkYISO96hzvejfh18tn3OrJ3sPBppH0B6q/1SHB4OKHaNNUKqOmsiTGlOM/g==" crossorigin="anonymous"></script>

{{--<script src="{{ asset('js/jquery.min.js') }}"></script>--}}
{{--<script src="{{ asset('js/jquery.easing.min.js') }}"></script>--}}

{{--<script src="{{ asset('js/custom.js') }}"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</html>
<script>
</script>
