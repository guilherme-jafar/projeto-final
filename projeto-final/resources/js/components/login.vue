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

            <button name="submit" class="btn btn-primary mt-5 mb-5 btn-submit"  type="button" id="submit" @click="submit()">
                <span id="btn-text co">ENTRAR &nbsp;</span>
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
    name: "login",
    methods: {
        submit() {

            $('#submit span').addClass('d-none');
            $('#submit div').removeClass('d-none');

            if($( "#email" ).val().length === 0 ){
                $( "#EmailError" ).text("O campo encontra-se vazio").css('color', 'red').css('opacity', '1');
                $('#submit span').removeClass('d-none');
                $('#submit div').addClass('d-none');

            }

            if($( "#pass" ).val().length === 0 ){
                $('#submit span').removeClass('d-none');
                $('#submit div').addClass('d-none');

            }

            if ($( "#email" ).val().length !== 0 && $( "#pass" ).val().length !== 0)
            {


                let formData = new FormData();
                formData.append( 'password',$( "#pass" ).val());
                formData.append( 'email',$( "#email" ).val());
                axios.post('/loginroute', formData
                ).then(function (response) {


                console.log(response.data.message)

                    if (response.data.message === 'erro'){
                        $('#passwordError').text('O email ou a palavra passe estão incorretos!!');
                        $('#submit span').removeClass('d-none');
                        $('#submit div').addClass('d-none');
                    }else{
                        window.location.replace('/loading');
                    }

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

