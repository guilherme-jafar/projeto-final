<template>

    <div>testefrtshfsfs</div>
</template>


<script>
    import axios from "axios";
    import $ from 'jquery'
    export default {
        name: "dash55board",
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

