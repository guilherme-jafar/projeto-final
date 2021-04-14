<template>

<div>
    <div v-if="alunos.length === 0" class="mx-auto">
        <h1 class="heanding-1 mx-auto mt-5">Ainda não tem nenhum alunos inscrito</h1>

    </div>
    <div v-else class="section-disciplinas " >
        <div class="box-search mb-5">
            <input class=" form-control form-control-lg form-search" type="text" v-model="search" placeholder="Pesquisar aluno...">
            <i class="bi bi-search"></i>
        </div>
        <h2>Alunos inscritos</h2>
        <ul >
            <li class="card-box mb-5" v-for="aluno in filter" :key="aluno['id']">


                <h2>{{aluno['nome']}}</h2><button type="button" class="btn btn-secondary ms-2" data-bs-toggle="modal" :data-bs-target="'#a'+aluno['id']"  >detalhes</button>


                <div class="modal fade" :id="'a'+aluno['id']" tabindex="-1" :aria-labelledby="aluno['id']" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" :id="'al'+aluno['id']">{{aluno['nome']}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h2>{{aluno['nome']}}</h2><br>
                                <h2>email-{{aluno['email']}}</h2><br>
                                <div v-if="aluno['sexo'] === 'm'">
                                    <h2>sexo-masculino</h2><br>
                                </div>
                                <div v-else-if="aluno['sexo'] === 'f'">
                                    <h2>sexo-femenino</h2><br>
                                </div>
                                <div v-else-if="aluno['sexo'] === 'o'">
                                    <h2>sexo-outro</h2><br>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>


            </li>
        </ul>
    </div>
    </div>
</template>

<script>
import $ from "jquery";

export default {
    name: "listaAlunos",
    data(){
        return {
            search:'',
            alunos:''
        }
    },  computed:{
        filter:function (){
            return this.alunos.filter((aluno)=>{
                return aluno['nome'].match(this.search)
            })
        }
    },
    mounted:function () {
        let l=window.location.href.split('/');


        let formData = new FormData();
        formData.append( 'id',l[l.length-1]);
        axios.post('/prof/getAlunos',formData
        ).then(function (response) {

            this.alunos=response.data.message;


        }.bind(this));

    }
}
</script>

<style scoped>

</style>
