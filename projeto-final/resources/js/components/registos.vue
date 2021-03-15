<template>
<form class="row mx-auto" id="RegisterProfessor">
    <div class="col-12 mt-5">

        <input name="username" class="form-control mt-2" type="text" id="username" required>
        <label class="label" for="username"><span>Nome</span></label>

        <p class="error" id="usernameError">&nbsp;</p>
    </div>



    <div class="col-12">

        <input name="email" class="form-control mt-2" type="email" id="email" required>
        <label class="label" for="email"><span>Email</span></label>
        <p class="error" id="emailError">&nbsp;</p>
    </div>

    <div class="col-12">

        <input name="pass" class="form-control mt-2" type="password" id="pass" required>
        <label class="label" for="pass"><span>Password</span></label>
        <p class="error" id="passError">&nbsp;</p>
    </div>


    <div class="col-12">

        <input name="confPass" class="form-control mt-2" type="password" id="confPass" required>
        <label class="label" for="confPass"><span>Confirmar Password</span></label>
        <p class="error" id="ConfError">&nbsp;</p>
    </div>



    <div class="col-12">
        <div class="mt-2">
            <input type="radio" id="male" name="gender" value="m">
            <label class="me-3"  for="male" >Masc.</label>
            <input type="radio" id="female" name="gender" value="f">
            <label class="me-3" for="female">Fem.</label>
            <input type="radio" id="other" name="gender" value="o">
            <label for="other">Outro</label>

            <p class="error" id="sError">&nbsp;</p>
        </div>


    </div>
    <div class="">
        <input name="submit " class="btn btn-primary mt-5 mb-5" value="REGISTAR" type="button" id="submit" @click="submit()">
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


           if ($( "#pass" ).val() !== $( "#confPass" ).val() ){
                $( "#pass" ).val('')
                $( "#confPass" ).val('')
                $( "#ConfError" ).text("As passwords estão diferentes").css({'color': 'red', 'opacity': '1'});

            }else {
               $( "#ConfError" ).text("&nbsp;").css('color', 'red').css('opacity', '0');
           }

            if($( "#pass" ).val().length === 0 ){
                $( "#passError" ).text("Introduza uma palavra-passe").css({'color': 'red', 'opacity': '1'});
            }else {
                $( "#passError" ).text("&nbsp;").css('color', 'red').css('opacity', '0');
            }

            if($( "#confPass" ).val().length === 0 ){
                $( "#ConfError" ).text("confirme a password").css({'color': 'red', 'opacity': '1'});
            }else {
                $( "#ConfError" ).text("&nbsp;").css('color', 'red').css('opacity', '0');
            }

             if($( "#email" ).val().length === 0 ){
                $( "#emailError" ).text("Introduza um email").css({'color': 'red', 'opacity': '1'});
            }else {
                 $( "#emailError" ).text("&nbsp;").css('color', 'red').css('opacity', '0');
             }

            if($( "#username" ).val().length === 0 ){
                $( "#usernameError" ).text("Introduza um username").css({'color': 'red', 'opacity': '1'});
            }else {
                $( "#usernameError" ).text("&nbsp;").css('color', 'red').css('opacity', '0');
            }

            if(test==='error' ){
               $( "#sError" ).text("Indique o sexo ").css({'color': 'red', 'opacity': '1'});
           }else {
                $( "#sError" ).text("&nbsp;").css('color', 'red').css('opacity', '0');
            }

            if ($( "#pass" ).val() === $( "#confPass" ).val() && $( "#pass" ).val().length !== 0 && $( "#confPass" ).val().length !== 0 && $( "#email" ).val().length !== 0 && $( "#username" ).val().length !== 0  && test!=='error' )
            {
                let formData = new FormData();
                formData.append( 'name',$( "#username" ).val());
                formData.append( 'email',$( "#email" ).val());
                formData.append( 'pass',$( "#pass" ).val());
                formData.append( 'tipo','professor');
                formData.append( 'sexo',test);
                axios.post('/registo/sbmProfessor', formData
                ).then(function (response) {
                    if (response.data.message !== "sucesso"){
                        $( "#email" ).val('')
                        $( "#pass" ).val('')
                        $( "#confPass" ).val('')
                        $( "#passError" ).text(response.data.password).css('color', 'red');
                        $( "#emailError" ).text(response.data.email).css('color', 'red');

                    }

                }.bind(this));
            }



        }
    }

}
</script>
