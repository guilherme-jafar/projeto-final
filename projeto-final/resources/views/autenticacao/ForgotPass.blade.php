<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projeto Final</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
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

<header>

    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/"><img class="img-fluid" src="{{URL('/assets/logo.png')}}" alt=""></a>
            <div class="d-flex">
                <a class="btn btn-primary" href="{{URL('/registo')}}">REGISTO</a>


            </div>
        </div>
    </nav>

</header>

<main>

    <section class="section-autenticacao section-login">
        <div class="container">
            <div class="row">
                <div class="box">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="app">
                                <form class="row mx-auto" id="forgotPassword">
                                    <h2 class="mt-5 mb-5">Recuperação da Password</h2>
                                    <div class="col-12">

                                        <input name="email" class="form-control mt-2 mb-3 " type="email" id="email">
                                        <label class="label" for="email"><span>Email</span></label>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <p class="error " id="EmailError"></p>
                                    </div>

                                    <button name="submit" class="btn btn-primary mt-5 mb-5 btn-submit" type="button"
                                            id="submit" onclick="recovery()">
                                        <span class="">Enviar email &nbsp;</span>
                                        <div class="spinner-border text-light d-none" role="status">

                                        </div>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="mx-auto">


    </div>




</main>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script>

    function recovery(){

        $('#emailError').text(' ');


        if ($('#email').val().length===0){
            console.log("erro")
            $('#EmailError').text('Tem que inserir um email ').css('color', 'red').css('opacity', '1');
        }else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/recovery',
                type: "Post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'email': $('#email').val(),
                },
                success: function (response) {//200 response comes here
                    if (response.data.message==="sucesso") {

                    }else {
                        $('#EmailError').text(response.data.message).css('color', 'red').css('opacity', '1');
                    }
                },
                error: function (e) {

                }
            })
        }


    }
</script>

</body>


</html>
