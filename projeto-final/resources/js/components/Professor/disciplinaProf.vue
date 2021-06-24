<template>


    <div class="section-topicos mt-5 me-md-5 ms-md-5">
        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toast" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span>Tópico adicionado com sucesso!!</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastEditarTopico" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span>Tópico editado com sucesso!!</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastEliminarTopico" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span>Tópico eliminado com sucesso!!</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" style="width: 60%" id="toast-pergunta"
             role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span>Pergunta adicionada com sucesso!!</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastEliminarPergunta" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span>Pergunta eliminada com sucesso!!</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastEliminarPerguntaErro"
             role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="toast-error text-danger"><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span class="text-danger">Não foi possivel eliminar a pergunta porque está inserida em um Quizz!!</span>
                    </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastEliminarTopicoErro" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="toast-error text-danger"><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span
                            class="text-danger">Não foi possivel eliminar o tópico porque está inserido em um Quizz!!</span>
                    </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>


        <div v-if="topicos.data.length === 0" class="mx-auto">
            <h1 class="heanding-1 mx-auto mt-5">Ainda não tem nenhum Topico</h1>
            <!-- Button trigger modal -->
            <button type="button" class=" btn btn-new mt-5 mx-auto" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                <i class="bi bi-plus-circle"></i> &nbsp;&nbsp; Adicionar Tópico
            </button>
        </div>
        <div v-else class="section-disciplinas-items ">
            <div class="box-search mb-5">
                <input class=" form-control form-control-lg form-search" type="text" v-model="search"
                       placeholder="Pesquisar topicos...">
                <i class="bi bi-search"></i>
            </div>
            <h1>Tópicos</h1>
            <ul>
                <li class="card-box mb-5 mt-4" v-for="topico in filter" :key="topico['id']">

                    <div class="card-box-text">
                        <h2>{{topico['nome']}}</h2>
                        <div class="dropdown ms-auto">
                            <button class="" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                            :data-bs-target="'#editarTopico' + topico['id']">Editar
                                    </button>

                                </li>
                                <li>
                                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                            :data-bs-target="'#eliminarTopico' + topico['id']">Eliminar
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <span data-bs-toggle="collapse" :data-bs-target="'#collapse'+topico['id']" aria-expanded="false"
                              :aria-controls="'collapse'+topico['id']" class="material-icons"
                              @click="changeButton(topico['id'])" style="cursor: pointer">
                            <img :id="'img'+topico['id']" src="/assets/expand_more_black_24dp.svg">
                        </span>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" :id="'eliminarTopico' + topico['id']" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" :id="'tituloEliminar' + topico['id']">Eliminar Tópico</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h2>Tem certeza que deseja eliminar o tópico {{topico['nome']}}?</h2>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar
                                    </button>
                                    <button type="button" class="btn btn-primary eliminar-btn"
                                            :id="'eliminarUtilizadorBtn' + topico['id']"
                                            @click="eliminarTopico(topico)">
                                        <span class="">Sim</span>
                                        <div class="spinner-border text-light d-none" role="status">

                                        </div>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" :id="'editarTopico' + topico['id']" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Tópico</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body pt-5 pb-5">
                                    <form class="row mx-auto">
                                        <div class="col-12">
                                            <label class="label" :for="'editarTopicoNome' + topico['id']">Topico</label>
                                            <input name="disciplina" class="form-control mt-2 mb-3 " type="text"
                                                   :id="'editarTopicoNome' + topico['id']" :value="topico['nome']">

                                        </div>
                                        <div class="col-12 ">
                                            <p class="error " :id="'disciplinaError' + topico['id']"></p>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label class="label" :for="'descricao' + topico['id']">Descrição</label>
                                            <textarea class="form-control" name="descricao"
                                                      :id="'descricao' + topico['id']" rows="2"
                                                      :value="topico['descricao']"></textarea>

                                        </div>


                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar
                                    </button>
                                    <button type="button" id="submitEdit"
                                            class="btn btn-secondary btn-submit btn-loading"
                                            @click="editarTopico(topico)"><span
                                        class="">Adicionar &nbsp;</span>
                                        <div class="spinner-border text-light d-none" role="status">

                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">

                        <pergunta-topico :topico_id="topico['id']"></pergunta-topico>
                    </div>

                </li>
            </ul>


        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar Tópico</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-5 pb-5">
                        <form class="row mx-auto" id="adicionarDisciplina">
                            <div class="col-12">
                                <label class="label" for="topico">Topico</label>
                                <input name="disciplina" class="form-control mt-2 mb-3 " type="text" id="topico">

                            </div>
                            <div class="col-12 ">
                                <p class="error " id="disciplinaError"></p>
                            </div>
                            <div class="col-12 mt-2">
                                <label class="label" for="descricao">Descrição</label>
                                <textarea class="form-control" name="descricao" id="descricao" rows="2"></textarea>

                            </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="submit" class="btn btn-secondary btn-submit btn-loading"
                                @click="submit()"><span
                            class="">Adicionar &nbsp;</span>
                            <div class="spinner-border text-light d-none" role="status">

                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <pagination-2 :data="topicos" :align="'center'" @pagination-change-page="getResultsTopico"></pagination-2>

    </div>

</template>

<script>
    import $ from 'jquery';
    import axios from "axios";

    export default {
        name: "disciplinaProf",
        props: ['topico_prop'],

        data() {
            return {
                search: '',
                topicos: JSON.parse(this.topico_prop),
                modalDeleteTopico: '',
                toastEliminarTopico: '',
                toastEditartopico: '',
                modalEditarTopico: '',
                toastEliminarPergunta: '',
                toastEliminarPerguntaErro: '',
                toastEliminarTopicoErro: ''
            }
        }, methods: {
            editarTopico(topico) {
                $('.btn-loading span').addClass('d-none');
                $('.btn-loading div').removeClass('d-none');

                this.modalEditarTopico = bootstrap.Modal.getInstance(document.getElementById('editarTopico' + topico['id']), {});

                if ($('#editarTopicoNome' + topico['id']).val().length === 0) {
                    $('#disciplinaError' + topico['id']).text("Introduza o nome do Tópico").css('color', 'red').css('opacity', '1');
                    $('.btn-loading span').removeClass('d-none');
                    $('.btn-loading div').addClass('d-none');
                } else if ($('#descricao' + topico['id']).val().length > 50) {
                    $('#disciplinaError' + topico['id']).text("descricao é muito grande").css('color', 'red').css('opacity', '1');
                    $('.btn-loading span').removeClass('d-none');
                    $('.btn-loading div').addClass('d-none');
                }
                else {
                    let formData = new FormData();
                    let desc= $('#descricao' + topico['id']).val().replace(/(\r\n|\n|\r)/gm, "");
                    formData.append('topico', $('#editarTopicoNome' + topico['id']).val());
                    formData.append('descricao', desc);
                    formData.append('id', topico['id']);
                    axios.post('/prof/topico/' + topico['id'] + '/editar', formData).then(
                        function (response) {


                            $('.btn-loading span').removeClass('d-none');
                            $('.btn-loading div').addClass('d-none');
                            this.toastEditartopico.show();

                            $('#toastEditarTopico').removeClass('d-none');
                            this.topicos = response.data.message;
                            this.getResultsTopico( 1);

                            this.modalEditarTopico.hide();

                        }.bind(this));
                }

            },
            eliminarTopico(topico) {

                $('.eliminar-btn span').addClass('d-none');
                $('.eliminar-btn div').removeClass('d-none');

                this.modalDeleteTopico = bootstrap.Modal.getInstance(document.getElementById('eliminarTopico' + topico['id']), {});

                axios.delete('/prof/topico/delete/' + topico['id']).then(
                    function (response) {

                        if (response.data.message !== "erro") {
                            $('.eliminar-btn span').removeClass('d-none');
                            $('.eliminar-btn div').addClass('d-none');
                            this.toastEliminarTopico.show();

                            $('#toastEliminarTopico').removeClass('d-none');
                            this.topicos = response.data.message;

                            this.modalDeleteTopico.hide();

                        }else{
                            $('.eliminar-btn span').removeClass('d-none');
                            $('.eliminar-btn div').addClass('d-none');
                            this.modalDeleteTopico.hide();
                            this.toastEliminarTopicoErro.show();
                            $('#toastEliminarTopicoErro').removeClass('d-none');
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

            submit() {
                let l = window.location.href.split('/');

                $('#submit span').addClass('d-none');
                $('#submit div').removeClass('d-none');
                var enviar = true;

                if ($('#topico').val().length === 0) {
                    $("#disciplinaError").text("Introduza o nome do topico").css('color', 'red').css('opacity', '1');
                    $('#submit span').removeClass('d-none');
                    $('#submit div').addClass('d-none');
                    enviar = false;
                }
                else if ($("#descricao").val().length > 50) {
                    $("#disciplinaError").text("descricao é muito grande").css('color', 'red').css('opacity', '1');
                    $('.btn-loading span').removeClass('d-none');
                    $('.btn-loading div').addClass('d-none');
                    enviar = false;
                }
                else {
                    $("#disciplinaError").text("").css('color', 'red').css('opacity', '1');
                }

                if (enviar) {
                    let desc= $('#descricao').val().replace(/(\r\n|\n|\r)/gm, "");
                    let formData = new FormData();
                    formData.append('topico', $("#topico").val());
                    formData.append('descricao',desc);
                    formData.append('id', l[l.length - 1]);
                    axios.post('/prof/Topico/create', formData
                    ).then(function (response) {


                        if (response.data.message !== "erro") {
                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');
                            this.myModal.hide()
                            $('#topico').val('')
                            this.topicos = response.data.message;
                            this.toast.show();
                            $('#toast').removeClass('d-none');
                        } else {

                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');

                        }
                    }.bind(this));
                }
            },
            getResultsTopico(page = 1) {

                axios.get('/prof/listTopicos?page=' + page)
                    .then(response => {
                        this.topicos = response.data.message;
                    });
            },
            showToastPergunta(apagou) {

                if (apagou === 1) {
                    this.toastEliminarPergunta.show();
                    $('#toastEliminarPergunta').removeClass('d-none');
                } else if (apagou === 2) {
                    this.toastEliminarPerguntaErro.show();
                    $('#toastEliminarPerguntaErro').removeClass('d-none');
                } else if (apagou === 3) {
                    this.toastPergunta.show();
                    $('#toast-pergunta').removeClass('d-none');
                }

            }
        },
        computed: {
            filter: function () {
                return this.topicos.data.filter((topico) => {
                    return topico['nome'].match(this.search)
                })
            }
        }, mounted() {

            // this.disciplinas = JSON.parse(this.disciplinas)
            this.myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {})
            this.toast = new bootstrap.Toast(document.getElementById('toast'), {delay: 10000})
            this.toast.hide();
            this.toastEliminarTopico = new bootstrap.Toast(document.getElementById('toastEliminarTopico'), {delay: 10000})
            this.toastEliminarTopico.hide()
            this.toastEditartopico = new bootstrap.Toast(document.getElementById('toastEditarTopico'), {delay: 10000})
            this.toastEditartopico.hide()
            this.toastEliminarPergunta = new bootstrap.Toast(document.getElementById('toastEliminarPergunta'), {delay: 10000})
            this.toastEliminarPergunta.hide()
            this.toastEliminarPerguntaErro = new bootstrap.Toast(document.getElementById('toastEliminarPerguntaErro'), {delay: 10000})
            this.toastEliminarPerguntaErro.hide()
            this.toastPergunta = new bootstrap.Toast(document.getElementById('toast-pergunta'), {delay: 10000})
            this.toastPergunta.hide()
            this.toastEliminarTopicoErro = new bootstrap.Toast(document.getElementById('toastEliminarTopicoErro'), {delay: 10000})
            this.toastEliminarTopicoErro.hide()
            this.$root.$on('ShowToastPergunta', this.showToastPergunta);

        }

    }
</script>


