<template>
    <div class="section-quizz mt-5 me-md-5 ms-md-5">

        <div v-if="isActive">
            <div v-if="isFetchingH">
                <div class="card-loading is-loading mt-5" id="card-loading-quiz">
                    <div class="content">
                        <h2></h2>
                        <br><br>
                        <p></p>
                    </div>
                </div>


            </div>
            <div v-else>
                <div v-if="historicos.data.length === 0">
                    <h1 class="heanding-1 mx-auto mt-5">Nenhum aluno fez esse Quizz</h1>
                </div>
                <div v-else class="section-disciplinas-items">
                    <h1>Historico</h1>

                    <ul>
                        <li class="card-box mb-5 mt-5" v-for="(historico, index) in historicos.data" :key="historico['id']">


                            <div>
                                <div class="card-box-text">
                                    <h2>Sessão {{(historicos.from + index)}}</h2>
                                    <button @click="verTabela(historico['sessaoMaster'])" class="btn btn-secondary">Ver</button>
                                </div>
                            </div>

                        </li>
                    </ul>
                </div>
                <pagination-2 :data="historicos" :align="'center'"
                              @pagination-change-page="getResultsHistoricos"></pagination-2>
                <button class="btn btn-primary" @click="$root.$emit('btnVoltar')">Voltar</button>
            </div>

        </div>



        <tabela-historico :idSessao_prop="idSessao" :is="component"></tabela-historico>

    </div>
</template>

<script>
    import axios from "axios";
    import $ from "jquery";
    import tabelaHistorico from "./tabelaHistorico";

    export default {
        name: "historico",
        props: ['idQuizz_prop'],
        components: {
            tabelaHistorico
        },
        data() {
            return {
                historicos: '',
                idQuiz: this.idQuizz_prop,
                isFetchingH: true,
                component: '',
                isActive: true,
                idSessao: ''
            }
        },
        methods: {
            getResultsHistoricos(page = 1) {


                axios.get('/prof/historico/' + this.idQuiz + '?page=' + page
                ).then(function (response) {
                    this.historicos = response.data.message;
                    this.isFetchingH = false;

                }.bind(this));
            },
            verTabela(id){
                this.idSessao = id;

                if (this.component !== tabelaHistorico) {
                    this.component = tabelaHistorico
                    this.isActive = false;
                }
            },
            voltar(){

                this.component = '';
                this.isActive = true;
            }
        },
        mounted: function () {
            // this.$root.$on('listHistorico', this.getResultsHistoricos);
            this.getResultsHistoricos()
            this.$root.$on('btnVoltarSessao', this.voltar);
        }
    }
</script>

<style scoped>

</style>
