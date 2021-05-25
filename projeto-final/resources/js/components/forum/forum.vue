<template>
    <div class="section-forum mt-5 me-md-5 ms-md-5">

        <div v-if="isFetching">
            <div class="card-loading is-loading mt-5" id="card-loading-forum">
                <div class="content">
                    <h2></h2>
                    <br><br>
                    <p></p>
                </div>
            </div>
        </div>


        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastForum" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span>Fórum criado com sucesso!!</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div v-if="!isFetching">
            <div v-if="forum.data.length === 0" class="mx-auto" id="forum-adicionar">
                <h1 class="heanding-1 mx-auto mt-5">Não há nenhum fórum de discussões!!</h1>
                <!-- Button trigger modal -->
                <button type="button" class=" btn btn-new mt-5 mx-auto" data-bs-toggle="modal"
                        data-bs-target="#modalAdicionarForum">
                    <i class="bi bi-plus-circle"></i> &nbsp;&nbsp; Adicionar Fórum
                </button>
            </div>
            <div v-else class="section-disciplinas-items">
                <div class="box-search mb-5">
                    <input class=" form-control form-control-lg form-search" type="text" v-model="search"
                           placeholder="Pesquisar foruns...">
                    <i class="bi bi-search"></i>
                </div>
                <h1>Fóruns</h1>
                <ul>
                    <li class="card-box mb-5 mt-5" v-for="forum in filter" :key="forum['id']" role="button">
                        <div class="card-box-text">
                            <h2 @click="entrarForum(forum['id'])"> {{forum['topico']}}</h2>
                            <div v-if="tipoUtilizador === 'prof'" class="dropdown ms-auto">
                                <button class="" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>

                                <ul  class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                :data-bs-target="'#editarQuizz' + forum['id']"
                                                @click="listTopicosQuizz(forum['id'])">Editar
                                        </button>

                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                :data-bs-target="'#eliminarQuizz' + forum['id']">Eliminar
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </li>
                </ul>

            </div>

        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalAdicionarForum" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar Fórum de Discussão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-5 pb-5">
                        <form class="row mx-auto" id="adicionarForum">
                            <div class="col-12">
                                <label class="label" for="nomeforum">Nome</label>
                                <input name="nomeforum" class="form-control mt-2 mb-3 " type="text" id="nomeforum">

                            </div>
                            <div class="col-12 ">
                                <p class="error " id="nomeforumError"></p>
                            </div>
                            <div class="col-12 mt-2">
                                <label class="label" for="assuntoForum">Assunto</label>
                                <textarea class="form-control" name="assuntoForum" id="assuntoForum"
                                          rows="2"></textarea>

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

        <pagination-2 :data="forum" :align="'center'" @pagination-change-page="listForum"></pagination-2>
    </div>

</template>

<script>
    import $ from "jquery";
    import axios from "axios";
   // import Mensagem from "./mensagem";

    export default {
        name: "forum",
        //components: {Mensagem},
        props: ['tipo_prop'],
        data() {
            return {
                forum: '',
                isFetching: true,
                modalforum: '',
                toastForum: '',
                search: '',
                tipoUtilizador: this.tipo_prop,
            }
        },
        methods: {
            entrarForum(forum){
                this.$root.$emit('mudar', forum);
            },
            listForum() {

                axios.get('/getForum?page=1'
                ).then(function (response) {

                    this.forum = response.data.message;
                    this.isFetching = false;


                }.bind(this));


            },
            submit() {

                $('#submit span').addClass('d-none');
                $('#submit div').removeClass('d-none');
                var enviar = true;
                $("#nomeforumError").text("").css('color', 'red').css('opacity', '1');
                if ($('#nomeforum').val().length === 0) {
                    $("#nomeforumError").text("Introduza o nome do Fórum de discussão!!").css('color', 'red').css('opacity', '1');
                    $('#submit span').removeClass('d-none');
                    $('#submit div').addClass('d-none');
                    enviar = false;
                } else {
                    $("#nomeforumError").text("").css('color', 'red').css('opacity', '1');
                }


                if (enviar) {

                    let formData = new FormData();
                    formData.append('nomeforum', $("#nomeforum").val());
                    formData.append('assuntoForum', $("#assuntoForum").val());
                    axios.post('/forum/create', formData
                    ).then(function (response) {


                        if (response.data.message !== "erro") {
                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');
                            this.forum = response.data.message
                            this.toastForum.show();
                            $('#toastForum').removeClass('d-none');
                            this.modalforum.hide()
                        } else {

                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');

                        }
                    }.bind(this));
                }
            }

            },
            computed: {
                filter() {
                    return this.forum.data.filter((forum) => {
                        return forum['topico'].match(this.search);
                    })
                }
            },
            mounted() {

                this.listForum();

                this.modalforum = new bootstrap.Modal(document.getElementById('modalAdicionarForum'), {})
                this.toastForum = new bootstrap.Toast(document.getElementById('toastForum'), {delay: 10000})
                this.toastForum.hide();
            },



        }
</script>

<style scoped>

</style>
