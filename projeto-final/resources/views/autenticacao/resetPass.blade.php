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

                                        <input name="pass" class="form-control mt-2 mb-3 " type="password" id="pass">
                                        <label class="label" for="pass"><span>password</span></label>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <p class="error " id="PassError"></p>
                                    </div>
                                    <div class="col-12">

                                        <input name="ConfPass" class="form-control mt-2 mb-3 " type="password" id="ConfPass">
                                        <label class="label" for="ConfPass"><span>confirmar password</span></label>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <p class="error " id="ConfPassError"></p>
                                    </div>

                                    <button name="submit" class="btn btn-primary mt-5 mb-5 btn-submit" type="button"
                                            id="submit" onclick="recovery()">
                                        <span class="">Guardar password &nbsp</span>
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
        $('#submit').prop('disabled', true);

        $('#PassError').text(' ');
        $('#ConfPassError').text(' ');
        console.log({{ $token}})

        if($( "#pass" ).val().length === 0 ){
            $( "#PassError" ).text("Introduza uma palavra-passe").css('color', 'red').css('opacity', '1');
            $('#submit').prop('disabled', false);
        } else if($( "#ConfPass" ).val().length === 0 ){
            console.log("ddd")
            $( "#ConfPassError" ).text("Confirme a password").css('color', 'red').css('opacity', '1');
            $('#submit').prop('disabled', false);
        } else if ($( "#pass" ).val() !== $( "#ConfPass" ).val() ){
            $( "#pass" ).val('')
            $( "#ConfPass" ).val('')
            $( "#ConfPassError" ).text("As passwords estam diferentes").css('color', 'red').css('opacity', '1');
            $('#submit').prop('disabled', false);
        }
        else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           $.ajax({
                url: '/SavePass',
                type: "Post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'pass': $('#pass').val(),
                    'token': {{$token}}
                },
                success: function (response) {//200 response comes here
                    if (response.message==="sucesso") {
                        $('#submit').prop('disabled', true);
                        alert("password alterada com sucesso");
                        window.location.replace('/');
                    }else {
                        $('#ConfPassError').text(response.message.toString()).css('color', 'red').css('opacity', '1');
                        $( "#pass" ).val('')
                        $( "#ConfPass" ).val('')
                        $('#submit').prop('disabled', false);
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
