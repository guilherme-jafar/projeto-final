<template>
    <div class="editar-pergunta">

        <div class="p-md-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-pergunta"
                               placeholder="Escreva a pergunta aqui" :id="'pergunta'+pergunta['id']"
                               :value="pergunta['enunciado']"><br>
                        <p :id="'PerguntaError'+pergunta['id']"></p>
                    </div>
                    <div class="col-md-12 text-center">
                        <input  style="visibility: hidden" type="file" :id="'file' + pergunta['id']" class="file-input mx-auto" @change="alterarFoto">
                        <label :file="'file' + pergunta['id']" class="pergunta_input"></label>
<!--                        <iframe width="560" height="315" src="https://youtu.be/I5UoAx1V9HA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" ></iframe>-->
                        <div v-if="!isFetching">
                            <div v-if="respostas['multimedia'][0]['link'] !== null" id="imagem-div">
                                <div v-if="fileCheck()===1" class="text-center">

                                    <img :src="'/images/Pergunta/Multimedia/'+ respostas['multimedia'][0]['link']" alt="imagem da pergunta" height="40%"
                                         width="40%" class="mx-auto mb-4" id="imagem">
                                </div>
                                <div v-else-if="fileCheck()===2"  class="text-center">

<!--                                    <iframe width="560" height="315" src="https://www.youtube.com/watch?v=I5UoAx1V9HA&t=69s" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" ></iframe>-->
                                </div>
                                <div v-else-if="fileCheck()===3"  class="text-center">

                                    <audio controls>
                                        <source id="questionMultiAudio" :src="'/images/Pergunta/Multimedia/'+respostas['multimedia'][0]['link']"
                                                type="">
                                    </audio>
                                </div>
                                <div v-else-if="fileCheck()===0" style="min-height: 30rem">

                                </div>

                            </div>
                        </div>

                        <div class="btn-file mx-auto mb-5 d-flex" id="dropdownFile">
                            <input class="form-control form-control-2" type="url" :id="'inputLink'"  placeholder="Introduza o link do vídeo Youtube">
                            <div class="dropdown mx-auto text-center" >
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Adicionar ficheiro
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><label class="dropdown-item" @click="fileType(1)" :for="'file' + pergunta['id']">Imagem</label></li>
                                    <li><label class="dropdown-item" @click="fileType(2)" :for="'file' + pergunta['id']">Audio</label></li>
                                    <li><button class="dropdown-item" @click="fileType(2)">Youtube Link</button></li>
                                </ul>
                            </div>
                        </div>

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

            <!-- Modal -->
<!--            <div class="modal fade" :id="'linkYoutube' + pergunta['id']" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--                <div class="modal-dialog">-->
<!--                    <div class="modal-content">-->
<!--                        <div class="modal-header">-->
<!--                            <h5 class="modal-title" id="exampleModalLabel">Link Youtube</h5>-->
<!--                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--                        </div>-->
<!--                        <div class="modal-body pt-5 pb-5">-->
<!--                            <form class="row mx-auto" id="">-->
<!--                                <div class="col-11">-->
<!--                                    <label class="label" for="disciplina" >Url do Vídeo</label>-->
<!--                                    <input name="disciplina" class="form-control mt-2 mb-2 " type="text" id="linkYoutube">-->

<!--                                </div>-->
<!--                                <div class="col-12 mb-4">-->
<!--                                    <p class="error " id="disciplinaError"></p>-->
<!--                                </div>-->


<!--                            </form>-->
<!--                        </div>-->
<!--                        <div class="modal-footer">-->
<!--                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>-->
<!--                            <button type="button" id="submit" class="btn btn-secondary btn-submit" @click="submit()">  <span class="">Adicionar &nbsp;</span>-->
<!--                                <div class="spinner-border text-light d-none" role="status">-->

<!--                                </div>-->
<!--                            </button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

            <div class="text-end mt-5">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sair
                </button>
                <button type="button" :id="'submit'" class="btn btn-primary ms-3 btn-loading"
                        @click="submit(pergunta['id'])">
                    <span class="">Guardar</span>
                    <div class="spinner-border text-light d-none" role="status">

                    </div>
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
                tipoFicheiro: 0
            }
        },
        methods: {
            alterarFoto(e){

                if (this.tipoFicheiro = 1){
                    let imagem = document.getElementById("imagem");
                    imagem.src = URL.createObjectURL(e.target.files[0]);
                    this.imagem = e.target.files[0];
                }


            },
            fileCheck() {
                if (this.respostas['multimedia'][0]['link'] === null) {
                    return 0;
                } else {
                    let ext = this.getExtension(this.respostas['multimedia'][0]['link'])

                    switch (ext.toLowerCase()) {
                        case 'jpeg':
                        case 'gif':
                        case 'bmp':
                        case 'png':
                        case 'jpg':
                            //etc
                            return 1;
                    }
                    switch (ext.toLowerCase()) {
                        case 'm4v':
                        case 'avi':
                        case 'mpg':
                        case 'mp4':
                            // etc
                            $('#questionMulti').attr("type", 'video/' + ext);
                            return 2;
                    }
                    switch (ext.toLowerCase()) {
                        case 'ogg':
                        case 'mpeg':
                        case 'mp3':
                            // etc
                            $('#questionMultiAudio').attr("src", 'audio/' + ext);
                            return 3;
                    }
                }
                return 0;
            },
            getExtension(filename) {
                var parts = filename.split('.');
                return parts[parts.length - 1];
            },
            submit(perguntaId){
                $('#RError' + perguntaId).text(" ").css('color', 'red').css('opacity', '1');
                $('#TError' + perguntaId).text(" ").css('color', 'red').css('opacity', '1');
                $('#PerguntaError' + perguntaId).text(" ").css('color', 'red').css('opacity', '1');
                $('#fileError' + perguntaId).text(" ").css('color', 'red').css('opacity', '1');

                $('#submit span').addClass('d-none');
                $('#submit div').removeClass('d-none');
                var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/PNG", "audio/mpeg", "audio/ogg", "audio/mp3"];
                let form = new FormData();
                let file;
                let type, flag = false, flag2 = false, corret;
                let array = [];
                let index = 0;

                if (document.getElementById("pergunta" + perguntaId).value.length <= 0){
                    $('#PerguntaError' + perguntaId).text("indique o enunciado da pergunta").css('color', 'red').css('opacity', '1');
                }else if(document.getElementById("pergunta" + perguntaId).value.length > 120){
                    $('#PerguntaError' + perguntaId).text("O enunciado é demasiado grande. Deve ter 120 caracteres no máximo!!").css('color', 'red').css('opacity', '1');
                }else {
                    form.append('pergunta', document.getElementById("pergunta" + perguntaId).value);
                    form.append('tempo', document.getElementById("tempo" + perguntaId).value);
                    form.append('tipo', document.getElementById("tipo" + perguntaId).value);
                    form.append('pontos', document.getElementById("pontos" + perguntaId).value);

                    if (this.tipoFicheiro === 1){
                        file = document.getElementById("file" + top).files[0]
                        if (file != null) {
                            type = file['type'];
                            if ($.inArray(type, validImageTypes) < 0) {

                                $('#fileError' + perguntaId).text("Ficheiro invalido").css('color', 'red').css('opacity', '1');
                            }
                            form.append('file', file);
                        } else {
                            form.append('file', this.respostas['multimedia'][0]['link']);
                        }
                    }else if (this.tipoFicheiro ===2){
                        form.append('file', document.getElementById("inputLink" ).value)
                    }else {
                        form.append('file', this.respostas['multimedia'][0]['link'])
                    }

                    if (document.getElementById("tipo" + perguntaId).value === "multiple") {
                        var radios = document.getElementsByName("corret" + perguntaId);


                        for (let i = 1; i < 5; i++) {
                            if (document.getElementById("re" + i + perguntaId).value.length > 0 && document.getElementById("re" + i + perguntaId).value.length <= 100) {
                                array.push(document.getElementById("re" + i + perguntaId).value)
                                index++;
                            }

                            if (document.getElementById("re" + i + perguntaId).value.length >= 100) {
                                flag2 = true;
                                break;

                            }
                            if (radios[i - 1].checked) {
                                flag = true;
                                corret = radios[i - 1].value;
                            }
                        }
                        if (flag2) {
                            $('#RError' + perguntaId).text("Uma das respostas tem mais de 100 letras").css('color', 'red').css('opacity', '1');

                        } else if (index < 2) {
                            $('#RError' + perguntaId).text("Uma pergunta tem de ter pelo menos 2 respostas").css('color', 'red').css('opacity', '1');
                        } else if (!flag) {
                            $('#RError' + perguntaId).text("Indique a resposta certa").css('color', 'red').css('opacity', '1');
                        } else {
                            form.append('array', JSON.stringify(array));
                            form.append('resposta', document.getElementById(corret).value)
                            this.send(form, perguntaId)
                        }

                    } else if (document.getElementById("tipo" + perguntaId).value === "true/false") {
                        var radios = document.getElementsByName("TF" + perguntaId);
                        for (let i = 0; i < 2; i++) {
                            if (radios[i].checked) {
                                flag = true;
                                corret = radios[i].value;
                            }
                        }
                        if (!flag) {
                            $('#TError' + perguntaId).text("Indique a resposta certa").css('color', 'red').css('opacity', '1');
                        } else {

                            form.append('resposta', corret)
                            this.send(form, perguntaId)
                        }                    } else if (document.getElementById("tipo" + top).value === "multiple-select") {

                        let opcoes = $('input[name="corret' + top + '[]"]:checked');
                        let opcoesEscolhidas = [];
                        let respostas = [];
                        let guardarOpcoes = true;
                        if (opcoes.length <= 1) {
                            $('#RError' + top).text("Escolha duas ou mais opções corretas!!").css('color', 'red').css('opacity', '1');

                        } else {
                            for (let i = 0; i < opcoes.length; i++) {
                                opcoesEscolhidas[i] = opcoes[i].value;
                                if (document.getElementById("rem" + (i + 1) + perguntaId).value.length === 0) {
                                    $('#RError' + perguntaId).text("Não pode escolher uma opção vazia como certa!!").css('color', 'red').css('opacity', '1');
                                    guardarOpcoes = false;
                                    break;
                                } else if (document.getElementById("rem" + (i + 1) + perguntaId).value.length > 100) {
                                    $('#RError' + perguntaId).text("Uma das respostas tem mais de 100 letras").css('color', 'red').css('opacity', '1');
                                    guardarOpcoes = false;
                                    break;
                                }

                            }

                            if (guardarOpcoes) {
                                for (let i = 1; i < 5; i++) {
                                    if (document.getElementById("rem" + i + perguntaId).value.length > 0 && document.getElementById("rem" + i + perguntaId).value.length <= 100) {
                                        respostas[i - 1] = document.getElementById("rem" + i + perguntaId).value;

                                    }

                                }

                                if (respostas.length >= 2) {
                                    form.append('array', JSON.stringify(respostas));
                                    form.append('respostas', JSON.stringify(opcoesEscolhidas))

                                    this.send(form, perguntaId)
                                } else {
                                    $('#RError' + perguntaId).text("Só pode introduzir duas ou mais opcões!!").css('color', 'red').css('opacity', '1');
                                }


                            }


                        }


                    }



                }



            },
            send(form, perguntaID){
              console.log(form.values())
                for(var pair of form.entries()) {
                    console.log(pair[0]+ ', '+ pair[1]);
                }
                axios.post('/prof/pergunta/' + perguntaID + '/editar', form
                ).then(function (response) {
                    if (response.data.message === "erro") {

                        alert("Erro a inserir a pergunta");
                    } else {
                        $('#submit' + top).prop('disabled', false);
                        this.modal.hide();
                        // this.toastPergunta.show();
                        this.$root.$emit('ShowToastPergunta', 3);
                        $('#toast-pergunta').removeClass('d-none');
                    }
                    document.getElementById("pergunta" + top).value = ""
                    document.getElementById("file" + top).value = ""

                }.bind(this));

            },
            fileType(tipo){

                if (tipo===2){
                    $('#inputLink').show();
                    $('#dropdownFile').addClass('btn-file-hide')
                    this.tipoFicheiro = 2;
                    $('#imagem-div').hide();
                }else if (tipo===1){
                    $('#inputLink').hide();
                    this.tipoFicheiro = 1;
                    $('#dropdownFile').addClass('btn-file')
                    $('#imagem-div').show();
                }else if(tipo===2){
                    $('#inputLink').hide();
                    this.tipoFicheiro = 1;
                    $('#dropdownFile').addClass('btn-file')
                }

            },
            getRespostas(id) {
                axios.get('/prof/getRespostas/' + id)
                    .then(response => {
                        this.respostas = response.data.message;
                        console.log(this.respostas)
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
            $('#inputLink').hide();
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
