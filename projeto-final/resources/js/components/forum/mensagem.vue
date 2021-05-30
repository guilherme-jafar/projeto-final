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
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                </div>
            </div>
            <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastResposta" role="alert"
                 aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                            <span>Resposta enviada com sucesso!!</span> </strong>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                </div>
            </div>

            <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastPontos" role="alert"
                 aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                            <span>Pontos atribuidos com sucesso!!</span> </strong>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
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
                        <li class="card-box card-overflow mb-5 mt-5" v-for="mensagem in filter" :key="mensagem['id']">
                            <div class="card-box-text">
                                <h2>
                                    {{mensagem['nome']}}
                                </h2>
                                <p class="fs-4 mt-2 ms-auto">
                                    {{mensagem['data']}}
                                </p>
                                <div v-if="tipoUtilizador === 'prof'" class="dropdown">
                                    <button class="" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                    :data-bs-target="'#eliminarMensagem' + mensagem['id']">Eliminar
                                            </button>
                                        </li>
                                    </ul>
                                </div>
<!--                                <span data-bs-toggle="collapse" :data-bs-target="'#collapseMensagem'+mensagem['id']"-->
<!--                                      aria-expanded="false"-->
<!--                                      :aria-controls="'collapseQuizz'+mensagem['id']" class="material-icons"-->
<!--                                      @click="changeButton(mensagem['id'])" style="cursor: pointer">-->
<!--                                         <img :id="'img'+mensagem['id']" src="/assets/expand_more_black_24dp.svg">-->
<!--                                 </span>-->
                            </div>
<!--                            <div class="collapse mt-2" :id="'collapseMensagem'+mensagem['id']">-->
<!--                                <p>{{mensagem['mensagem']}}</p>-->

<!--                                <respostas ref="respostas" :tipo_props="mensagem['tipo']" :id_props="mensagem['id']"></respostas>-->
<!--                            </div>-->
                            <div class=" mt-2">
                                <p>{{mensagem['mensagem']}}</p>

                                <respostas ref="respostas" :tipo_props="mensagem['tipo']" :id_props="mensagem['id']"></respostas>
                            </div>


                        </li>
                    </ul>


                </div>
                <div v-if="mandarMensagem" id="nova-mensagem" class="nova-mensagem">

                    <textarea class="form-control form-control-lg" id="textoMensagem"
                              placeholder="Escreva a mensagem..."></textarea>
                    <p class="error " id="mensagemError"></p>
                    <div class="mt-3 text-end">
                        <button type="button" class="ms-3 btn btn-primary btn-submit" @click="buttonAdicionar">Cancelar
                        </button>
                        <button type="button" id="submit" class="ms-3 btn btn-secondary btn-submit btn-loading"
                                @click="send()"><span
                            class="">Enviar &nbsp;</span>
                            <div class="spinner-border text-light d-none" role="status">

                            </div>
                        </button>
                    </div>

                </div>

                <div v-if="!mandarMensagem" class="text-end">
                    <button  type="button" class="btn btn-primary" @click="buttonAdicionar">
                        Adicionar Mensagem
                    </button>
                </div>



            </div>


        </div>
        <pagination-2 :data="mensagens" :align="'center'" @pagination-change-page="listMensagem"></pagination-2>
    </div>
</template>

<script>
    import forum from "./forum";
    import $ from "jquery";
    import axios from "axios";
    import Respostas from "./respostas";

    export default {
        name: "mensagem",
        components: {Respostas},
        data() {
            return {
                componentInicial: forum,
                forumId: this.$parent.idForum,
                tipoUtilizador: this.$parent.tipoUtilizador,
                mensagens: '',
                search: '',
                isFetching: true,
                toastMensagem: '',
                toastResposta: '',
                mandarMensagem: false,
                toastPontos: ''
            }
        },
        methods: {
            changeButton(id) {
                if ($('#img' + id).attr('src') === '/assets/expand_more_black_24dp.svg') {
                    $('#img' + id).attr('src', '/assets/expand_less_black_24dp.svg')
                  //  this.$refs.respostas.listRespostas(id)
                } else if ($('#img' + id).attr('src') === '/assets/expand_less_black_24dp.svg') {
                    $('#img' + id).attr('src', '/assets/expand_more_black_24dp.svg')
                }
            },
            send() {

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
                    $("#mensagemError").text("").css('color', 'red').css('opacity', '1');
                }

                this.toastMensagem.show();
                if (enviar) {

                    let formData = new FormData();
                    formData.append('textoMensagem', $("#textoMensagem").val());
                    formData.append('idForum', this.forumId);
                    formData.append('mensagem', 'true');
                    axios.post('/mensagens/create', formData
                    ).then(function (response) {


                        if (response.data.message !== "erro") {
                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');
                            this.mensagens = response.data.message
                            this.toastMensagem.show();
                            $('#toastMensagem').removeClass('d-none');
                            $('#nova-mensagem').fadeOut('d-none')

                        } else {

                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');

                        }
                    }.bind(this));
                }
            },
            listMensagem(id) {
                axios.get('/mensagens/' + id + '?page=1'
                ).then(function (response) {

                    this.mensagens = response.data.message;
                    this.isFetching = false;


                }.bind(this));

            },
            buttonAdicionar() {

                this.mandarMensagem = !this.mandarMensagem

            },
            toastRespostaShow(){
                this.toastResposta.show();
                $('#toastResposta').removeClass('d-none');
            },
            toastPontosShow(){
                this.toastPontos.show();
                $('#toastPontos').removeClass('d-none');
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
            this.toastResposta = new bootstrap.Toast(document.getElementById('toastResposta'), {delay: 10000})
            this.toastResposta.hide();

            this.toastPontos = new bootstrap.Toast(document.getElementById('toastPontos'), {delay: 10000})
            this.toastPontos.hide();
        }
    }
</script>

<style scoped>

</style>
