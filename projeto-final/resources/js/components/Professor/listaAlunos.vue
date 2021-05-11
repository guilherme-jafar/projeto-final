<template>

    <div>
        <div class="card-loading is-loading mt-5" id="card-loading-alunos">
            <div class="content">
                <h2></h2>
                <br><br>
                <p></p>
            </div>
        </div>

        <div v-if="!isFetchingA">
            <div v-if="alunos.length === 0" class="mx-auto" id="alunos-adicionar">
                <h1 class="heanding-1 mx-auto mt-5">Ainda não tem nenhum alunos inscrito</h1>

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
                                        <!--                                <p>{{aluno['nome']}}</p>-->
                                        <!--                                <p>Email: {{aluno['email']}}</p>-->
                                        <!--                                <p>Pontos: </p>-->
                                        <!--                                <div v-if="aluno['sexo'] === 'm'">-->
                                        <!--                                    <p class="">sexo-masculino</p>-->
                                        <!--                                </div>-->
                                        <!--                                <div v-else-if="aluno['sexo'] === 'f'">-->
                                        <!--                                    <p>sexo-femenino</p>-->
                                        <!--                                </div>-->
                                        <!--                                <div v-else-if="aluno['sexo'] === 'o'">-->
                                        <!--                                    <p>sexo-outro</p>-->
                                        <!--                                </div>-->
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
        }, computed: {
            filter: function () {
                return this.alunos.data.filter((aluno) => {
                    return aluno['nome'].match(this.search)
                })
            }
        },
        methods: {
            getResultsAlunos(page = 1) {

                axios.get('/prof/getAlunos?page=' + page)
                    .then(response => {
                        this.alunos = response.data.message;
                    });
            },
        },
        mounted: function () {
            let l = window.location.href.split('/');


            let formData = new FormData();
            formData.append('id', l[l.length - 1]);
            axios.post('/prof/getAlunos?page=1', formData
            ).then(function (response) {

                this.alunos = response.data.message;

                $('#card-loading-alunos').hide();
                $('#lista-alunos').show();
                $('#alunos-adicionar').show();
                this.isFetchingA = false;

            }.bind(this));

            $('#card-loading-alunos').show();
            $('#lista-alunos').hide();
            $('#alunos-adicionar').hide();

        }
    }
</script>

<style scoped>

</style>
