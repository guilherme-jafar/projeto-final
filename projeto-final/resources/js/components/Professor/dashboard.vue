<template>

    <div>

        <div class="alert alert-primary alert-dismissible fade show mb-5" role="alert">
            <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;Disciplina adicionada com sucesso</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div v-if="disciplinas.length === 0" class="mx-auto">
            <h1 class="heanding-1">Ainda não tem nenhuma disciplina</h1>
            <!-- Button trigger modal -->
            <button type="button" class=" btn btn-new mt-5 mx-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="bi bi-plus-circle"></i> &nbsp;&nbsp; Adicionar Disciplina
            </button>


        </div>

        <div v-else class="section-disciplinas " >
            <div class="box-search mb-5">
                <input class=" form-control form-control-lg form-search" type="search" placeholder="Pesquisar disciplina...">
                <i class="bi bi-search"></i>
            </div>
            <div class="box-text mt-3 mb-4">
                <h2>Minhas Disciplinas</h2>
                <div>
                    <label for="ordenar" class="me-3">Ordenar Por:</label>
                    <select id="ordenar" class="form-select ml-3">
                        <option value="1">Mais Recente</option>
                        <option value="2">Antigos</option>
                    </select>
                </div>

            </div>
            <ul >
                <li class="card-box" v-for="disciplina in disciplinas">

                    <div class="card-image me-5">

                    </div>

                    <div class="card-box-2">
                        <h2>  {{disciplina['nome']}}</h2>
                        <p>Aulas: </p>
                        <div class="mt-5">
                            <p>Tópicos: 0</p>
                            <p>Alunos: 0</p>
                            <p>Quizes: 0</p>
                        </div>

                    </div>
                    <div class="card-box-3">
                        <div>
                            <i class="bi bi-star"></i>
                            <i class="bi bi-three-dots-vertical"></i>
                        </div>
                        <div>
                            <button class="btn btn-third">Partilhar Código</button>
                            <button class="btn btn-secondary">Editar</button>
                        </div>

                    </div>




                </li>
            </ul>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar Disiplina</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-5 pb-5">
                        <form class="row mx-auto" id="adicionarDisciplina">
                            <div class="col-12">

                                <input name="disciplina" class="form-control mt-2 mb-3 " type="text" id="disciplina">
                                <label class="label" for="disciplina" ><span>Disciplina</span></label>
                            </div>
                            <div class="col-12 mb-5">
                                <p class="error " id="disciplinaError"></p>
                            </div>
                            <div class="col-12 mt-3">
                                <label class="label" for="descricao"><span>Descrição</span></label>
                                <textarea class="form-control"  name="descricao" id="descricao" rows="2"></textarea>
                            </div>


<!--                            <div class="col-12 mt-3">-->
<!--                                <div >-->
<!--                                    <label>Permitir alunos marcarem presença?</label><br>-->
<!--                                    <input type="radio" id="sim" name="presencas" value="s">-->
<!--                                    <label class="me-3"  for="sim" >Sim</label>-->
<!--                                    <input type="radio" id="nao" name="presencas" value="n">-->
<!--                                    <label class="me-3" for="nao">Não</label>-->

<!--                                    <p class="error" id="presencasError"></p>-->
<!--                                </div>-->


<!--                            </div>-->


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="submit" class="btn btn-secondary btn-submit" @click="submit()">  <span class="">Adicionar &nbsp;</span>
                            <div class="spinner-border text-light d-none" role="status">

                            </div>
                        </button>
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
        name: "dashboard",
        props: ['disciplinas'],
        data(){
            return{
                myModal: ''
            }
        },
        methods: {
            submit(){
                $('#submit span').addClass('d-none');
                $('#submit div').removeClass('d-none');
                var enviar = true;

                if ($('#disciplina').val().length === 0){
                    $( "#disciplinaError" ).text("Introduza o nome da disciplina").css('color', 'red').css('opacity', '1');
                    $('#submit span').removeClass('d-none');
                    $('#submit div').addClass('d-none');
                    enviar = false;
                }else{
                    $( "#disciplinaError" ).text("").css('color', 'red').css('opacity', '1');
                }



                // var radios = document.getElementsByName('presencas');
                //
                // var test;
                // for (var i = 0, length = radios.length; i < length; i++) {
                //
                //     if (radios[i].checked) {
                //
                //         test = radios[i].value;
                //
                //         break;
                //     }
                //     else {
                //
                //         test = 'erro';
                //
                //     }
                // }


                // if (test === 'erro'){
                //     $( "#presencasError" ).text("Escolha uma opção").css('color', 'red').css('opacity', '1');
                //     $('#submit span').removeClass('d-none');
                //     $('#submit div').addClass('d-none');
                //     enviar = false;
                // }else{
                //     $( "#presencasError" ).text("").css('color', 'red').css('opacity', '1');
                // }


                if (enviar){
                    console.log(enviar)
                    let formData = new FormData();
                    formData.append( 'disciplina',$( "#disciplina" ).val());
                    formData.append( 'descricao',$( "#descricao" ).val());

                    axios.post('/prof/disciplina/create', formData
                    ).then(function (response) {

                        console.log(response.data.message)

                        if (response.data.message !== "sucesso"){
                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');


                        }
                        else{
                            $( "#loading" ).removeClass('spinner-border spinner-border-sm');
                            $('#submit').prop('disabled', false);
                            this.myModal.hide()

                        }
                    }.bind(this));
                }
            },
        },
        computed:{

        },
        mounted() {
            this.disciplinas = JSON.parse(this.disciplinas)
            this.myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {

            })

        }


    }
</script>

