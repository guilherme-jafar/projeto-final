<template>
    <div>
        <div v-if="!isFetchingH">
            {{resposta}}
            <h2>Pontos: {{respostas['aluno'][0]['soma_resultado']}}</h2>

            <div class="accordion" :id="'accordion'">
                <div v-for="(resposta, index) in respostas['respostas'] " class="accordion-item">
                    <h2 class="accordion-header" :id="'headingOne' + index">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                :data-bs-target="'#collapseOne' + index" aria-expanded="true"
                                :aria-controls="'collapseOne' +index ">
                            {{resposta['perguntas'][0]['enunciado']}}
                        </button>
                    </h2>
                    <div :id="'collapseOne'+ index" class="accordion-collapse collapse show"
                         :aria-labelledby="'headingOne' + index" data-bs-parent="#accordion">
                        <div class="accordion-body">

                            <div v-for="respostaPergunta in resposta['perguntas']">


                                <div v-if="resposta['tipo'] === 'true/false'">

                                    <div v-if="resposta['resultado'] !== 0">
                                        <div :style="resposta['resposta'] === 'true'? 'background-color: #66c036': 'background-color: white'">
                                            <p :style="resposta['resposta'] === 'true'? 'color: white': ''">Verdadeira</p>
                                        </div>
                                        <div :style="resposta['resposta'] === 'false'? 'background-color: #66c036': 'background-color: white'">
                                            <p :style="resposta['resposta'] === 'false'? 'color: white': ''" style="color: white">Falsa</p>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div :style="resposta['resposta'] === 'true'? 'background-color: #66c036': 'background-color: #f9403e'">
                                            <p :style="resposta['resposta'] === 'true'? 'color: white': ''">Verdadeira</p>
                                        </div>
                                        <div :style="resposta['resposta'] === 'false'? 'background-color: #66c036': 'background-color: #f9403e'">
                                            <p :style="resposta['resposta'] === 'false'? 'color: white': ''" style="color: white">Falsa</p>
                                        </div>
                                    </div>


                                </div>
                                <div v-else>
                                    <div style="background-color: #66c036" v-if="1 === respostaPergunta['resultado']">
                                        <div v-if="resposta['tipo'] === 'multiple-image'">
                                            <img :src="'/images/Pergunta/Multimedia/'+respostaPergunta['resposta']"
                                                 alt="imagem da resposta"
                                                 height="40%"
                                                 width="40%" class="mx-auto">
                                        </div>
                                        <p v-else style="color: white"> {{respostaPergunta['resposta']}}</p>
                                    </div>
                                    <div style="background-color: #f9403e"
                                         v-else-if="resposta['resultado'] === 0 && respostaPergunta['resposta'] === resposta['resposta']">
                                        <div v-if="resposta['tipo'] === 'multiple-image'">
                                            <img :src="'/images/Pergunta/Multimedia/'+respostaPergunta['resposta']"
                                                 alt="imagem da resposta"
                                                 height="40%"
                                                 width="40%" class="mx-auto">
                                        </div>
                                        <p v-else style="color: white"> {{respostaPergunta['resposta']}}</p>
                                    </div>
                                    <div v-else>
                                        <div v-if="resposta['tipo'] === 'multiple-image'">
                                            <img :src="'/images/Pergunta/Multimedia/'+respostaPergunta['resposta']"
                                                 alt="imagem da resposta"
                                                 height="40%"
                                                 width="40%" class="mx-auto">
                                        </div>
                                        <p v-else> {{respostaPergunta['resposta']}}</p>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="card-loading is-loading mt-5" id="card-loading-quiz">
                <div class="content">
                    <h2></h2>
                    <br><br>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "tabelaHistorico",
        props: ['idSessao_prop'],
        data() {
            return {
                idSessao: this.idSessao_prop,
                respostas: '',
                isFetchingH: true
            }
        },
        methods: {
            getResultsHistoricos() {

                console.log(this.idSessao)

                axios.get('/aluno/historico/sessao/' + this.idSessao
                ).then(function (response) {
                    this.respostas = response.data.message;
                    this.isFetchingH = false;
                    console.log(this.respostas['respostas'])

                }.bind(this));
            },
        },
        mounted: function () {

            this.$root.$on('btnVoltarSessao', this.voltar);
            this.getResultsHistoricos();
        }
    }
</script>

<style scoped>

</style>
