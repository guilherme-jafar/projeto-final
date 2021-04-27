<template>
<form class="row mx-auto" id="RegisterProfessor">
    <h2>Registo</h2>
    <div class="col-12">

        <input name="username " class="form-control mt-2 mb-3" type="text" id="username" required>
        <label class="label " for="username"><span>Nome</span></label>
    </div>
    <div class="col-12">
        <p class="error " id="usernameError"></p>
    </div>



    <div class="col-12">

        <input name="email" class="form-control mt-2 mb-3" type="email" id="email" required>
        <label class="label" for="email"><span>Email</span></label>

    </div>
    <div class="col-12">
        <p class="error" id="emailError"></p>
    </div>

    <div class="col-12">

        <input name="pass" class="form-control mt-2 mb-3" type="password" id="pass" required>
        <label class="label" for="pass"><span>Password</span></label>

    </div>
    <div class="col-12">
        <p class="error" id="passError"></p>
    </div>

    <div class="col-12">

        <input name="confPass" class="form-control mt-2 mb-3" type="password" id="confPass" required>
        <label class="label" for="confPass"><span>Confirmar Password</span></label>

    </div>
    <div class="col-12">
        <p class="error" id="ConfError"></p>
    </div>


    <div class="col-12">
        <div >
            <input type="radio" id="male" name="gender" value="m">
            <label class="me-3"  for="male" >Masc.</label>
            <input type="radio" id="female" name="gender" value="f">
            <label class="me-3" for="female">Fem.</label>
            <input type="radio" id="other" name="gender" value="o">
            <label for="other">Outro</label>

            <p class="error" id="sError"></p>
        </div>


    </div>
    <div class="">


        <button name="submit" class="btn btn-primary mt-5 mb-5 btn-loading"  type="button" id="submit" @click="submit()">
            <span class="">REGISTAR &nbsp;</span>
            <div class="spinner-border text-light d-none" role="status">

            </div>
        </button>
    </div>


</form>


</template>

<script>

import axios from "axios";
import $ from 'jquery'
export default {
    name: "registo",
    methods: {


        submit() {


            $('#submit span').addClass('d-none');
            $('#submit div').removeClass('d-none');

            $('#submit').prop('disabled', true);
            $( "#loading" ).addClass('spinner-border spinner-border-sm');
            $( "#sError" ).text(" ").css('color', 'red');
            $( "#ConfError" ).text(" ").css('color', 'red');
            $( "#passError" ).text(" ").css('color', 'red');
            $( "#emailError" ).text(" ").css('color', 'red');
            $( "#usernameError" ).text(" ").css('color', 'red');
            var radios = document.getElementsByName('gender');

            var test;
            for (var i = 0, length = radios.length; i < length; i++) {

                if (radios[i].checked) {

                    test=radios[i].value;

                    break;
                }
                else {
                    test='error';
                }
            }



             if($( "#pass" ).val().length === 0 ){
                $( "#passError" ).text("Introduza uma palavra-passe").css('color', 'red').css('opacity', '1');
                $( "#loading" ).removeClass('spinner-border spinner-border-sm');
                $('#submit').prop('disabled', false);

                $('#submit span').removeClass('d-none');
                $('#submit div').addClass('d-none');
            }
            else if($( "#confPass" ).val().length === 0 ){
                $( "#ConfError" ).text("confirme a password").css('color', 'red').css('opacity', '1');
                $( "#loading" ).removeClass('spinner-border spinner-border-sm');
                $('#submit').prop('disabled', false);

                $('#submit span').removeClass('d-none');
                $('#submit div').addClass('d-none');
            }
            else if($( "#email" ).val().length === 0 ){
                $( "#emailError" ).text("Introduza um email").css('color', 'red').css('opacity', '1');
                $( "#loading" ).removeClass('spinner-border spinner-border-sm');
                $('#submit').prop('disabled', false);

                $('#submit span').removeClass('d-none');
                $('#submit div').addClass('d-none');
            }else if ($( "#pass" ).val() !== $( "#confPass" ).val() ){
                $( "#pass" ).val('')
                $( "#confPass" ).val('')
                $( "#ConfError" ).text("As passwords são diferentes").css('color', 'red').css('opacity', '1');
                $( "#loading" ).removeClass('spinner-border spinner-border-sm');
                $('#submit').prop('disabled', false);

                $('#submit span').removeClass('d-none');
                $('#submit div').addClass('d-none');
            }
            else if($( "#username" ).val().length === 0 ){
                $( "#usernameError" ).text("Introduza um username").css('color', 'red').css('opacity', '1');
                $( "#loading" ).removeClass('spinner-border spinner-border-sm');
                $('#submit').prop('disabled', false);

                $('#submit span').removeClass('d-none');
                $('#submit div').addClass('d-none');
            }
            else if(test==='error' ){
                $( "#sError" ).text("Indique o sexo ").css('color', 'red').css('opacity', '1');
                $( "#loading" ).removeClass('spinner-border spinner-border-sm');
                $('#submit').prop('disabled', false);

                $('#submit span').removeClass('d-none');
                $('#submit div').addClass('d-none');
            }
            else
            {

                let tipo=document.URL;
                tipo=tipo.replace('http://127.0.0.1:8000/registo/user/','');
             let formData = new FormData();
                formData.append( 'name',$( "#username" ).val());
                formData.append( 'email',$( "#email" ).val());
                formData.append( 'pass',$( "#pass" ).val());
                formData.append( 'tipo',tipo);
                formData.append( 'sexo',test);
                axios.post('/registo/sbmProfessor', formData
                ).then(function (response) {

                    if (response.data.message !== "sucesso"){

                        $( "#email" ).val('')
                        $( "#pass" ).val('')
                        $( "#confPass" ).val('')
                        $( "#passError" ).text(response.data.password).css('color', 'red').css('opacity', '1');
                        $( "#emailError" ).text(response.data.email).css('color', 'red').css('opacity', '1');
                        $( "#loading" ).removeClass('spinner-border spinner-border-sm');
                        $('#submit').prop('disabled', false);

                        $('#submit span').removeClass('d-none');
                        $('#submit div').addClass('d-none');

                    }
                    else{
                        $( "#loading" ).removeClass('spinner-border spinner-border-sm');
                        $('#submit').prop('disabled', false);
                        window.location.replace('/');

                    }

                }.bind(this));
            }



        }
    }

}
</script>
