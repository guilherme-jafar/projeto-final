
<template>
    <div class="container">
        <div class="row flex-lg-nowrap">

            <div class="col">
                <div class="row">
                    <div class="col mb-3">
                        <form class="card ">
                            <div class="card-body">
                                <div class="e-profile">
                                    <div class="row">
                                        <div class="col-12 col-sm-auto mb-3">
                                            <div class="mx-auto" style="width: 140px;">
                                                <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                                                    <img  v-if="utilizador['foto'] === null" :src="'/images/imgDefault.jpg'" id="imgPerfil" class="img-perfil img-fluid" alt="Foto de perfil">
                                                    <img  v-else :src="'/images/' + utilizador['foto']" id="imgPerfil" class="img-perfil img-fluid"  alt="Foto de perfil">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                            <div class="text-left text-sm-left mb-2 mb-sm-0 ms-4">
                                                <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"></h4>
                                                <p class="mb-0">{{utilizador['nome']}}</p>
                                                <p class="mb-0">{{utilizador['email']}}</p>
                                                <span class="badge bg-secondary">{{utilizador['tipo'] === 'prof'? 'Professor': 'Aluno'}}</span>
                                                <div class="mt-2">
                                                    <label for="imagem" class="btn btn-primary mt-3">Mudar Foto <i class="fa fa-fw fa-camera"></i></label>
                                                    <input class="form-control form-control-lg" name="imagem" id="imagem" style="visibility:hidden;" @change="alterarFoto" type="file">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a href="" class="active nav-link">Editar Perfil</a></li>
                                    </ul>
                                    <div class="tab-content pt-3">
                                        <div class="tab-pane active">
                                            <div class="form" >
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Nome</label>
                                                                    <input class="form-control" type="text" name="nome" :placeholder="utilizador['nome']" :value="utilizador['nome']">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input class="form-control" type="email" name="" :placeholder="utilizador['email']" :value="utilizador['email']">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 mb-5 mt-4">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>Nova Password</label>
                                                                    <input class="form-control" type="password" placeholder="••••••">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>confirmar Password</label>
                                                                    <input class="form-control" type="password" placeholder="••••••">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col d-flex justify-content-center mt-5 mb-5">
                                                        <button class="btn btn-primary" type="submit">Salvar Alterações</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


</template>

<script>
    import axios from "axios";
    import $ from 'jquery'
    export default {
        name: "editarPerfil",
        props: ['utilizador_props'],
        data(){
            return{
                utilizador: JSON.parse(this.utilizador_props)
            }
        },
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
            },
            alterarFoto(e){
                let imagem = document.getElementById("imgPerfil");
                imagem.src = URL.createObjectURL(e.target.files[0]);
            },
            computed:{
            },
            mounted() {

                this.myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {})
                this.toast = new  bootstrap.Toast(document.getElementById('toast'), {delay: 10000})
                this.toast.hide();


            }
        }


    }
</script>

