<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/registo.css') }}">
</head>
<body class="antialiased">

<header >

    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/"><img class="img-fluid" src="{{URL('/assets/logo.png')}}" alt=""></a>

        </div>
    </nav>

</header>

<main>

    <section >
        <div class="container">




                        <div class="col-lg-12">
                        <div class="col-md-12 ">
                            <div class="card">

                                <div class="card-body" style="">
                                    <h5 class="card-title" > A confirmar conta....</h5>

                                    <div class="spinner-border" role="status" id="spinner">

                                    </div>

                            </div>
                        </div>




                </div>
            </div>
        </div>
    </section>
</main>
</body>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>

    $( document ).ready(function() {

        var url='';
        var tipo= '{{$tipo}}';
        console.log(url)

        if (tipo==="prof"){
           url= '/Confirmar/professor'}
        else{
            url= '/Confirmar/aluno'}
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: "Post",
            data: {
                'id': {{$token}},
            },
            success: function (data) {//200 response comes here
                if (data.message==="sucesso") {
                    $('#spinner').addClass('alert alert-success').removeClass('spinner-border')
                    $('#spinner').html('conta confirmada volte a dashboard <a href="/">clique aqui!!!</a>')
                }else {
                    $('#spinner').addClass('alert alert-danger').removeClass('spinner-border')
                    $('#spinner').text('Não foi possivel confirmar conta')
                }
            },
            error: function (e) {
                console.log(e)
                $('#spinner').addClass('alert alert-danger').removeClass('spinner-border')
                $('#spinner').text('Não foi possivel confirmar conta')
            }
        })


    });
</script>

</html>
