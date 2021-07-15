<template>


    <div class="modal fade modal-info__docente" :id="'professor'" tabindex="-1" :aria-labelledby="professor['id']"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" :id="'al'+professor['id']">{{professor['nome']}}</h5>
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
                                            <img v-if="professor['foto_perfil'] === null"
                                                 src="/images/imgDefault.jpg"
                                                 alt="Admin" class="rounded-circle" width="150" height="150">
                                            <img v-else
                                                 :src="'/images/' + professor['foto_perfil']"
                                                 alt="Admin" class="rounded-circle" width="90" height="90">
                                            <div class="mt-3">
                                                <h4>{{professor['nome']}}</h4>
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
                                                {{professor['nome']}}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                {{professor['email']}}
                                            </div>
                                        </div>
                                        <hr>


                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Género</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <div v-if="professor['sexo'] === 'm'">
                                                    Masculino
                                                </div>
                                                <div v-else-if="professor['sexo'] === 'f'">
                                                    Feminino
                                                </div>
                                                <div v-else-if="professor['sexo'] === 'o'">
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


</template>

<script>
    import $ from "jquery";
    import historico from "./historico";
    import axios from "axios";

    export default {
        name: "infoDocente",
        props: ['quizz_prop'],
        components: {
            historico,
        },
        data() {
            return {
                professor: ''
            }
        },
        computed: {
            filter() {
                return this.quizz.data.filter((quizz) => {
                    return quizz['nome'].match(this.search);
                })
            }
        },
        methods: {

            getQuizz() {

                axios.get('/aluno/infodocente').then(
                    function (response) {
                        this.professor = response.data.message[0];

                    }.bind(this));
            },


        },
        mounted() {
            this.getQuizz();
        },
    }
</script>

<style scoped>

</style>
