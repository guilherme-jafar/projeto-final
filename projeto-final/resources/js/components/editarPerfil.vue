
<template>
    <div class="container">
        <div class="row flex-lg-nowrap">
            <div class="col">
                <div class="row">
                    <div class="col mb-3">
                        <form class="card " id="editarPerfil">
                            <div class="card-body">
                                <div class="e-profile">
                                    <div class="row">
                                        <div class="col-12 col-sm-auto mb-3">
                                            <div class="mx-auto" style="width: 140px;">
                                                <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                                                    <img  v-if="utilizador['foto'] === null" :src="'/images/imgDefault.jpg'" id="imgPerfil" class="img-perfil img-fluid" alt="Foto de perfil">
                                                    <img  v-else :src="'/images/' + utilizador['foto']" id="imgPerfil" class="img-perfil img-fluid"  alt="Foto de perfil">

                                                </div>
                                                <p class="error " id="imagemError"></p>
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
                                                    <input class="form-control form-control-lg" name="imagem" accept="image/*" id="imagem"  style="visibility:hidden;" @change="alterarFoto" type="file">

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
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label for="nome">Nome</label>
                                                                    <input class="form-control" type="text" name="nome" id="nome" :placeholder="utilizador['nome']" :value="utilizador['nome']">
                                                                    <p class="error " id="nomeError"></p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input class="form-control" type="email" name="email" id="email" :placeholder="utilizador['email']" :value="utilizador['email']">
                                                            <p class="error " id="emailError"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <div class="form-group">
                                                            <label for="instituicao">Instituição de Ensino</label>
                                                            <input class="form-control" type="text" name="instituicao" id="instituicao" :placeholder="utilizador['instituicao']" :value="utilizador['instituicao']">
                                                            <p class="error " id="instituicaoError"></p>
                                                        </div>
                                                    </div>

                                                    <div v-if="utilizador['tipo'] === 'prof'" class="col-12 mt-3">
                                                        <div class="form-group">
                                                            <label for="descricao">Descrição</label>
                                                            <textarea class="form-control" id="descricao" name="descricao" rows="3" :placeholder="utilizador['descricao']" :value="utilizador['descricao']"></textarea>
                                                        </div>
                                                    </div>

                                                </div>
<!--                                                <div class="row">-->
<!--                                                    <div class="col-12 mb-5 mt-4">-->
<!--                                                        <div class="row">-->
<!--                                                            <div class="col-6">-->
<!--                                                                <div class="form-group">-->
<!--                                                                    <label for="password">Nova Password</label>-->
<!--                                                                    <input class="form-control" type="password" id="password" placeholder="••••••">-->
<!--                                                                </div>-->
<!--                                                                <p class="error" id="passError"></p>-->
<!--                                                            </div>-->
<!--                                                            <div class="col-6">-->
<!--                                                                <div class="form-group">-->
<!--                                                                    <label for="confirmarPasword">confirmar Password</label>-->
<!--                                                                    <input class="form-control" type="password" id="confirmarPasword" placeholder="••••••">-->
<!--                                                                </div>-->
<!--                                                            </div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
                                                <div class="row">
                                                    <div class="col d-flex justify-content-end mt-5 mb-5">
                                                        <a :href="utilizador['tipo'] + '/dashboard'" class="btn btn-primary mt-5 me-3">
                                                            Cancelar
                                                        </a>
                                                        <button name="submit" class="btn btn-primary mt-5  btn-submit"  type="button" id="submit" @click="submit()">
                                                            <span class="">Salvar Alterações &nbsp;</span>
                                                            <div class="spinner-border text-light d-none" role="status">

                                                            </div>
                                                        </button>
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
                utilizador: JSON.parse(this.utilizador_props),
                imagem: ''
            }
        },
        methods: {
            submit() {

                $('#submit span').addClass('d-none');
                $('#submit div').removeClass('d-none');
                $( "#imagemError" ).text(" ").css('color', 'red');
                $( "#emailError" ).text(" ").css('color', 'red');
                $( "#passError" ).text(" ").css('color', 'red');



                var imagem = $('#imagem').val();
                var imagemErro = false;


                if (imagem !== ""){
                    if (imagem.includes(".jpeg") || imagem.includes(".png") || imagem.includes("jpg")){
                        $("#imagemError" ).text(" ").css('color', 'red');
                        imagemErro = false;

                    }else {

                        imagemErro = true;

                    }
                }


                if($( "#email" ).val().length === 0 ){
                    $("#emailError" ).text("O campo encontra-se vazio").css('color', 'red').css('opacity', '1');
                    $('#submit span').removeClass('d-none');
                    $('#submit div').addClass('d-none');


                }else if(imagemErro){
                    $("#imagemError" ).text("Introduza uma imagem válida.").css('color', 'red').css('opacity', '1');
                    $('#submit span').removeClass('d-none');
                    $('#submit div').addClass('d-none');
                } else if($( "#nome" ).val().length === 0 ){
                    $("#nomeError" ).text("O campo encontra-se vazio").css('color', 'red').css('opacity', '1');
                    $('#submit span').removeClass('d-none');
                    $('#submit div').addClass('d-none');

                }else {


                    let formData = new FormData();
                    formData.append( 'nome',$( "#nome" ).val());
                    formData.append( 'email',$( "#email" ).val());
                    formData.append( 'foto',this.imagem);
                    formData.append( 'instituicao',$( "#instituicao" ).val());
                    if (this.utilizador['tipo'] === 'prof'){
                        formData.append( 'descricao',$( "#descricao" ).val());
                    }

                    axios.post('/alterarInformacao', formData
                    ).then(function (response) {



                        if (response.data.message !== "sucesso"){

                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');
                            $("#emailError" ).text("Formato do email é invalido!!").css('color', 'red').css('opacity', '1');

                        }
                        else{
                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');
                            window.location.replace('/sucesso');

                        }

                    }.bind(this));
                }


            },
            alterarFoto(e){
                let imagem = document.getElementById("imgPerfil");
                imagem.src = URL.createObjectURL(e.target.files[0]);
                this.imagem = e.target.files[0];
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

