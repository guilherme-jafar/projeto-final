<template>

    <div>
        {{data}}
        <div v-if="data === 'vazio'" class="mx-auto">
            <h1 class="heanding-1">Ainda não tem nenhuma disciplina</h1>
            <!-- Button trigger modal -->
            <button type="button" class=" btn btn-new mt-5 mx-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="bi bi-plus-circle"></i> &nbsp;&nbsp; Adicionar Disciplina
            </button>


        </div>

        <div v-else >

        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar Disiplina</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row mx-auto" id="adicionarDisciplina">
                            <div class="col-12">

                                <input name="disciplina" class="form-control mt-2 mb-3 " type="text" id="disciplina">
                                <label class="label" for="disciplina" ><span>Disciplina</span></label>
                            </div>
                            <div class="col-12 mb-3">
                                <p class="error " id="disciplinaError"></p>
                            </div>
                            <div class="col-12">
                                <label class="label" for="descricao"><span>Descrição</span></label>
                                <textarea class="form-control"  name="descricao" id="descricao" rows="2"></textarea>
                            </div>


                            <div class="col-12 mt-3">
                                <div >
                                    <label>Permitir alunos marcarem presença?</label><br>
                                    <input type="radio" id="sim" name="presencas" value="s">
                                    <label class="me-3"  for="sim" >Sim</label>
                                    <input type="radio" id="nao" name="presencas" value="n">
                                    <label class="me-3" for="nao">Não</label>

                                    <p class="error" id="presencasError"></p>
                                </div>


                            </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="submit()">Adicionar
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

                var radios = document.getElementsByName('presencas');

                var test;
                for (var i = 0, length = radios.length; i < length; i++) {

                    if (radios[i].checked) {

                        test = radios[i].value;

                        break;
                    }
                    else {

                        test = 'erro';

                    }
                }

                console.log(test)

                if (test === 'erro'){
                    $( "#presencasError" ).text("Escolha uma opção").css('color', 'red').css('opacity', '1');
                    $('#submit span').removeClass('d-none');
                    $('#submit div').addClass('d-none');
                    enviar = false;
                }else{
                    $( "#presencasError" ).text("").css('color', 'red').css('opacity', '1');
                }


                if (enviar){
                    console.log(enviar)
                    let formData = new FormData();
                    formData.append( 'disciplina',$( "#disciplina" ).val());
                    formData.append( 'descricao',$( "#descricao" ).val());
                    formData.append( 'presenca',test);
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

                        }
                    }.bind(this));
                }
            },
            decode(){
                return JSON.parse(this.data)
            }
        },
        props: ['data'],
        computed:{

        }


    }
</script>

