<template>
<div >

    <div v-if="isFetchingH">
        <div class="card-loading is-loading mt-5" id="card-loading-quiz">
            <div class="content">
                <h2></h2>
                <br><br>
                <p></p>
            </div>
        </div>
    </div>

    <div v-else class="tabela-historico">
        <table>
            <tr>
                <th>Nome</th>
                <th>Pontos</th>
                <!--        <th v-for="resposta in respostas"></th>-->

                <th style="min-width: 7rem" class="text-center" v-for="(resposta, index) in respostas['respostas'][0]">P{{index+1}}</th>
            </tr>
            <tr v-for="(aluno, index) in respostas['alunos']">
                <td style="min-width: 28rem" >{{aluno['nome']}}</td>
                <td >{{aluno['soma_resultado']}}</td>
                <td class="text-center" v-for="(resposta, index2) in respostas['respostas'][index]"   :style=" + resposta['resultado'] !== 0? 'background-color: #66c036': 'background-color: #f9403e'">

                    <span style="background-color: #66c036" v-if="resposta['resultado'] !== 0"  >
                    <i class="bi bi-check2"  @click="openModal(resposta['sessao_id'],aluno['aluno_utilizador_id'],index2) "></i>
                </span>
                    <span style="background-color: #f9403e" v-else><i class="bi bi-x" @click="openModal(resposta['sessao_id'],aluno['aluno_utilizador_id'],index2)"></i></span>


                <div class="modal fade" :id="resposta['sessao_id']" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">


                    <div class="modal-dialog" role="document">
                        <div class="modal-content" >
                            <div v-if="perguntas.length!==0">
                            <div class="modal-header"  >
                                <h5 class="modal-title" id="exampleModalLabel">{{perguntas[0]['enunciado']}}</h5>

                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div v-for="(pergunta,i) in perguntas">
                                    <div v-if="pergunta['resposta']=== pergunta['trueResposta'] && pergunta['res']===0 ">
                                        <p style="background-color: red; color:white">{{pergunta['resposta']}}</p>
                                    </div>
                                    <div v-else-if="pergunta['resposta']=== pergunta['trueResposta'] && pergunta['res']===1">
                                        <p style="background-color: green;color:white"> {{pergunta['resposta']}}</p>
                                    </div>
                                    <div v-else-if=" pergunta['res']===1">
                                        <p style="background-color: green; color:white"> {{pergunta['resposta']}}</p>
                                    </div>
                                    <div v-else>
                                        <p>{{pergunta['resposta']}}</p>

                                    </div>

                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>

                            </div>
                            </div>
                        </div>
                        </div>

                </div>


                </td>
            </tr>

        </table>
    </div>



    <button class="btn btn-primary mt-5" @click="$root.$emit('btnVoltarSessao')">Voltar</button>

</div>
</template>

<script>
    export default {
        name: "tabelaHistorico",
        props: ['idSessao_prop'],
        data(){
            return{
                idSessao: this.idSessao_prop,
                respostas: '',
                isFetchingH: true,
                perguntas:[],
                myModal:''
            }
        },
        methods: {

            getResultsHistoricos() {

                console.log(this.idSessao)

                axios.get('/prof/historico/sessao/' + this.idSessao
                ).then(function (response) {
                    this.respostas = response.data.message;

                    this.isFetchingH = false;

                    console.log(this.respostas)

                }.bind(this));
            },
            openModal(id , userId ,pId){
                pId++;
                let form= new FormData();
                console.log(id +" "+userId+" "+pId)
                form.append('id',id);
                form.append('userId',userId);
                form.append('pId',pId);
                axios.post('/prof/historico/student',form).then(function (response){
                    this.perguntas = response.data.message;
                    console.log(this.perguntas)
                    this.myModal = new bootstrap.Modal(document.getElementById(id), {})
                    this.myModal.show();
                }.bind(this))

            }
        },
        mounted: function () {

            this.$root.$on('btnVoltarSessao', this.voltar);
            this.getResultsHistoricos();
        }
    }
</script>

<style scoped>

</style>
