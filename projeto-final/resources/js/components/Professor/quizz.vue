<template>
    <div class="section-quizz mt-5 me-md-5 ms-md-5">


        <div class="card-loading is-loading mt-5" id="card-loading-quiz">
            <div class="content">
                <h2></h2>
                <br><br>
                <p></p>
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


        <div v-if="quizz.length === 0" class="mx-auto" id="quiz-adicionar">
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

                    <div v-if="quizz['tipo']==='true'">
                    <div class="card-box-text">
                        <h2>{{quizz['nome']}}</h2>
                        <button type="button" data-bs-toggle="modal" :data-bs-target="'#t'+quizz['id']"
                                class="btn btn-secondary ms-auto ">quizz
                        </button>
                        <i class="bi bi-three-dots-vertical ms-0"></i>
                    </div>


                    <div class="modal fade" :id="'t'+quizz['id']" tabindex="-1" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Entrar em quizz</h5>
                                    <button type="button" class="btn-close" data-bs-toogle="modal" aria-label="Close"
                                            data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">

                                    Tem a certeza que quer iniciar este teste?

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                            @click="EnterQuizz(quizz['id'])">Sim
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    </div>


                    <div v-else-if="quizz['tipo']==='false'">
                        <div class="card-box-text">
                            <h2>{{quizz['nome']}}</h2>

                            <i class="bi bi-three-dots-vertical"></i>
                        </div>
                    </div>
                </li>
            </ul>


        </div>

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
                                <textarea class="form-control" name="quizzdescricao" id="quizzdescricao" rows="2"></textarea>

                            </div>

                            <div class="col-md-4 mb-5 mb-xs-0 text-center">
                                <div id="realTime" class="mb-1 mt-5">
                                    <h4>Realtime</h4>
                                    <div class="mb-1">
                                        <label> <input type="radio" name="realtimeop" value="true" class=""> Sim</label>

                                    </div>
                                    <div>
                                        <label> <input type="radio" name="realtimeop" value="false" class=""> Não</label>

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-4 mb-5 mb-xs-0 text-center">
                                <div id="pontos" class="mb-1 mt-5">
                                    <h4>Vale Pontos?</h4>
                                    <div class="mb-1">
                                        <label>   <input type="radio" name="Valepontos" value="true" class=""> Sim</label>

                                    </div>
                                    <div>
                                        <label> <input type="radio" name="Valepontos" value="false" class=""> Não</label>

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-4 mb-5 mb-xs-0 text-center">
                                <div id="Visivel" class="mb-1 mt-5">
                                    <h4>Visivel</h4>
                                    <div class="mb-1">
                                        <label><input type="radio" name="Visivelop" value="true" class="">&nbsp; Sim</label>
                                    </div>
                                    <div>
                                        <label><input type="radio" name="Visivelop" value="false" class="">&nbsp; Não</label>
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
                                <div class="card-box  mb-5 mt-4" v-for="topico in topicos" :key="topico['id']">

                                    <div class="card-box-topicos">
                                        <label class="d-flex " :for="'inputTopico' + topico['id']"><h2>{{topico['nome']}}</h2><input :id="'inputTopico' + topico['id']" class="ms-auto mt-3" type="checkbox" :value="topico['id']" name="topico"></label>
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
                quizz:'',
                page: 1
            }
        },

        methods: {

            EnterQuizz(quizz) {

                window.location.replace('/WaitRoom/' + quizz );

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
                var flagTime, corretTime, flagVisibel, corretVisibel, flagPontos, corretPontos;
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
                                }
                            }



                            if (!flagPontos){
                                $('#ErrorVisivel').text("Indique se o quiz vale pontos ou não").css('color', 'red').css('opacity', '1');
                                $('.btn-loading span').removeClass('d-none');
                                $('.btn-loading div').addClass('d-none');
                            }else{
                                form.append('pontos', corretPontos);
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
                            console.log(radios[i].checked)
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
                    } else {
                        alert("Erro a tentar inserir o quizz");
                        $('#submitQuizz').prop('disabled', false);
                        this.modal.hide();
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
            },
        },
        watch:{
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


        }

    }


</script>

<style scoped>

</style>
