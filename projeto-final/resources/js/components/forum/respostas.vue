<template>
    <div>
        <div  v-if="!isFetching">
            <div v-if="respostas.data.length !== 0" class="card-box-text">
                <ul class="ul-list">
                    <li class="card-box mb-5 mt-5" v-for="resposta in respostas.data" :key="resposta['id']">

                        <div class="d-flex">
                            <h2 >{{resposta['nome']}}</h2>
                            <p class="ms-auto fs-4" >{{resposta['data']}}</p>
                            <div class="dropdown">
                                <button class="" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <button type="button" class="dropdown-item"  @click="pontos(500)">500
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item"  @click="pontos(750)">750
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                :data-bs-target="'#eliminarResposta' + resposta['id']">Eliminar
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <p>{{resposta['mensagem']}}</p>
                    </li>
                </ul>

            </div>
        </div>

        <div :id="'box-responder' + idmensagem" class="nova-resposta d-none">
                                <textarea class=" form-control form-control-lg" :id="'textoResposta'+idmensagem"
                                          placeholder="Escreva a resposta..."></textarea>
            <p class="error " :id="'respostaError'+ idmensagem"></p>
            <div class="text-end mt-3">
                <button type="button" class="btn btn-primary btn-submit mt-3 ms-auto"
                        @click="buttonResponder(idmensagem)"><span>Cancelar &nbsp;</span>
                </button>
                <button type="button"
                        class="btn btn-secondary btn-submit btn-loading mt-3 ms-auto"
                        :id="'btn-submit'+idmensagem"
                        @click="sendResposta(idmensagem)"><span>Enviar &nbsp;</span>
                    <div class="spinner-border text-light d-none" role="status">

                    </div>
                </button>
            </div>
        </div>

        <div :id="'box-buttons' + idmensagem" class="d-flex">
            <div  class="dropdown-pontos ms-auto">
                <button v-if="this.tipoUtilizador === 'prof' && this.tipoUtilizadorMensage !== 'prof'" class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton2" data-bs-toggle="dropdown"
                        aria-expanded="false">
                    Pontos
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                    <li><button class="dropdown-item" @click="pontos(500)">500</button></li>
                    <li><button class="dropdown-item" @click="pontos(1000)">1000</button></li>
                </ul>
            </div>
            <button class="ms-3 btn btn-primary" @click="buttonResponder(idmensagem)">
                Responder
            </button>
        </div>
    </div>
</template>

<script>

    import axios from "axios";
    import $ from "jquery";

    export default {
        name: "respostas",
        props: ['id_props', 'tipo_props'],
        data (){
            return {
                idmensagem: this.id_props,
                respostas: '',
                idForum: this.$parent.forumId,
                isFetching: true,
                tipoUtilizador: this.$parent.tipoUtilizador,
                tipoUtilizadorMensage: this.tipo_props
            }
        },
        methods:{
            pontos(pontos){

                let formData = new FormData();
                formData.append('pontos', pontos);
                axios.post('/mensagens/pontos/'+ this.idmensagem, formData
                ).then(function (response) {


                    if (response.data.message !== "erro") {

                        this.$parent.toastPontosShow();


                    }
                }.bind(this));

            },
            listRespostas(id) {
                axios.get('/respostasMensagem/'+ this.idForum+'/' + id+ '?page=1'
                ).then(function (response) {

                    this.respostas = response.data.message;
                    this.isFetching = false;


                }.bind(this));

            },
            sendResposta(id) {
                $('#btn-submit' + id + ' span').addClass('d-none');
                $('#btn-submit' + id + ' div').removeClass('d-none');
                let enviar = true;

                $("#respostaError" + id).text("").css('color', 'red').css('opacity', '1');
                if ($('#textoResposta' + id).val().length === 0) {
                    $("#respostaError" + id).text("Introduza a resposta!!").css('color', 'red').css('opacity', '1');
                    $('#btn-submit' + id + ' span').removeClass('d-none');
                    $('#btn-submit' + id + ' div').addClass('d-none');
                    enviar = false;
                } else {
                    $("#respostaError").text("").css('color', 'red').css('opacity', '1');
                }


                if (enviar) {

                    let formData = new FormData();
                    formData.append('textoResposta', $("#textoResposta" +  id).val());
                    formData.append('idForum', this.idForum);
                    formData.append('idMensagem', id);
                    axios.post('/respostasMensagem/create', formData
                    ).then(function (response) {


                        if (response.data.message !== "erro") {
                            $('#btn-submit' + id + ' span').removeClass('d-none');
                            $('#btn-submit' + id + ' div').addClass('d-none');
                            this.respostas = response.data.message
                            console.log(this.respostas)
                            this.$parent.toastRespostaShow();
                            this.buttonResponder(id)
                            $('#textoResposta' + id).val('')


                        } else {

                            $('#btn-submit' + id + ' span').removeClass('d-none');
                            $('#btn-submit' + id + ' div').addClass('d-none');

                        }
                    }.bind(this));
                }
            },
            buttonResponder(id) {
                let element = document.getElementById('box-responder' + id)
                if (element.classList.contains('d-none')) {
                    $('#box-responder' + id).removeClass('d-none')
                    $('#box-buttons' + id).addClass('d-none')
                } else {
                    $('#box-buttons' + id).removeClass('d-none')
                    $('#box-responder' + id).addClass('d-none')
                }

            }
        },
        // filter() {
        //     return this.respostas.data.filter((respostas) => {
        //         return respostas['mensagem'].match(this.search);
        //     })
        // },
        mounted() {
            this.listRespostas(this.idmensagem)
        }
    }
</script>

<style scoped>

</style>
