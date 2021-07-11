<template>
    <div class="editar-pergunta">

        <div class="p-md-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastEditarPergunta"
                             role="alert"
                             aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                                        <span>Pergunta editada com sucesso!!</span> </strong>
                                </div>
                                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                        aria-label="Close"></button>
                            </div>
                        </div>
                        <input type="text" class="form-control form-control-pergunta"
                               placeholder="Escreva a pergunta aqui" :id="'pergunta'+pergunta['id']"
                               :value="pergunta['enunciado']"><br>
                        <p :id="'PerguntaError'+pergunta['id']"></p>
                    </div>
                    <div class="col-md-12 text-center">
                        <input style="visibility: hidden" type="file" :id="'file' + pergunta['id']"
                               class="file-input mx-auto" @change="alterarFoto">
                        <label :file="'file' + pergunta['id']" class="pergunta_input"></label>
                        <!--                        <iframe width="560" height="315" src="https://youtu.be/I5UoAx1V9HA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" ></iframe>-->
                        <div v-if="!isFetchingM">
                            <div v-if="multimedia[0]['link'] !== null" id="imagem-div">
                                <div v-if="fileCheck()===1" class="text-center">

                                    <img :src="'/images/Pergunta/Multimedia/'+ multimedia[0]['link']"
                                         alt="imagem da pergunta" height="40%"
                                         width="40%" class="mx-auto mb-4" id="imagem">
                                </div>
                                <div v-else-if="fileCheck()===2" class="text-center">
                                    <div v-if="temImagem">
                                        <img :src="'/images/Pergunta/Multimedia/'+ multimedia[0]['link']"
                                             alt="imagem da pergunta" height="40%"
                                             width="40%" class="mx-auto mb-4" id="imagem">
                                    </div>
                                    <!--                                    <iframe width="560" height="315" src="https://www.youtube.com/watch?v=I5UoAx1V9HA&t=69s" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" ></iframe>-->
                                </div>
                                <div v-else-if="fileCheck()===3" class="text-center">

                                    <audio controls>
                                        <source id="questionMultiAudio"
                                                :src="'/images/Pergunta/Multimedia/'+multimedia[0]['link']"
                                                type="">
                                    </audio>
                                    <div v-if="temImagem">
                                        <img :src="'/images/Pergunta/Multimedia/'+ multimedia[0]['link']"
                                             alt="imagem da pergunta" height="40%"
                                             width="40%" class="mx-auto mb-4" id="imagem">
                                    </div>
                                </div>
                                <div v-else-if="fileCheck()===0">

                                </div>

                            </div>
                            <div v-else>
                                <div v-if="temImagem">
                                    <img :src="'/images/Pergunta/Multimedia/'+ multimedia[0]['link']"
                                         alt="imagem da pergunta" height="40%"
                                         width="40%" class="mx-auto mb-4" id="imagem">
                                </div>

                            </div>
                        </div>

                        <div class="btn-file mx-auto mb-5 d-flex" id="dropdownFile">
                            <input class="form-control form-control-2" type="url" :id="'inputLink'"
                                   placeholder="Introduza o link do vídeo Youtube">
                            <div class="dropdown mx-auto text-center">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    Adicionar ficheiro
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><label class="dropdown-item" @click="fileType(1)"
                                               :for="'file' + pergunta['id']">Imagem</label></li>
                                    <li><label class="dropdown-item" @click="fileType(2)"
                                               :for="'file' + pergunta['id']">Audio</label></li>
                                    <li>
                                        <button class="dropdown-item" @click="fileType(3)">Youtube Link</button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <p :id="'fileError'+pergunta['id']"></p>
                    </div>
                    <div class="col-md-4 text-center mb-3 ">
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
                                <option value="multiple-image" v-bind:selected="pergunta['tipo'] === 'multiple-image'">
                                    Pergunta com imagem
                                </option>


                            </select>
                        </label>
                    </div>

                    <div class="col-md-4 text-center mb-3">
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
                            <br class="d-lg-none d-md-block d-none ">
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
                            <div class="card-loading is-loading mt-5">
                                <div class="content">

                                    <p></p>
                                </div>
                            </div>
                            <div class="card-loading is-loading mt-5">
                                <div class="content">

                                    <p></p>
                                </div>
                            </div>
                            <div class="card-loading is-loading mt-5">
                                <div class="content">

                                    <p></p>
                                </div>
                            </div>
                            <div class="card-loading is-loading mt-5">
                                <div class="content">

                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="card-loading is-loading mt-5">
                                <div class="content">

                                    <p></p>
                                </div>
                            </div>
                            <div class="card-loading is-loading mt-5">
                                <div class="content">

                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 ">
                        <div :id="'multiple'+pergunta['id']" style="margin-top: 20px">

                            <div v-if="!isFetching">
                                <div v-for="(resposta, index) in respostas">
                                    <div class="input-group mb-3 insertAnsewr">

                                        <input type='text' :id="'re' +( index +1) +pergunta['id']" class=" form-control"
                                               style="border: none;"
                                               aria-label="Text input with radio button"
                                               :placeholder="'Opção' + ( index +1)"
                                               :value="(pergunta['tipo'] === 'multiple'? resposta['resposta'] : '')">
                                        <div class="input-group-text">
                                            <input type="radio" :name="'corret'+pergunta['id']"
                                                   :value="'re' + ( index +1) +pergunta['id']"
                                                   v-bind:checked="resposta['resultado']===1"
                                                   class="form-check-input">
                                        </div>
                                    </div>
                                </div>
                                <div v-if="respostas.length < 4">

                                    <div v-for="(resposta, index) in  4 - respostas.length ">
                                        <div class="input-group mb-3 insertAnsewr">

                                            <input type='text' :id="'re' +(index + respostas.length +1) +pergunta['id']"
                                                   class=" form-control"
                                                   style="border: none;"
                                                   aria-label="Text input with radio button"
                                                   :placeholder="'Opção' + ( index + respostas.length +1)"
                                                   :value="(pergunta['tipo'] === 'multiple'? resposta['resposta'] : '')">
                                            <div class="input-group-text">
                                                <input type="radio" :name="'corret'+pergunta['id']"
                                                       :value="'re' + ( index + respostas.length +1) +pergunta['id']"
                                                       v-bind:checked="resposta['resultado']===1"
                                                       class="form-check-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>


                    <div class="col-md-12 ">

                        <div :id="'multiple-image'+pergunta['id']" style="margin-top: 20px">

                            <div v-if="!isFetching">
                                <div v-for="(resposta, index) in respostas">
                                    <div class="input-group mb-3 insertAnsewr">

                                        <input v-if="" type='file' :id="'rei' +( index +1) +pergunta['id']"
                                               accept="image/png,image/gif, image/jpeg"

                                               v-bind:class=" tipoPerguntaInicial[index] === 'multiple-image'? 'form-control tipo-multiple-image-input  d-none': 'form-control tipo-multiple-image-input'"
                                               style="border: none;"
                                               aria-label="Text input with radio button"
                                               :placeholder="'Opção' + ( index +1)"
                                               @change="showImage('rei'+( index +1),'img' +( index +1),'sh'+( index +1), index)">
                                        <div :id="'img'+(index +1) + pergunta['id']"
                                             v-bind:class=" tipoPerguntaInicial[index] !== 'multiple-image'? 'd-none': '' ">

                                            <img width="260px" height="200px" :id="'sh'+(index+1)+pergunta['id']"
                                                 :src="pergunta['tipo'] === 'multiple-image'? '/images/Pergunta/Multimedia/'+ resposta['resposta'] : '#'"
                                                 :alt="'imagem'+index"
                                                 v-bind:class="'tipo-multiple-image'"

                                            />
                                            <button type="button"
                                                    v-bind:class="'tipo-multiple-image btn-close'"
                                                    @click="removeImg('rei'+( index +1),'img'+ (index +1),'sh'+ (index +1), index)"></button>
                                        </div>

                                        <div class="input-group-text">
                                            <input type="radio" :name="'corretImg'+pergunta['id']"
                                                   v-bind:checked="resposta['resultado']===1"
                                                   class="form-check-input"
                                                   :value="'resp' + ( index +1) +pergunta['id']">
                                        </div>
                                    </div>
                                </div>
                                <div v-if="respostas.length < 4">

                                    <div v-for="(resposta, index) in  4 - respostas.length ">
                                        <div class="input-group mb-3 insertAnsewr">

                                            <input type='file'
                                                   :id="'rei' +(index + respostas.length +1) +pergunta['id']"
                                                   accept="image/png,image/gif, image/jpeg"
                                                   v-bind:class=" tipoPerguntaInicial[index] === 'multiple-image'? 'form-control tipo-multiple-image-input  d-none': 'form-control tipo-multiple-image-input'"
                                                   style="border: none;"
                                                   aria-label="Text input with radio button"
                                                   :placeholder="'Opção' + ( index + respostas.length +1)"
                                                   @change="showImage('rei'+(index + respostas.length +1),'img' +(index + respostas.length +1),'sh'+(index + respostas.length +1), index)">
<!--                                            <div v-if="tipoPerguntaInicial === 'multiple-image'"-->
                                            <div :id="'img'+(index + respostas.length +1) + pergunta['id']"
                                                 v-bind:class=" tipoPerguntaInicial[index] !== 'multiple-image'? 'd-none': '' ">

                                                <img width="260px" height="200px" :id="'sh'+(index + respostas.length +1)+pergunta['id']"
                                                     :src="pergunta['tipo'] === 'multiple-image' ? '/images/Pergunta/Multimedia/'+ resposta['resposta'] : '#'"
                                                     :alt="'imagem'+index"
                                                     v-bind:class="'tipo-multiple-image'"
                                                />
                                                <button type="button"
                                                        v-bind:class="'tipo-multiple-image btn-close'"
                                                        @click="removeImg('rei'+(index + respostas.length +1),'img'+ (index + respostas.length +1),'sh'+ (index + respostas.length +1), index)"></button>
                                            </div>
                                            <!--                                                   :value="(pergunta['tipo'] === 'multiple'? resposta['resposta'] : '')">-->

                                            <div class="input-group-text">
                                                <input type="radio" :name="'corretImg'+pergunta['id']"
                                                       :value="'resp' + ( index + respostas.length +1) +pergunta['id']"
                                                       v-bind:checked="resposta['resultado']===1"
                                                       class="form-check-input">
                                            </div>
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

                                <div v-for="(resposta, index) in respostas">

                                    <div class="input-group mb-3 insertAnsewr">

                                        <input type='text' :id="'rem'+( index +1) +pergunta['id']" class=" form-control"
                                               style="border: none;"
                                               aria-label="Text input with radio button"
                                               :placeholder="'Opção' + ( index +1)"
                                               :value="(pergunta['tipo'] === 'multiple-select'? resposta['resposta'] : '')">
                                        <div class="input-group-text">
                                            <input type="checkbox" :name="'corret'+pergunta['id']+'[]'"
                                                   v-bind:checked="resposta['resultado']===1"
                                                   :value="'rem'+ ( index +1) +pergunta['id']"
                                                   class="form-check-input">
                                        </div>
                                    </div>
                                </div>
                                <div v-if="respostas.length < 4">

                                    <div v-for="(resposta, index) in  4 - respostas.length ">
                                        <div class="input-group mb-3 insertAnsewr">

                                            <input type='text' :id="'rem'+(index + respostas.length +1) +pergunta['id']"
                                                   class=" form-control"
                                                   style="border: none;"
                                                   aria-label="Text input with radio button"
                                                   :placeholder="'Opção' + (index + respostas.length +1)"
                                                   :value="(pergunta['tipo'] === 'multiple-select'? resposta['resposta'] : '')">
                                            <div class="input-group-text">
                                                <input type="checkbox" :name="'corret'+pergunta['id']+'[]'"
                                                       v-bind:checked="resposta['resultado']===1"
                                                       :value="'rem'+(index + respostas.length +1) +pergunta['id']"
                                                       class="form-check-input">
                                            </div>
                                        </div>
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
            <a :href="'/prof/Disciplina/' + pergunta['disciplinaId']" class="btn btn-secondary" data-bs-dismiss="modal">Sair
            </a>
            <button type="button" :id="'submit'" class="btn btn-primary ms-3 btn-loading"
                    @click="submit(pergunta['id'])">
                <span class="">Guardar</span>
                <div class="spinner-border text-light d-none" role="status">

                </div>
            </button>
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
                tipoFicheiro: 0,
                multimedia: [],
                isFetchingM: true,
                i: 0,
                temImagem: false,
                toastEditarPergunta: '',
                imagemAntiga: [true, true, true, true],
                tipoPerguntaInicial: ['','', '', '']

            }
        },
        methods: {
            alterarFoto(e) {


                if (this.tipoFicheiro === 1) {

                    let imagem = document.getElementById("imagem");
                    imagem.src = URL.createObjectURL(e.target.files[0]);
                    this.imagem = e.target.files[0];

                }


            },
            showImage(idFile, idImg, idSh, i) {
                let id = idFile + this.pergunta['id'];
                let img = idImg + this.pergunta['id'];
                let sh = idSh + this.pergunta['id'];
                let myFile = $('#' + id).prop('files');
                console.log(id)
                console.log(img)
                console.log(sh)
                $('#' + sh).prop('src', URL.createObjectURL(myFile[0]));
                $('#' + img).removeClass('d-none');
                // $('#' + id).addClass('d-none');
                this.imagemAntiga[i] = false;
            },
            removeImg(idFile, idImg, idSh, i) {
                let id = idFile + this.pergunta['id'];
                let img = idImg + this.pergunta['id'];
                let sh = idSh + this.pergunta['id'];
                $('#' + id).val('')
                $('#' + sh).prop('src', '#');
                $('#' + img).addClass('d-none');
                $('#' + id).removeClass('d-none');
                //this.tipoPerguntaInicial[i] = '';
                console.log( this.tipoPerguntaInicial[i])
            },
            fileCheck() {
                if (this.multimedia[0]['link'] === null) {
                    return 0;
                } else {
                    let ext = this.getExtension(this.multimedia[0]['link'])

                    switch (ext.toLowerCase()) {
                        case 'jpeg':
                        case 'gif':
                        case 'bmp':
                        case 'png':
                        case 'jpg':
                            return 1;
                    }
                    if (this.multimedia[0]['link'].includes("youtube")) {
                        $('#inputLink').show();
                        $('#dropdownFile').addClass('btn-file-hide')
                        document.getElementById('inputLink').value = this.multimedia[0]['link'];
                        return 2
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
            submit(perguntaId) {
                $('#RError' + perguntaId).text(" ").css('color', 'red').css('opacity', '1');
                $('#TError' + perguntaId).text(" ").css('color', 'red').css('opacity', '1');
                $('#PerguntaError' + perguntaId).text(" ").css('color', 'red').css('opacity', '1');
                $('#fileError' + perguntaId).text(" ").css('color', 'red').css('opacity', '1');

                $('#submit span').addClass('d-none');
                $('#submit div').removeClass('d-none');
                var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/PNG", "audio/mpeg", "audio/ogg", "audio/mp3"];
                let form = new FormData();
                let file;
                let type, flag = false, flag2 = false, corret, flag3 = false;
                let array = [];
                let index = 0;


                if (document.getElementById("pergunta" + perguntaId).value.length <= 0) {
                    $('#PerguntaError' + perguntaId).text("indique o enunciado da pergunta").css('color', 'red').css('opacity', '1');
                } else if (document.getElementById("pergunta" + perguntaId).value.length > 120) {
                    $('#PerguntaError' + perguntaId).text("O enunciado é demasiado grande. Deve ter 120 caracteres no máximo!!").css('color', 'red').css('opacity', '1');
                } else {
                    let desc= document.getElementById("pergunta" + perguntaId).value.replaceAll("\"", "\\\"");
                    form.append('pergunta', desc);
                    form.append('tempo', document.getElementById("tempo" + perguntaId).value);
                    form.append('tipo', document.getElementById("tipo" + perguntaId).value);
                    form.append('pontos', document.getElementById("pontos" + perguntaId).value);
                    form.append('tipoInicial', this.pergunta['tipo'])
                    form.append('respostasId', JSON.stringify(this.respostas));
                    form.append('topicoId', this.pergunta['topicos_id']);
                    form.append('multimedia', JSON.stringify(this.multimedia))

                    if (this.tipoFicheiro === 1) {
                        file = document.getElementById("file" + perguntaId).files[0]
                        if (file != null) {
                            type = file['type'];
                            if ($.inArray(type, validImageTypes) < 0) {

                                $('#fileError' + perguntaId).text("Ficheiro invalido").css('color', 'red').css('opacity', '1');
                            }
                            form.append('file', file);
                        } else {
                            form.append('file', this.multimedia[0]['link']);
                        }
                    } else if (this.tipoFicheiro === 3) {
                        form.append('fileLink', document.getElementById("inputLink").value)
                    } else {
                        form.append('file', this.multimedia[0]['link'])
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
                        } else if (document.getElementById(corret).value.trim().length === 0) {
                            $('#RError' + perguntaId).text("Não pode escolher uma resposta vazia como correta!!").css('color', 'red').css('opacity', '1');
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
                        }
                    } else if (document.getElementById("tipo" + perguntaId).value === "multiple-select") {

                        let opcoes = $('input[name="corret' + perguntaId + '[]"]:checked');

                        let opcoesEscolhidas = [];
                        let respostas = [];
                        let guardarOpcoes = true;
                        if (opcoes.length <= 1) {
                            $('#RError' + perguntaId).text("Escolha duas ou mais opções corretas!!").css('color', 'red').css('opacity', '1');

                        } else {
                            for (let i = 0; i < opcoes.length; i++) {
                                opcoesEscolhidas[i] = opcoes[i].value;

                                if (document.getElementById(opcoes[i].value).value.length === 0) {
                                    $('#RError' + perguntaId).text("Não pode escolher uma opção vazia como certa!!").css('color', 'red').css('opacity', '1');
                                    guardarOpcoes = false;
                                    break;
                                } else if (document.getElementById("rem" + (i + 1) + perguntaId).value.length === 0) {
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

                    if (document.getElementById("tipo" + perguntaId).value === "multiple-image") {
                        var radios = document.getElementsByName("corretImg" + perguntaId);


                        for (let i = 1; i < 5; i++) {

                            if (this.pergunta['tipo'] !== 'multiple-image') {

                                if (document.getElementById("rei" + i + perguntaId).files.length > 0) {
                                    array.push(document.getElementById("rei" + i + perguntaId).files[0])
                                    form.append('files[' + i + ']', document.getElementById("rei" + i + perguntaId).files[0]);
                                    index++;
                                }

                            } else {

                                if (this.imagemAntiga[i - 1] === true) {

                                    if (document.getElementById('img' + 1 + perguntaId).src !== '#') {
                                        form.append('files[' + i + ']', document.getElementById('sh' + i + perguntaId).src)
                                        array.push(document.getElementById('sh' + i + perguntaId).src)
                                        index++;
                                    }
                                } else {
                                    if (document.getElementById("rei" + i + perguntaId).files.length > 0) {
                                        array.push(document.getElementById("rei" + i + perguntaId).files[0])
                                        form.append('files[' + i + ']', document.getElementById("rei" + i + perguntaId).files[0]);
                                        index++;
                                    }
                                }

                            }


                            if (radios[i - 1].checked) {
                                flag = true;
                                corret = radios[i - 1].value;
                            }
                        }


                        if (index < 2) {
                            $('#RError' + perguntaId).text("Uma pergunta tem de ter pelo menos 2 respostas").css('color', 'red').css('opacity', '1');
                        } else if (!flag) {
                            $('#RError' + perguntaId).text("Indique a resposta certa").css('color', 'red').css('opacity', '1');
                        } else {

                            form.append('resposta', corret)
                            form.append('imagemAntiga', JSON.stringify(this.imagemAntiga))
                            form.append('array', JSON.stringify(array));
                            form.append('numeroPerguntas', index)
                            console.table(this.imagemAntiga)
                            // for (var pair of form.entries()) {
                            //     console.log(pair[0] + ', ' + pair[1]);
                            // }
                            this.send(form, perguntaId)
                        }

                    }


                }


            },
            send(form, perguntaID) {

                axios.post('/prof/pergunta/' + perguntaID + '/editar', form
                ).then(function (response) {

                    if (response.data.message === "sucesso") {

                        $('#toastEditarPergunta').removeClass('d-none');
                        $('.btn-loading span').removeClass('d-none');
                        $('.btn-loading div').addClass('d-none');
                        this.toastEditarPergunta.show();
                    } else if (response.data.message === "erro") {

                        alert("Erro a editar a pergunta");


                    }


                }.bind(this));

            },
            fileType(tipo) {

                if (tipo === 3) {
                    $('#inputLink').show();
                    $('#dropdownFile').addClass('btn-file-hide')
                    this.tipoFicheiro = 3;
                    $('#imagem-div').hide();
                } else if (tipo === 1) {
                    $('#inputLink').hide();
                    this.tipoFicheiro = 1;
                    $('#dropdownFile').addClass('btn-file')
                    $('#imagem-div').show();
                    this.temImagem = true;
                } else if (tipo === 2) {
                    $('#inputLink').hide();
                    this.tipoFicheiro = 2;
                    $('#dropdownFile').addClass('btn-file')

                }

            },
            getRespostas(id) {
                axios.get('/prof/getRespostas/' + id)
                    .then(response => {
                        this.respostas = response.data.message;
                        console.log(this.respostas)



                        // for (let i = 1; i <= this.respostas.length; i++) {
                        //     if (this.pergunta['tipo'] !== 'multiple-image') {
                        //
                        //         $('#rei' + i + this.pergunta['id']).show();
                        //         $('#img' + i + this.pergunta['id']).hide();
                        //         $('#sh' + i + this.pergunta['id']).hide();
                        //     }else {
                        //         console.log('#rei' + i + this.pergunta['id'])
                        //         $('#rei' + i + this.pergunta['id']).addClass('d-none');
                        //         $('#img' + i + this.pergunta['id']).show();
                        //         $('#sh' + i + this.pergunta['id']).show();
                        //
                        //
                        //
                        //
                        //
                        //
                        //     }
                        //
                        //
                        // }
                        this.tipoPerguntaInicial = [this.pergunta['tipo'],this.pergunta['tipo'], this.pergunta['tipo'], this.pergunta['tipo']];


                        // setTimeout(() => {
                        //     this.isFetching = false;
                        // }, 2000)
                        this.isFetching = false;

                    });





            },
            getMultimedia(id) {
                axios.get('/prof/getMultimedia/' + id)
                    .then(response => {
                        this.multimedia = response.data.message;
                        this.isFetchingM = false;
                    });
            },
            alter() {
                let id = "trueFalse" + this.pergunta['id'];
                let id2 = "multiple" + this.pergunta['id'];
                let id3 = "multiple-select" + this.pergunta['id'];
                let id4 = "multiple-image" + this.pergunta['id'];

                if (document.getElementById("tipo" + this.pergunta['id']).value === "multiple") {

                    $('#' + id).hide();
                    $('#' + id2).show();
                    $('#' + id3).hide();
                    $('#' + id4).hide();
                } else if (document.getElementById("tipo" + this.pergunta['id']).value === "true/false") {

                    $('#' + id).show();
                    $('#' + id2).hide();
                    $('#' + id3).hide();
                    $('#' + id4).hide();
                } else if (document.getElementById("tipo" + this.pergunta['id']).value === "multiple-select") {
                    $('#' + id).hide();
                    $('#' + id2).hide();
                    $('#' + id3).show();
                    $('#' + id4).hide();
                } else if (document.getElementById("tipo" + this.pergunta['id']).value === "multiple-image") {
                    $('#' + id).hide();
                    $('#' + id2).hide();
                    $('#' + id3).hide();
                    $('#' + id4).show();
                }
            }
        },
        mounted() {
            this.tipoPerguntaInicial = this.pergunta['tipo'];
            $('#inputLink').hide();
            this.getRespostas(this.pergunta['id']);
            this.getMultimedia(this.pergunta['id'])
            let pergunta = this.pergunta
            let id = "trueFalse" + pergunta['id'];
            let id2 = "multiple" + pergunta['id'];
            let id3 = "multiple-select" + pergunta['id'];
            let id4 = "multiple-image" + pergunta['id'];
            if (pergunta['tipo'] === 'multiple-select') {

                $('#' + id).hide();
                $('#' + id2).hide();
                $('#' + id3).show();
                $('#' + id4).hide();
            } else if (pergunta['tipo'] === 'multiple') {

                $('#' + id).hide();
                $('#' + id2).show();
                $('#' + id3).hide();
                $('#' + id4).hide();
            } else if (pergunta['tipo'] === 'true/false') {

                $('#' + id).show();
                $('#' + id2).hide();
                $('#' + id3).hide();
                $('#' + id4).hide();
            } else if (pergunta['tipo'] === 'multiple-image') {

                $('#' + id).hide();
                $('#' + id2).hide();
                $('#' + id3).hide();
                $('#' + id4).show();
            }
            this.toastEditarPergunta = new bootstrap.Toast(document.getElementById('toastEditarPergunta'), {delay: 10000})
            this.toastEditarPergunta.hide()
            this.tipoPerguntaInicial = pergunta['tipo'];


        }

    }
</script>
