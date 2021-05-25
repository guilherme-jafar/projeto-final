<template>
    <div>
        <div class="section-mensagem mt-5 me-md-5 ms-md-5">
            <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastMensagem" role="alert"
                 aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                            <span>Mensagem enviada com sucesso!!</span> </strong>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <div v-if="isFetching">
                <div class="card-loading is-loading mt-5" id="card-loading-forum">
                    <div class="content">
                        <h2></h2>
                        <br><br>
                        <p></p>
                    </div>
                </div>
            </div>
            <div v-if="!isFetching">
                <div v-if="mensagens.data.length === 0" class="mx-auto" id="mensagem-adicionar">
                    <h1 class="heanding-1 mx-auto mt-5">Não há nenhuma mensagem!!</h1>
                    <button type="button" class="btn btn-new mt-5 mx-auto" @click="buttonAdicionar" id="btn-new">
                        <i class="bi bi-plus-circle"></i> &nbsp;&nbsp; Adicionar Mensagem
                    </button>

                </div>
                <div v-else class="section-disciplinas-items">
                    <div class="box-search mb-5">
                        <input class=" form-control form-control-lg form-search" type="text" v-model="search"
                               placeholder="Pesquisar Mensagens...">
                        <i class="bi bi-search"></i>
                    </div>
                    <h1>Mensagens</h1>
                    <ul>
                        <li class="card-box mb-5 mt-5" v-for="mensagem in filter" :key="mensagem['id']">
                            <div class="card-box-text">
                                <h2 @click="entrarForum(mensagem['id'])"> {{mensagem['mensagem']}}</h2>
                                <div v-if="tipoUtilizador === 'prof'" class="dropdown ms-auto">
                                    <button class="" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                    :data-bs-target="'#editarQuizz' + mensagem['id']"
                                                    @click="listTopicosQuizz(mensagem['id'])">Editar
                                            </button>

                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                    :data-bs-target="'#eliminarQuizz' + mensagem['id']">Eliminar
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </li>
                    </ul>

                </div>
                <div id="nova-mensagem" class="nova-mensagem d-none ">
                    <div class="d-flex">
                        <input class=" form-control form-control-lg" id="textoMensagem" type="text" v-model="search"
                               placeholder="Escreva a mensagem...">
                        <!--                    <i class="bi bi-search"></i>-->
                        <button type="button" id="submit" class="btn btn-secondary btn-submit btn-loading"
                                @click="send()"><span
                            class="">Enviar &nbsp;</span>
                            <div class="spinner-border text-light d-none" role="status">

                            </div>
                        </button>
                    </div>
                    <small class="error " id="mensagemError"></small>


                </div>

            </div>


        </div>

    </div>
</template>

<script>
    import forum from "./forum";
    import $ from "jquery";
    import axios from "axios";
    export default {
        name: "mensagem",
        data() {
            return {
                componentInicial: forum,
                forumId: this.$parent.idForum,
                tipoUtilizador: this.$parent.tipoUtilizador,
                mensagens: '',
                search: '',
                isFetching: true,
                toastMensagem: ''
            }
        },
        methods: {
            send(){

                $('#submit span').addClass('d-none');
                $('#submit div').removeClass('d-none');
                var enviar = true;
                $("#mensagemError").text("").css('color', 'red').css('opacity', '1');
                if ($('#textoMensagem').val().length === 0) {
                    $("#mensagemError").text("Introduza a mensagem!!").css('color', 'red').css('opacity', '1');
                    $('#submit span').removeClass('d-none');
                    $('#submit div').addClass('d-none');
                    enviar = false;
                } else {
                    $("#textoMensagem").text("").css('color', 'red').css('opacity', '1');
                }

                this.toastMensagem.show();
                if (enviar) {

                    let formData = new FormData();
                    formData.append('textoMensagem', $("#textoMensagem").val());
                    formData.append('idForum', this.forumId);
                    formData.append('mensagem', 'true');
                    axios.post('/mensagem/create', formData
                    ).then(function (response) {


                        if (response.data.message !== "erro") {
                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');
                            this.mensagens = response.data.message
                            this.toastMensagem.show();
                            $('#toastMensagem').removeClass('d-none');

                        } else {

                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');

                        }
                    }.bind(this));
                }
            },
            listMensagem(id) {
                axios.get('/getMensagens/' + id + '?page=1'
                ).then(function (response) {

                    this.mensagens = response.data.message;
                    this.isFetching = false;


                }.bind(this));

            },
            buttonAdicionar(){
                $('#mensagem-adicionar').hide()

                $('#nova-mensagem').removeClass('d-none')
            }
        },
        computed: {
            filter() {
                return this.mensagens.data.filter((mensagem) => {
                    return mensagem['mensagem'].match(this.search);
                })
            }
        },
        mounted() {
            this.listMensagem(this.forumId)
            this.toastMensagem = new bootstrap.Toast(document.getElementById('toastMensagem'), {delay: 10000})
            this.toastMensagem.hide();
        }
    }
</script>

<style scoped>

</style>
