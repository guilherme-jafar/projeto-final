<template>
    <div class="editar-pergunta">

        <div class="modal-body p-md-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-pergunta"
                               placeholder="Escreva a pergunta aqui" :id="'pergunta'+pergunta['id']"
                               :value="pergunta['enunciado']"><br>
                        <p :id="'PerguntaError'+pergunta['id']"></p>
                    </div>
                    <div class="col-md-12 mt-5">
                        <input type="file" :id="'file' + pergunta['id']" class="Pergunta_file mx-auto">
                        <label :file="'file' + pergunta['id']" class="pergunta_input"></label>
                        <p :id="'fileError'+pergunta['id']"></p>
                    </div>
                    <div class="col-md-4 text-center">
                        <label :for="'tipo'+pergunta['id']">
                            Indique o tipo de pergunta<br>
                            <select name="tipo" class="form-select" :id="'tipo'+pergunta['id']"
                                    @change="alter()">
                                <option value="multiple" v-bind:selected="pergunta['tipo'] === 'multiple'">Seleção
                                    Única
                                </option>
                                <option value="multiple-select"
                                        v-bind:selected="pergunta['tipo'] === 'multiple-select'">Seleção Múltipla
                                </option>
                                <option value="true/false" v-bind:selected="pergunta['tipo'] === 'true/false'">
                                    Verdadeiro/Falso
                                </option>


                            </select>
                        </label>
                    </div>

                    <div class="col-md-4 text-center">
                        <label :for="'tempo'+pergunta['id']">
                            Indique o tempo de pergunta<br>
                            <select name="tipo" class="form-select" :id="'tempo'+pergunta['id']">
                                <option value="5" v-bind:selected="pergunta['tempo'] === 5">5</option>
                                <option value="10" v-bind:selected="pergunta['tempo'] === 10">10</option>
                                <option value="20" v-bind:selected="pergunta['tempo'] === 20">20</option>
                                <option value="30" v-bind:selected="pergunta['tempo'] === 30">30</option>
                                <option value="60" v-bind:selected="pergunta['tempo'] === 60">1 minuto</option>
                                <option value="90" v-bind:selected="pergunta['tempo'] === 90">1 minuto e 30 segundos
                                </option>
                                <option value="120" v-bind:selected="pergunta['tempo'] ===120">2 minutos</option>
                                <option value="240" v-bind:selected="pergunta['tempo'] ===240">4 minutos</option>

                            </select>
                        </label>
                    </div>

                    <div class="col-md-4 text-center">
                        <label :for="'pontos'+pergunta['id']">
                            Indique a pontuação<br>
                            <select name="pontos" class="form-select" :id="'pontos'+pergunta['id']">
                                <option value="Normal" v-bind:selected="pergunta['valor'] ===  1000 ">Normal</option>
                                <option value="Pontos duplos" v-bind:selected="pergunta['valor'] ===  2000 ">Pontos
                                    duplos
                                </option>
                                <option value="Sem pontos" v-bind:selected="pergunta['valor'] ===  0 ">Sem pontos
                                </option>
                            </select>
                        </label>
                    </div>

                    <div v-if="isFetching">
                        <div v-if="pergunta['tipo'] !== 'true/false'">
                            <div class="card-loading is-loading mt-5" >
                                <div class="content">

                                    <p></p>
                                </div>
                            </div>
                            <div class="card-loading is-loading mt-5" >
                                <div class="content">

                                    <p></p>
                                </div>
                            </div>
                            <div class="card-loading is-loading mt-5" >
                                <div class="content">

                                    <p></p>
                                </div>
                            </div>
                            <div class="card-loading is-loading mt-5" >
                                <div class="content">

                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="card-loading is-loading mt-5" >
                                <div class="content">

                                    <p></p>
                                </div>
                            </div>
                            <div class="card-loading is-loading mt-5" >
                                <div class="content">

                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 ">
                        <div :id="'multiple'+pergunta['id']" style="margin-top: 20px">
                            <div v-if="!isFetching">
                                <div class="input-group mb-3 insertAnsewr">

                                    <input type='text' :id="'re1'+pergunta['id']" class=" form-control"
                                           style="border: none;"
                                           aria-label="Text input with radio button" placeholder="Opção 1"
                                           :value="(pergunta['tipo'] === 'multiple'? respostas[0]['resposta'] : '')">
                                    <div class="input-group-text">
                                        <input type="radio" :name="'corret'+pergunta['id']" :value="'re1'"
                                               v-bind:checked="respostas[0]['resultado']===1"
                                               class="form-check-input">
                                    </div>
                                </div>




                                <div v-if="pergunta['tipo'] !== 'true/false'" >
                                    <div class="input-group mb-3 insertAnsewr">

                                        <input type='text' :id="'re2'+pergunta['id']" class=" form-control"
                                               style="border: none"
                                               aria-label="Text input with radio button" placeholder="Opção 2"
                                               :value="(pergunta['tipo'] === 'multiple'? respostas[1]['resposta'] : '')">
                                        <div class="input-group-text">
                                            <input type="radio" :name="'corret'+pergunta['id']"
                                                   :value="'re2'+pergunta['id']"
                                                   v-bind:checked="respostas[1]['resultado']===1"
                                                   class="form-check-input">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3 insertAnsewr">

                                        <input type='text' :id="'re3'+pergunta['id']" class=" form-control"
                                               style="border: none; "
                                               aria-label="Text input with radio button" placeholder="Opção 3"
                                               :value="(pergunta['tipo'] === 'multiple'? respostas[2]['resposta'] : '')">
                                        <div class="input-group-text">
                                            <input type="radio" :name="'corret'+pergunta['id']"
                                                   :value="'re3'+pergunta['id']"
                                                   v-bind:checked="respostas[2]['resultado']===1"
                                                   class="form-check-input">
                                        </div>
                                    </div>


                                    <div class="input-group mb-3 insertAnsewr">

                                        <input type='text' :id="'re4'+pergunta['id']" class=" form-control"
                                               style="border: none; "
                                               aria-label="Text input with radio button" placeholder="Opção 4"
                                               :value="(pergunta['tipo'] === 'multiple'? respostas[3]['resposta'] : '')">
                                        <div class="input-group-text">
                                            <input type="radio" :name="'corret'+pergunta['id']"
                                                   :value="'re4'+pergunta['id']"
                                                   v-bind:checked="respostas[3]['resultado']===1"
                                                   class="form-check-input">
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="input-group mb-3 insertAnsewr">
                                        <div class="input-group mb-3 insertAnsewr">

                                            <input type='text' :id="'re2'+pergunta['id']" class=" form-control"
                                                   style="border: none"
                                                   aria-label="Text input with radio button" placeholder="Opção 2">
                                            <div class="input-group-text">
                                                <input type="radio" :name="'corret'+pergunta['id']"
                                                       :value="'re2'+pergunta['id']"
                                                       class="form-check-input">
                                            </div>
                                        </div>

                                        <input type='text' :id="'re3'+pergunta['id']" class=" form-control"
                                               style="border: none; "
                                               aria-label="Text input with radio button" placeholder="Opção 3">
                                        <div class="input-group-text">
                                            <input type="radio" :name="'corret'+pergunta['id']"
                                                   :value="'re3'+pergunta['id']"

                                                   class="form-check-input">
                                        </div>
                                    </div>


                                    <div class="input-group mb-3 insertAnsewr">

                                        <input type='text' :id="'re4'+pergunta['id']" class=" form-control"
                                               style="border: none; "
                                               aria-label="Text input with radio button" placeholder="Opção 4"
                                        <div class="input-group-text">
                                            <input type="radio" :name="'corret'+pergunta['id']"
                                                   :value="'re4'+pergunta['id']"

                                                   class="form-check-input">
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div :id="'trueFalse'+pergunta['id']">

                            <div v-if="!isFetching">
                                <div class="mb-5 mt-5">
                                    <label class="label-tf">Verdadeira
                                        <input type="radio" :name="'TF'+pergunta['id']" value="true"
                                               v-bind:checked="respostas[0]['resposta']=== 'true'">
                                        <span></span>
                                    </label>
                                </div>
                                <div>
                                    <label class="label-tf">Falsa
                                        <input type="radio" :name="'TF'+pergunta['id']" value="false"
                                               v-bind:checked="respostas[0]['resposta']=== 'false'">
                                        <span></span>
                                    </label>

                                </div>
                            </div>


                            <p :id="'TError'+pergunta['id']"></p>
                        </div>
                    </div>

                    <div class="col-md-12 ">
                        <div :id="'multiple-select'+pergunta['id']" style="margin-top: 20px">
                            <div v-if="!isFetching">

                                <div class="input-group mb-3 insertAnsewr">

                                    <input type='text' :id="'rem1'+pergunta['id']" class=" form-control"
                                           style="border: none;"
                                           aria-label="Text input with radio button" placeholder="Opção 1"
                                           :value="(pergunta['tipo'] === 'multiple-select'? respostas[0]['resposta'] : '')">
                                    <div class="input-group-text">
                                        <input type="checkbox" :name="'corret'+pergunta['id']+'[]'"
                                               v-bind:checked="respostas[0]['resultado']===1"
                                               :value="'re1'+pergunta['id']"
                                               class="form-check-input">
                                    </div>
                                </div>





                                <div v-if="pergunta['tipo'] !== 'true/false'" >
                                    <div class="input-group mb-3 insertAnsewr">

                                        <input type='text' :id="'rem2'+pergunta['id']" class=" form-control"
                                               style="border: none"
                                               aria-label="Text input with radio button" placeholder="Opção 2"
                                               :value="(pergunta['tipo'] === 'multiple-select'? respostas[1]['resposta'] : '')">
                                        <div class="input-group-text">
                                            <input type="checkbox" :name="'corret'+pergunta['id']+'[]'"
                                                   v-bind:checked="respostas[1]['resultado']===1"
                                                   :value="'re2'+pergunta['id']"
                                                   class="form-check-input">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3 insertAnsewr">

                                        <input type='text' :id="'rem3'+pergunta['id']" class=" form-control"
                                               style="border: none; "
                                               aria-label="Text input with radio button" placeholder="Opção 3"
                                               :value="(pergunta['tipo'] === 'multiple-select'? respostas[2]['resposta'] : '')">
                                        <div class="input-group-text">
                                            <input type="checkbox" :name="'corret'+pergunta['id']+'[]'"
                                                   :value="'re3'+pergunta['id']"
                                                   v-bind:checked="respostas[1]['resultado']===1"
                                                   class="form-check-input">
                                        </div>
                                    </div>


                                    <div class="input-group mb-3 insertAnsewr">

                                        <input type='text' :id="'rem4'+pergunta['id']" class=" form-control"
                                               style="border: none; "
                                               aria-label="Text input with radio button" placeholder="Opção 4"
                                               :value="(pergunta['tipo'] === 'multiple-select'? respostas[3]['resposta'] : '')">
                                        <div class="input-group-text">
                                            <input type="checkbox" :name="'corret'+pergunta['id']+'[]'"
                                                   :value="'re4'+pergunta['id']"
                                                   v-bind:checked="respostas[1]['resultado']===1"
                                                   class="form-check-input">
                                        </div>
                                    </div>
                                </div>
                                <div v-else>

                                    <div class="input-group mb-3 insertAnsewr">

                                        <input type='text' :id="'rem2'+pergunta['id']" class=" form-control"
                                               style="border: none"
                                               aria-label="Text input with radio button" placeholder="Opção 2">
                                        <div class="input-group-text">
                                            <input type="checkbox" :name="'corret'+pergunta['id']+'[]'"
                                                   :value="'re2'+pergunta['id']"
                                                   class="form-check-input">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3 insertAnsewr">

                                        <input type='text' :id="'rem3'+pergunta['id']" class=" form-control"
                                               style="border: none; "
                                               aria-label="Text input with radio button" placeholder="Opção 3">
                                        <div class="input-group-text">
                                            <input type="checkbox" :name="'corret'+pergunta['id']+'[]'"
                                                   :value="'re3'+pergunta['id']"

                                                   class="form-check-input">
                                        </div>
                                    </div>


                                    <div class="input-group mb-3 insertAnsewr">

                                        <input type='text' :id="'rem4'+pergunta['id']" class=" form-control"
                                               style="border: none; "
                                               aria-label="Text input with radio button" placeholder="Opção 4">
                                        <div class="input-group-text">
                                            <input type="checkbox" :name="'corret'+pergunta['id']+'[]'"
                                                   :value="'re4'+pergunta['id']"
                                                   class="form-check-input">
                                        </div>
                                    </div>
                                </div>


                            </div>


                        </div>
                    </div>

                    <div class="col-md-12">
                        <p :id="'RError'+pergunta['id']"></p>
                    </div>

                </div>
            </div>

            <div class="text-end mt-5">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar
                </button>
                <button type="button" :id="'submit'+pergunta['id']" class="btn btn-primary"
                        @click="submit(pergunta)">inserir
                </button>
            </div>



        </div>
    </div>
</template>


<script>

    import $ from 'jquery';
    import axios from "axios";


    export default {
        name: "editarPergunta",
        props: ['pergunta_prop'],
        data() {
            return {
                pergunta: JSON.parse(this.pergunta_prop),
                respostas: [],
                isFetching: true,
            }
        },
        methods: {
            getRespostas(id) {
                axios.get('/prof/getRespostas/' + id)
                    .then(response => {
                        this.respostas = response.data.message;
                        this.isFetching = false;
                    });
            },
            alter() {
                let id = "trueFalse" + this.pergunta['id'];
                let id2 = "multiple" + this.pergunta['id'];
                let id3 = "multiple-select" + this.pergunta['id'];
                if (document.getElementById("tipo" + this.pergunta['id']).value === "multiple") {

                    $('#' + id).hide();
                    $('#' + id2).show();
                    $('#' + id3).hide();
                } else if (document.getElementById("tipo" + this.pergunta['id']).value === "true/false") {

                    $('#' + id).show();
                    $('#' + id2).hide();
                    $('#' + id3).hide();
                } else if (document.getElementById("tipo" + this.pergunta['id']).value === "multiple-select") {
                    $('#' + id).hide();
                    $('#' + id2).hide();
                    $('#' + id3).show();
                }
            }
        },
        mounted() {
            this.getRespostas(this.pergunta['id']);
            let pergunta = this.pergunta
            let id = "trueFalse" + pergunta['id'];
            let id2 = "multiple" + pergunta['id'];
            let id3 = "multiple-select" + pergunta['id'];
            if (pergunta['tipo'] === 'multiple-select') {

                $('#' + id).hide();
                $('#' + id2).hide();
                $('#' + id3).show();
            } else if (pergunta['tipo'] === 'multiple') {
                $('#' + id).hide();
                $('#' + id2).show();
                $('#' + id3).hide();
            } else if (pergunta['tipo'] === 'true/false') {
                $('#' + id).show();
                $('#' + id2).hide();
                $('#' + id3).hide();
            }
        }

    }
</script>
