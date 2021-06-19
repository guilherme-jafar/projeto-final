<template>

    <div>


        <div v-if="!isFetchingA">
            <div v-if="filter.length === 0" class="mx-auto" id="alunos-adicionar">
                <h1 class="heanding-1 mx-auto mt-5">Ainda não tem nenhum aluno inscrito!!</h1>

            </div>
            <div v-else class="section-disciplinas-items mt-5 me-md-5 ms-md-5" id="lista-alunos">
                <div class="box-search mb-5">
                    <input class=" form-control form-control-lg form-search" type="text" v-model="search"
                           placeholder="Pesquisar aluno...">
                    <i class="bi bi-search"></i>
                </div>
                <h1>Alunos inscritos</h1>
                <ul>
                    <li class="card-box card-box-alunos mb-5 mt-4" v-for="aluno in filter" :key="aluno['id']">


                        <h2>{{aluno['nome']}}</h2>
                        <button type="button" class="btn btn-secondary ms-2 ms-auto" data-bs-toggle="modal"
                                :data-bs-target="'#a'+aluno['id']">detalhes
                        </button>


                        <div class="modal fade" :id="'a'+aluno['id']" tabindex="-1" :aria-labelledby="aluno['id']"
                             aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" :id="'al'+aluno['id']">{{aluno['nome']}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-5">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-column align-items-center text-center">
                                                                <img v-if="aluno['foto_perfil'] === null"
                                                                     src="/images/imgDefault.jpg"
                                                                     alt="Admin" class="rounded-circle" width="150">
                                                                <img v-else
                                                                     :src="'/images/' + aluno['foto_perfil']"
                                                                     alt="Admin" class="rounded-circle" width="150">
                                                                <div class="mt-3">
                                                                    <h4>{{aluno['nome']}}</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card mb-3">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <h6 class="mb-0">Nome</h6>
                                                                </div>
                                                                <div class="col-sm-9 text-secondary">
                                                                    {{aluno['nome']}}
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <h6 class="mb-0">Email</h6>
                                                                </div>
                                                                <div class="col-sm-9 text-secondary">
                                                                    {{aluno['email']}}
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <h6 class="mb-0">Pontos</h6>
                                                                </div>
                                                                <div class="col-sm-9 text-secondary">
                                                                    {{aluno['pontos']}}
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <h6 class="mb-0">Género</h6>
                                                                </div>
                                                                <div class="col-sm-9 text-secondary">
                                                                    <div v-if="aluno['sexo'] === 'm'">
                                                                        Masculino
                                                                    </div>
                                                                    <div v-else-if="aluno['sexo'] === 'f'">
                                                                        Feminino
                                                                    </div>
                                                                    <div v-else-if="aluno['sexo'] === 'o'">
                                                                        Outro
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>


                    </li>
                </ul>
            </div>
        </div>
        <div v-else class="card-loading is-loading mt-5" id="card-loading-alunos">
            <div class="content">
                <h2></h2>
                <br><br>
                <p></p>
            </div>
        </div>


        <pagination-2 :data="alunos" :align="'center'" @pagination-change-page="getResultsAlunos"></pagination-2>
    </div>
</template>

<script>
    import $ from "jquery";
    import axios from "axios";

    export default {
        name: "listaAlunos",
        data() {
            return {
                search: '',
                alunos: '',
                page: 1,
                isFetchingA: true
            }
        },
        methods: {
            getResultsAlunos(page = 1) {
                let l = window.location.href.split('/');
                axios.get('/prof/alunos/' + l[l.length - 1]+'?page=' + page)
                    .then(function (response) {
                        this.alunos = response.data.message;

                        this.isFetchingA = false;
                    }.bind(this));

            },
        },
        computed: {
            filter: function () {
                return this.alunos.data.filter((aluno) => {
                    return aluno['nome'].match(this.search)
                })
            }
        },
        mounted: function () {

            this.getResultsAlunos();


        }
    }
</script>

<style scoped>

</style>
