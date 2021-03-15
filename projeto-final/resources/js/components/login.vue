<template>
    <form class="row mx-auto" id="RegisterProfessor">
        <h2 class="mt-5 mb-5" >Login</h2>
        <div class="col-12">

            <input name="email" class="form-control mt-2 mb-3 " type="email" id="email" >
            <label class="label" for="email"><span>Email</span></label>
        </div>
        <div class="col-12 mb-3">
            <p class="error " id="EmailError"></p>
        </div>
        <div class="col-12">
            <input name="pass" class="form-control mt-2 mb-3" type="password" id="pass" >
            <label class="label" for="pass"><span>Password</span></label>
            <span class="password-eye btn" id="password-eye" @click="verPassword"><i class="bi bi-eye"></i></span>
        </div>
        <div class="col-12">
            <p class="error " id="passwordError"></p>
        </div>
        <div class="col-12">
            <a href="#"><small>Esqueceu-se do código?</small></a>
        </div>


        <div class="">

            <button name="submit" class="btn btn-primary mt-5 mb-5"  type="button" id="submit" @click="submit()">
                <span class="" role="status" aria-hidden="true" id="laoding"></span>
                ENTRAR
            </button>
        </div>


    </form>


</template>

<script>
    import axios from "axios";
    import $ from 'jquery'
export default {
    name: "login",
    methods: {
        submit() {

            if($( "#email" ).val().length === 0 ){
                $( "#EmailError" ).text("O campo encontra-se vazio").css('color', 'red').css('opacity', '1');
                $( "#loading" ).removeClass('spinner-border spinner-border-sm');
                $('#submit').prop('disabled', false);
            }

            if($( "#pass" ).val().length === 0 ){
                $( "#passwordError" ).text("O campo encontra-se vazio").css('color', 'red').css('opacity', '1');
                $( "#loading" ).removeClass('spinner-border spinner-border-sm');
                $('#submit').prop('disabled', false);
            }

            if ($( "#email" ).val().length !== 0 && $( "#pass" ).val().length !== 0)
            {


                let formData = new FormData();
                formData.append( 'name',$( "#pass" ).val());
                formData.append( 'email',$( "#email" ).val());
                axios.post('/loginroute', formData
                ).then(function (response) {



                }.bind(this));
            }



        },
        verPassword(){
            var password = document.getElementById('pass').type;
            if (password === 'password'){
                document.getElementById('pass').type = 'text';
                document.getElementById('password-eye').innerHTML ='<i class="bi bi-eye-slash"></i>';

            }else {
                document.getElementById('pass').type = 'password';
                document.getElementById('password-eye').innerHTML ='<i class="bi bi-eye"></i>';
            }
        }
    }


}
</script>

