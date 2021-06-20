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
                <td class="text-center" v-for="(resposta, index2) in respostas['respostas'][index]" :style=" + resposta['resultado'] !== 0? 'background-color: #66c036': 'background-color: #f9403e'">
                <span style="background-color: #66c036" v-if="resposta['resultado'] !== 0">
                    <i class="bi bi-check2"></i>
                </span>
                    <span style="background-color: #f9403e" v-else><i class="bi bi-x"></i></span>
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
                isFetchingH: true
            }
        },
        methods: {
            getResultsHistoricos() {

                console.log(this.idSessao)

                axios.get('/prof/historico/sessao/' + this.idSessao
                ).then(function (response) {
                    this.respostas = response.data.message;
                    this.isFetchingH = false;
                    console.log(this.respostas['alunos'])

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
