<template>
    <div class="section-quizz mt-5 me-md-5 ms-md-5">


        <div class="card-loading is-loading mt-5" id="card-loading-quiz">
            <div class="content">
                <h2></h2>
                <br><br>
                <p></p>
            </div>
        </div>

        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastEditarQuizz" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span>Quizz editado com sucesso!!</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastEliminarQuizz" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span>Quizz eliminado com sucesso!!</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toast-quiz" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span>Quizz adicionado com sucesso!!</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>


        <div v-if="!isFetching">
            <div v-if="quizz.data.length === 0" class="mx-auto" id="quiz-adicionar">
                <h1 class="heanding-1 mx-auto mt-5">Ainda não tem nenhum Quizz</h1>
                <!-- Button trigger modal -->
                <button type="button" class=" btn btn-new mt-5 mx-auto" data-bs-toggle="modal"
                        data-bs-target="#exampleModal2">
                    <i class="bi bi-plus-circle"></i> &nbsp;&nbsp; Adicionar Quizz
                </button>
            </div>

            <div v-else class="section-disciplinas-items" id="lista-quizes">
                <div class="box-search mb-5">
                    <input class=" form-control form-control-lg form-search" type="text" v-model="search"
                           placeholder="Pesquisar Quizz...">
                    <i class="bi bi-search"></i>
                </div>
                <h1>Quizz</h1>
                <ul>
                    <li class="card-box mb-5 mt-5" v-for="quizz in filter" :key="quizz['id']">

                        <div>
                            <div class="card-box-text">
                                <h2>{{quizz['nome']}}</h2>
                                <div class="dropdown ms-auto">
                                    <button class="" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                    :data-bs-target="'#editarQuizz' + quizz['id']"
                                                    @click="listTopicosQuizz(quizz['id'])">Editar
                                            </button>

                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                    :data-bs-target="'#eliminarQuizz' + quizz['id']">Eliminar
                                            </button>
                                        </li>
                                        <li>
                                            <button v-if="quizz['visivel'] === 'false'" type="button"
                                                    class="dropdown-item" @click="tornarVisivel(quizz['id'])">Tornar
                                                Visivel
                                            </button>
                                            <button v-else type="button" class="dropdown-item"
                                                    @click="ocultarQuizz(quizz['id'])">Ocultar Quizz
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                                <span data-bs-toggle="collapse" :data-bs-target="'#collapseQuizz'+quizz['id']"
                                      aria-expanded="false"
                                      :aria-controls="'collapseQuizz'+quizz['id']" class="material-icons"
                                      @click="changeButton(quizz['id'])" style="cursor: pointer">
                                         <img :id="'img'+quizz['id']" src="/assets/expand_more_black_24dp.svg">
                                 </span>
                            </div>


                        </div>

                        <div class="mt-2">
                            <div class="collapse mt-2" :id="'collapseQuizz'+quizz['id']">

                                <p>Tipo:
                                    <span v-if="quizz['tipo'] === 'false'">Teste </span>
                                    <span v-else>Quizz </span>
                                </p>
                                <p>Número de perguntas: {{quizz['numeroperguntas']}}</p>
                                <p>Visivel:
                                    <span v-if="quizz['visivel'] === 'false'">Não </span>
                                    <span v-else>Sim </span>
                                </p>
                                <p>Vale Pontos:
                                    <span v-if="quizz['vale_pontos'] === 'false'">Não </span>
                                    <span v-else>Sim </span>
                                </p>

                                <div class="text-end d-flex">
                                    <button type="button" data-bs-toggle="modal" :data-bs-target="'#t'+quizz['id']"
                                            class="btn btn-secondary ms-auto ">Histórico
                                    </button>
                                    <div v-if="quizz['tipo']==='true'">
                                        <button type="button" data-bs-toggle="modal" :data-bs-target="'#t'+quizz['id']"
                                                class="btn btn-secondary ms-3 ">Iniciar Quizz
                                        </button>
                                        <div class="modal fade" :id="'t'+quizz['id']" tabindex="-1"
                                             aria-labelledby="exampleModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Iniciar quizz</h5>
                                                        <button type="button" class="btn-close" data-bs-toogle="modal"
                                                                aria-label="Close"
                                                                data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        <p class="text-start">Tem a certeza que quer iniciar este
                                                            teste?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn  btn-secondary"
                                                                data-bs-dismiss="modal"
                                                                @click="EnterQuizz(quizz['id'])">Sim
                                                        </button>
                                                        <button type="button" class="btn btn-primary"
                                                                data-bs-dismiss="modal">
                                                            Não
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>

                        <!-- Modal -->
                        <div class="modal fade" :id="'eliminarQuizz' + quizz['id']" tabindex="-1"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" :id="'tituloEliminar' + quizz['id']">Eliminar Quizz</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h2>Tem certeza que deseja eliminar o quizz {{quizz['nome']}}?</h2>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Cancelar
                                        </button>
                                        <button type="button" class="btn btn-primary eliminar-btn"
                                                :id="'eliminarUtilizadorBtn' + quizz['id']"
                                                @click="eliminarQuizz(quizz)">
                                            <span class="">Sim</span>
                                            <div class="spinner-border text-light d-none" role="status">

                                            </div>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade modal-quizz" :id="'editarQuizz'+quizz['id']" tabindex="-1"
                             aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" :id="'exampleModalLabeleditarQuizz'+quizz['id']">
                                            Editar Quizz</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body pt-5 pb-5">
                                        <form class="row mx-auto" :id="'formEditarQuizz' + quizz['id']">
                                            <div class="col-12">
                                                <label class="label" for="titulo">Titulo</label>
                                                <input name="titulo" class="form-control mt-2 mb-3 " type="text"
                                                       :id="'titulo'+quizz['id']" :value="quizz['nome']">

                                            </div>
                                            <div class="col-12">
                                                <p class="error " :id="'TituloError' + quizz['id']"></p>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <label class="label" for="quizzdescricao">Descrição</label>
                                                <textarea class="form-control" :value="quizz['descricao']"
                                                          :name="'quizzdescricao'+ quizz['id']" :id="'quizzdescricao' + quizz['id']"
                                                          rows="2"></textarea>

                                            </div>

                                            <div class="col-md-4 mb-5 mb-xs-0 text-center">
                                                <div :id="'realTime'+ quizz['id']" class="mb-1 mt-5">
                                                    <h4>Realtime</h4>
                                                    <div class="mb-1">
                                                        <label>
                                                            <input type="radio" :name="'realtimeop' + quizz['id']"
                                                                   value="true" v-bind:checked="quizz['tipo'] === 'true'" > Sim
                                                        </label>
<!--                                                        <label v-else>-->
<!--                                                            <input type="radio" :name="'realtimeop' + quizz['id']"-->
<!--                                                                   value="true"> Sim-->
<!--                                                        </label>-->

                                                    </div>
                                                    <div>
                                                        <label>
                                                            <input type="radio" :name="'realtimeop' + quizz['id']"
                                                                   value="false" v-bind:checked="quizz['tipo'] === 'false'">Não
                                                        </label>
<!--                                                        <label v-else>-->
<!--                                                            <input type="radio" :name="'realtimeop' + quizz['id']"-->
<!--                                                                   value="false">Não-->
<!--                                                        </label>-->

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-5 mb-xs-0 text-center">
                                                <div :id="'pontos' + quizz['id']" class="mb-1 mt-5">
                                                    <h4>Vale Pontos?</h4>
                                                    <div class="mb-1">
                                                        <label >
                                                            <input type="radio" :name="'Valepontos' +quizz['id']"
                                                                   value="true" v-bind:checked="quizz['vale_pontos'] === 'true'"> Sim
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <label >
                                                            <input type="radio" :name="'Valepontos' +quizz['id']"
                                                                   value="false" v-bind:checked="quizz['vale_pontos'] === 'false'">Não
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-5 mb-xs-0 text-center">
                                                <div :id="'Visivel'+quizz['id']" class="mb-1 mt-5">
                                                    <h4>Visivel</h4>
                                                    <div class="mb-1">
                                                        <label v-if="">
                                                            <input type="radio" :name="'Visivelop' + quizz['id']"
                                                                   value="true"
                                                                   v-bind:checked="quizz['visivel'] === 'true'">&nbsp;Sim
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <label>
                                                            <input type="radio" :name="'Visivelop' + quizz['id']"
                                                                   value="false" v-bind:checked="quizz['visivel'] === 'false'">&nbsp;Não
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p :id="'TError' + quizz['id']"></p>
                                                <p :id="'PError' + quizz['id']"></p>
                                                <p :id="'ErrorVisivel' + quizz['id']"></p>
                                            </div>


                                            <div class="col-12 mt-1">
                                                <label class="label" :for="'nPerguntas' +quizz['id'] ">Numero perguntas</label>
                                                <input class="form-control" :name="'nPerguntas' + quizz['id']"
                                                       :id="'nPerguntas' + quizz['id']"
                                                       type="number" :value="quizz['numeroperguntas']">

                                            </div>
                                            <div class="col-12 mb-5">
                                                <p class="error " :id="'NumeroError' + quizz['id']"></p>
                                            </div>

                                            <div class="col-12">
                                                <div v-if="topicosQuizz.length !== 0">
                                                    <div class="mb-5 mt-4" v-for="topico in topicos.data"
                                                         :key="topico['id']">

                                                        <div class="card-box-topicos">
                                                            <label class="d-flex " :for="'inputTopico' + topico['id'] + quizz['id']">
                                                                <h2>
                                                                    {{topico['nome']}}</h2>
                                                                <input
                                                                    :id="'inputTopico' + topico['id'] + quizz['id']"
                                                                    class="ms-auto mt-3" type="checkbox"
                                                                    :value="topico['id']" :name="'topico' + quizz['id']"
                                                                    v-bind:checked="checked(topico['id'])">
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-12 mb-5">
                                                <p class="error " :id="'TopicoError'+quizz['id']"></p>
                                            </div>


                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar
                                        </button>
                                        <button type="button" :id="'submitQuizz'+quizz['id']"
                                                class="btn btn-secondary btn-submit btn-loading"
                                                @click="editarQuizz(quizz)"><span class="">Guardar &nbsp;</span>
                                            <div class="spinner-border text-light d-none" role="status">

                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </li>
                </ul>


            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade modal-quizz" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar Novo Quizz</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-5 pb-5">
                        <form class="row mx-auto" id="adicionarQuizz">
                            <div class="col-12">
                                <label class="label" for="titulo">Titulo</label>
                                <input name="titulo" class="form-control mt-2 mb-3 " type="text" id="titulo">

                            </div>
                            <div class="col-12">
                                <p class="error " id="TituloError"></p>
                            </div>
                            <div class="col-12 mt-3">
                                <label class="label" for="quizzdescricao">Descrição</label>
                                <textarea class="form-control" name="quizzdescricao" id="quizzdescricao"
                                          rows="2"></textarea>

                            </div>

                            <div class="col-md-4 mb-5 mb-xs-0 text-center">
                                <div id="realTime" class="mb-1 mt-5">
                                    <h4>Realtime</h4>
                                    <div class="mb-1">
                                        <label> <input type="radio" name="realtimeop" value="true" class=""> Sim</label>

                                    </div>
                                    <div>
                                        <label> <input type="radio" name="realtimeop" value="false" class="">
                                            Não</label>

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-4 mb-5 mb-xs-0 text-center">
                                <div id="pontos" class="mb-1 mt-5">
                                    <h4>Vale Pontos?</h4>
                                    <div class=" btn-group mb-1">
                                        <label> <input type="radio" name="Valepontos" value="true" class=""> Sim</label>
                                        <label><input id="avalicaoNumber" type="number" value="0"></label>

                                    </div>
                                    <div>
                                        <label> <input type="radio" name="Valepontos" value="false" class="">
                                            Não</label>

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-4 mb-5 mb-xs-0 text-center">
                                <div id="Visivel" class="mb-1 mt-5">
                                    <h4>Visivel</h4>
                                    <div class="mb-1">
                                        <label><input type="radio" name="Visivelop" value="true" class="">&nbsp;
                                            Sim</label>
                                    </div>
                                    <div>
                                        <label><input type="radio" name="Visivelop" value="false" class="">&nbsp;
                                            Não</label>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <p id="TError"></p>
                                <p id="PError"></p>
                                <p id="ErrorVisivel"></p>
                            </div>


                            <div class="col-12 mt-1">
                                <label class="label" for="nPerguntas">Numero perguntas</label>
                                <input class="form-control" name="nPerguntas" id="nPerguntas" type="number">

                            </div>
                            <div class="col-12 mb-5">
                                <p class="error " id="NumeroError"></p>
                            </div>

                            <div class="col-12">
                                <div class="card-box  mb-5 mt-4" v-for="topico in topicos.data" :key="topico['id']">

                                    <div class="card-box-topicos">
                                        <label class="d-flex " :for="'inputTopico' + topico['id']"><h2>
                                            {{topico['nome']}}</h2><input :id="'inputTopico' + topico['id']"
                                                                          class="ms-auto mt-3" type="checkbox"
                                                                          :value="topico['id']" name="topico"></label>
                                    </div>

                                </div>
                            </div>


                            <div class="col-12 mb-5">
                                <p class="error " id="TopicoError"></p>
                            </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="submitQuizz" class="btn btn-secondary btn-submit btn-loading"
                                @click="submitNewQuizz"><span class="">Adicionar &nbsp;</span>
                            <div class="spinner-border text-light d-none" role="status">

                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <pagination-2 :data="quizz" :align="'center'" @pagination-change-page="getResultsQuizz"></pagination-2>
    </div>
</template>

<script>
    import $ from "jquery";
    import axios from "axios";


    export default {
        name: "quizz",
        props: ['topico_prop'],

        data() {
            return {
                modal: '',
                toastQuiz: '',
                search: '',
                topicos: JSON.parse(this.topico_prop),
                quizz: '',
                page: 1,
                isFetching: true,
                modalDeleteQuizz: '',
                modalEditarQuizz: '',
                toastDeleteQuizz: '',
                toastEliminarQuizz: '',
                topicosQuizz: [],
                fetchedQuizzTopico: false
            }
        },

        methods: {
            checked(id) {
                for (let topico of this.topicosQuizz){
                    if (topico['id'] === id){
                        return true
                    }
                }
                return false;
            },
            listTopicosQuizz(id) {
                this.topicosQuizz = []
                axios.get('/prof/getTopicoQuizz/' + id
                ).then(function (response) {

                    this.topicosQuizz = response.data.message;
                    this.fetchedQuizzTopico = true;

                }.bind(this));
            },
            editarQuizz(quizz) {
               let  id = quizz['id'];

                $('.btn-loading span').addClass('d-none');
                $('.btn-loading div').removeClass('d-none');
                let l = window.location.href.split('/');
                var flagTime, corretTime, flagVisibel, corretVisibel, flagPontos, corretPontos;
                var array = [];
                var form = new FormData();
                this.modalEditarQuizz = bootstrap.Modal.getInstance(document.getElementById('editarQuizz' + id), {});
                $('#TituloError' + id).text(" ").css('color', 'red').css('opacity', '1');
                $('#TError' + id).text(" ").css('color', 'red').css('opacity', '1');
                $('#PError'+ id).text(" ").css('color', 'red').css('opacity', '1');
                $('#ErrorVisivel' + id).text(" ").css('color', 'red').css('opacity', '1');
                $('#TopicoError' + id).text(" ").css('color', 'red').css('opacity', '1');
                $('#NumeroError' + id).text(" ").css('color', 'red').css('opacity', '1');

                if ($('#titulo' +id).val().length === 0) {
                    $('#TituloError' + id).text("Indique um titulo para o quizz").css('color', 'red').css('opacity', '1');
                    $('.btn-loading span').removeClass('d-none');
                    $('.btn-loading div').addClass('d-none');

                } else {

                    var radios = document.getElementsByName("realtimeop" + id);
                    for (let i = 0; i < 2; i++) {
                        if (radios[i].checked) {
                            flagTime = true;
                            corretTime = radios[i].value;
                        }
                    }
                    if (!flagTime) {
                        $('#TError' + id).text("Indique o tipo de quizz que quer").css('color', 'red').css('opacity', '1');
                        $('.btn-loading span').removeClass('d-none');
                        $('.btn-loading div').addClass('d-none');
                    }else {
                        form.append('realtime', corretTime);
                        form.append('titulo', $('#titulo' + id).val());
                        form.append('descricao', $('#quizzdescricao' + id).val());
                        var radios2 = document.getElementsByName("Visivelop" + id);
                        for (let i = 0; i < 2; i++) {
                            if (radios2[i].checked) {
                                flagVisibel = true;
                                corretVisibel = radios2[i].value;
                            }
                        }

                        if (!flagVisibel) {
                            $('#ErrorVisivel' +id).text("Indique se quer o teste já visivel ou não").css('color', 'red').css('opacity', '1');
                            $('.btn-loading span').removeClass('d-none');
                            $('.btn-loading div').addClass('d-none');
                        } else {
                            form.append('visible', corretVisibel);


                            let radios3 = document.getElementsByName("Valepontos" + id);
                            for (let i = 0; i < 2; i++) {

                                if (radios3[i].checked) {
                                    flagPontos = true;
                                    corretPontos = radios3[i].value;
                                }
                            }

                            if (!flagPontos) {
                                $('#ErrorVisivel' + id).text("Indique se o quiz vale pontos ou não").css('color', 'red').css('opacity', '1');
                                $('.btn-loading span').removeClass('d-none');
                                $('.btn-loading div').addClass('d-none');
                            } else {
                                form.append('pontos', corretPontos);
                                if ($('#nPerguntas'+ id).val() < 3) {
                                    $('#NumeroError' + id).text("Um quizz deve ter pelo menos três perguntas").css('color', 'red').css('opacity', '1');
                                    $('.btn-loading span').removeClass('d-none');
                                    $('.btn-loading div').addClass('d-none');

                                } else {
                                    form.append('nPerguntas', $('#nPerguntas' + id).val());
                                    var check = document.getElementsByName("topico" + id);
                                    var count = 0


                                    for (let i = 0; i < check.length; i++) {

                                        if (check[i].checked) {
                                            array.push(check[i].value)
                                            count++

                                        }
                                    }

                                    if (count === 0) {
                                        $('#TopicoError' + id).text("Tem que indicar pelo menos um topico").css('color', 'red').css('opacity', '1');
                                        $('.btn-loading span').removeClass('d-none');
                                        $('.btn-loading div').addClass('d-none');
                                    } else {
                                        form.append('array', JSON.stringify(array));
                                        form.append('id', id);
                                        form.append('numeroPerguntasAntigo', quizz['numeroperguntas']);


                                        axios.post('/prof/quizz/' + id + '/editar', form
                                        ).then(function (response) {
                                            if (response.data.message === "sucesso") {

                                                $('.btn-loading span').removeClass('d-none');
                                                $('.btn-loading div').addClass('d-none');
                                                this.modalEditarQuizz.hide();
                                                this.toastEditarQuizz.show();
                                                $('#toastEditarQuizz').removeClass('d-none');
                                            }else if (response.data.message === "numero de perguntas invalido") {
                                                $('#NumeroError' + id).text("numero de perguntas invalido").css('color', 'red').css('opacity', '1');
                                                $('.btn-loading span').removeClass('d-none');
                                                $('.btn-loading div').addClass('d-none');
                                            } else {
                                                alert("Erro a tentar editar o quizz");
                                                this.modal.hide();
                                                this.modalEditarQuizz.hide();
                                                $('.btn-loading span').removeClass('d-none');
                                                $('.btn-loading div').addClass('d-none');
                                            }

                                        }.bind(this));


                                    }


                                }

                            }


                        }
                    }
                }
            },
            eliminarQuizz(quizz) {
                $('.eliminar-btn span').addClass('d-none');
                $('.eliminar-btn div').removeClass('d-none');

                this.modalDeleteQuizz = bootstrap.Modal.getInstance(document.getElementById('eliminarQuizz' + quizz['id']), {});

                axios.delete('/prof/quizz/delete/' + quizz['id']).then(
                    function (response) {

                        if (response.data.message !== "erro") {
                            $('.eliminar-btn span').removeClass('d-none');
                            $('.eliminar-btn div').addClass('d-none');
                            this.toastEliminarQuizz.show();

                            $('#toastEliminarQuizz').removeClass('d-none');
                            this.quizz = response.data.message;

                            this.modalDeleteQuizz.hide();

                        }
                    }.bind(this));
            },
            ocultarQuizz(id) {

                axios.post('/prof/quizz/ocultarquizz/' + id).then(function (response) {

                    if (response.data.message !== 'erro') {
                        let quizz = response.data.message


                        for (let i = 0; i < this.quizz.data.length; i++) {
                            if (quizz[0]['id'] === this.quizz.data[i]['id']) {
                                this.quizz.data[i]['visivel'] = quizz[0]['visivel']
                            }
                        }
                    }

                }.bind(this));

            },
            tornarVisivel(id) {
                axios.post('/prof/quizz/tornarvisivel/' + id).then(function (response) {

                    if (response.data.message !== 'erro') {
                        let quizz = response.data.message


                        for (let i = 0; i < this.quizz.data.length; i++) {
                            if (quizz[0]['id'] === this.quizz.data[i]['id']) {
                                this.quizz.data[i]['visivel'] = quizz[0]['visivel']
                            }
                        }
                    }

                }.bind(this));


            },
            changeButton(id) {
                if ($('#img' + id).attr('src') === '/assets/expand_more_black_24dp.svg') {
                    $('#img' + id).attr('src', '/assets/expand_less_black_24dp.svg')
                } else if ($('#img' + id).attr('src') === '/assets/expand_less_black_24dp.svg') {
                    $('#img' + id).attr('src', '/assets/expand_more_black_24dp.svg')
                }
            },
            EnterQuizz(quizz) {

                window.location.replace('/WaitRoom/' + quizz);

            },
            getResultsQuizz(page = 1) {

                axios.get('/getQuizz?page=' + page)
                    .then(response => {
                        this.quizz = response.data.message;
                    });
            },
            submitNewQuizz() {
                $('.btn-loading span').addClass('d-none');
                $('.btn-loading div').removeClass('d-none');
                let l = window.location.href.split('/');
                var flagTime, corretTime, flagVisibel, corretVisibel, flagPontos, corretPontos,numberAvaliacoes;
                var array = [];
                var form = new FormData();
                $('#TituloError').text(" ").css('color', 'red').css('opacity', '1');
                $('#TError').text(" ").css('color', 'red').css('opacity', '1');
                $('#PError').text(" ").css('color', 'red').css('opacity', '1');
                $('#ErrorVisivel').text(" ").css('color', 'red').css('opacity', '1');
                $('#TopicoError').text(" ").css('color', 'red').css('opacity', '1');
                $('#NumeroError').text(" ").css('color', 'red').css('opacity', '1');

                if ($('#titulo').val().length === 0) {
                    $('#TituloError').text("Indique um titulo para o quizz").css('color', 'red').css('opacity', '1');
                    $('.btn-loading span').removeClass('d-none');
                    $('.btn-loading div').addClass('d-none');

                } else {

                    var radios = document.getElementsByName("realtimeop");
                    for (let i = 0; i < 2; i++) {
                        if (radios[i].checked) {
                            flagTime = true;
                            corretTime = radios[i].value;
                        }
                    }
                    if (!flagTime) {
                        $('#TError').text("Indique o tipo de quizz que quer").css('color', 'red').css('opacity', '1');
                        $('.btn-loading span').removeClass('d-none');
                        $('.btn-loading div').addClass('d-none');
                    } else {

                        form.append('realtime', corretTime);
                        form.append('titulo', $('#titulo').val());
                        form.append('descricao', $('#quizzdescricao').val());
                        var radios2 = document.getElementsByName("Visivelop");
                        for (let i = 0; i < 2; i++) {
                            if (radios2[i].checked) {
                                flagVisibel = true;
                                corretVisibel = radios2[i].value;
                            }
                        }
                        if (!flagVisibel) {
                            $('#ErrorVisivel').text("Indique se quer o teste já visivel ou não").css('color', 'red').css('opacity', '1');
                            $('.btn-loading span').removeClass('d-none');
                            $('.btn-loading div').addClass('d-none');
                        } else {
                            form.append('visible', corretVisibel);


                            let radios3 = document.getElementsByName("Valepontos");
                            for (let i = 0; i < 2; i++) {

                                if (radios3[i].checked) {
                                    flagPontos = true;
                                    corretPontos = radios3[i].value;
                                    if (corretPontos==='true'){
                                        numberAvaliacoes=$('#avalicaoNumber').val();

                                        if (numberAvaliacoes<=0 || numberAvaliacoes===null){
                                            $('#ErrorVisivel').text("Indique o numero de tentativas").css('color', 'red').css('opacity', '1');
                                            $('.btn-loading span').removeClass('d-none');
                                            $('.btn-loading div').addClass('d-none');
                                        }
                                    }
                                }
                            }


                            if (!flagPontos) {
                                $('#ErrorVisivel').text("Indique se o quiz vale pontos ou não").css('color', 'red').css('opacity', '1');
                                $('.btn-loading span').removeClass('d-none');
                                $('.btn-loading div').addClass('d-none');
                            } else {
                                form.append('pontos', corretPontos);
                                form.append('numeroAvaliaçoes',numberAvaliacoes);
                                if ($('#nPerguntas').val() < 3) {
                                    $('#NumeroError').text("Um quizz deve ter pelo menos três perguntas").css('color', 'red').css('opacity', '1');
                                    $('.btn-loading span').removeClass('d-none');
                                    $('.btn-loading div').addClass('d-none');

                                } else {
                                    form.append('nPerguntas', $('#nPerguntas').val());
                                    var check = document.getElementsByName("topico");
                                    var count = 0


                                    for (let i = 0; i < check.length; i++) {

                                        if (check[i].checked) {
                                            array.push(check[i].value)
                                            count++

                                        }
                                    }

                                    if (count === 0) {
                                        $('#TopicoError').text("Tem que indicar pelo menos um topico").css('color', 'red').css('opacity', '1');
                                        $('.btn-loading span').removeClass('d-none');
                                        $('.btn-loading div').addClass('d-none');
                                    } else {
                                        form.append('array', JSON.stringify(array));
                                        form.append('id', l[l.length - 1]);
                                       this.sendQuizz(form);
                                    }


                                }
                            }


                        }


                    }
                }
            },
            sendQuizz(form) {
                $('#submitQuizz').prop('disabled', true);

                axios.post('/insertQuizz', form
                ).then(function (response) {
                    if (response.data.message === "sucesso") {

                        $('.btn-loading span').removeClass('d-none');
                        $('.btn-loading div').addClass('d-none');

                        var radios = document.getElementsByName("realtimeop");
                        for (let i = 0; i < 2; i++) {

                            if (radios[i].checked) {
                                radios[i].checked = false;
                            }
                        }

                        var radios2 = document.getElementsByName("Visivelop");
                        for (let i = 0; i < 2; i++) {
                            if (radios2[i].checked) {
                                radios2[i].checked = false;
                            }
                        }

                        let radios3 = document.getElementsByName("Valepontos");
                        for (let i = 0; i < 2; i++) {

                            if (radios3[i].checked) {
                                radios3[i].checked = false;
                            }
                        }

                        var check = document.getElementsByName("topico");
                        for (let i = 0; i < check.length; i++) {

                            if (check[i].checked) {
                                check[i].checked = false;

                            }
                        }
                        $('#nPerguntas').val('')
                        $('#titulo').val('');
                        $('#quizzdescricao').val('');


                        this.listQuizz();
                        $('#submitQuizz').prop('disabled', false);
                        this.modal.hide();
                        this.toastQuiz.show();
                        $('#toast-quiz').removeClass('d-none');
                    } else if (response.data.message === "numero de perguntas invalido") {
                        $('#NumeroError').text("numero de perguntas invalido").css('color', 'red').css('opacity', '1');
                        $('#submitQuizz').prop('disabled', false);
                        $('.btn-loading span').removeClass('d-none');
                        $('.btn-loading div').addClass('d-none');
                    } else {
                        alert("Erro a tentar inserir o quizz");
                        $('#submitQuizz').prop('disabled', false);
                        this.modal.hide();
                        $('.btn-loading span').removeClass('d-none');
                        $('.btn-loading div').addClass('d-none');
                    }

                }.bind(this));
            },
            listQuizz() {

                axios.get('/getQuizz?page=1'
                ).then(function (response) {

                    this.quizz = response.data.message;
                    $('#card-loading-quiz').hide();
                    $('#lista-quizes').show();
                    $('#quiz-adicionar').show();
                    this.isFetching = false;


                }.bind(this));


            },
            topicsCheck() {
                if (this.topicos.length === 0) {

                    $('#submitQuizz').prop('disabled', true);
                } else {
                    $('#submitQuizz').prop('disabled', false);
                }

            },


        },
        computed: {
            filter: function () {
                return this.quizz.data.filter((quizz) => {
                    return quizz['nome'].match(this.search)
                })
            }
        },
        watch: {
            modal: function () {
                // this.modal.addEventListener('show.bs.modal',function () {
                //     console.log('sdfsdf')
                // })
            }
        },
        mounted() {

            this.modal = new bootstrap.Modal(document.getElementById('exampleModal2'), {})
            this.toastQuiz = new bootstrap.Toast(document.getElementById('toast-quiz'), {delay: 10000})
            this.toastQuiz.hide();
            this.topicsCheck();
            this.listQuizz();
            $('#card-loading-quiz').show();
            $('#lista-quizes').hide();
            $('#quiz-adicionar').hide();
            this.toastEliminarQuizz = new bootstrap.Toast(document.getElementById('toastEliminarQuizz'), {delay: 10000})
            this.toastEliminarQuizz.hide()
            this.toastEditarQuizz = new bootstrap.Toast(document.getElementById('toastEditarQuizz'), {delay: 10000})
            this.toastEditarQuizz.hide()

        }

    }


</script>

<style scoped>

</style>
