

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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css') }}">


</head>
<body class="antialiased">

<header >

    <!-- Navbar -->
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
                        <a class="btn btn-primary" href="{{URL('/registo')}}">NOVA DISCIPLINA</a>
                    </li>
                    <li class="nav-item avatar dropdown d-flex align-items-center">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="@if(session('utilizador')['foto'] == null){{asset('/images/imgDefault.jpg')}}@else {{session('utilizador')['foto']}} @endif" class="rounded-circle z-depth-0"
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
    <!-- Navbar -->

</header>

<main>

    <section class="" >
        <div class="container-fluid">
            <div class="row">
                <div class="box">
                    <div class="row">
                        <div class="col-md-4">
                           <div class="menu">

                           </div>
                        </div>
                        <div class="col-md-8">

{{--                            @yield('content')--}}
                            <dashboard></dashboard>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>




</main>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
</html>
<script>
    import Dashboard from "../../js/components/dashboard";
    export default {
        components: {Dashboard}
    }
</script>