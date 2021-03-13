<template>
<form id="RegisterProfessor">
    <label for="username">
        username<br>
        <input name="username" type="text" id="username" required>
        <p id="usernameError"></p>
    </label><br>
    <label for="email">
        email<br>
        <input name="email" type="email" id="email" required>
        <p id="emailError"></p>
    </label><br>
    <label for="pass">
        password<br>
        <input name="pass" type="password" id="pass" required>
        <p id="passError"></p>
    </label><br>
    <label for="confPass">
        confirmar password<br>
        <input name="confPass" type="password" id="confPass" required>
        <p id="ConfError"></p>
    </label><br>
    <label for="submit">
        <input name="submit" value="registar" type="button" id="submit" @click="submit()">

    </label>

</form>

</template>

<script>

import axios from "axios";
import $ from 'jquery'
export default {
    name: "registo",
    methods: {


        submit() {

            $( "#ConfError" ).text(" ").css('color', 'red');
            $( "#passError" ).text(" ").css('color', 'red');
            $( "#emailError" ).text(" ").css('color', 'red');
            $( "#usernameError" ).text(" ").css('color', 'red');
            if ($( "#pass" ).val() !== $( "#confPass" ).val() ){
                $( "#ConfError" ).text("As passwords estam diferentes").css('color', 'red');

            }
            else if($( "#pass" ).val().length === 0 ){
                $( "#passError" ).text("Introduza uma palavra-passe").css('color', 'red');
            }
            else if($( "#confPass" ).val().length === 0 ){
                $( "#ConfError" ).text("confirme a password").css('color', 'red');
            }
            else if($( "#email" ).val().length === 0 ){
                $( "#emailError" ).text("Introduza um email").css('color', 'red');
            }
            else if($( "#username" ).val().length === 0 ){
                $( "#usernameError" ).text("Introduza um username").css('color', 'red');
            }
            else
            {
                let formData = new FormData();
                formData.append( 'name',$( "#username" ).val());
                formData.append( 'email',$( "#email" ).val());
                formData.append( 'pass',$( "#pass" ).val());
                formData.append( 'ConfPass',$( "#confPass" ).val());

                axios.post('/registo/sbmProfessor', formData
                ).then(function (response) {
                    alert("success");
                }.bind(this));
            }



        }
    }

}
</script>
