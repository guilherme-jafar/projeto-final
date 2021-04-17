<template>
    <div>
        <div class="text-end">
            <button type="button" class="btn btn-third" data-bs-toggle="modal" :data-bs-target="'#p'+topicos">
                Adicionar pergunta
            </button>
        </div>


        <div class="modal fade" :id="'p'+topicos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Nova Pergunta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div alight="right">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal"
                                    :data-bs-target="'#Up'+topicos">
                                Adicionar pergunta
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal"
                                    :data-bs-target="'#cp'+topicos">
                                Adicionar conjunto de perguntas
                            </button>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" :id="'cp'+topicos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nova Pergunta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" :id="'Up'+topicos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width: 200%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nova Pergunta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" placeholder="pergunta" :id="'pergunta'+topicos"><br>
                        <p :id="'PerguntaError'+topicos"></p>

                        <input type="file" :id="'file' + topicos" class="Pergunta_file">
                        <label :file="'file' + topicos" class="pergunta_input"></label>
                        <p :id="'fileError'+topicos"></p>

                        <label :for="'tipo'+topicos">
                            Indique o tipo de pergunta<br>
                            <select name="tipo" :id="'tipo'+topicos" @change="alter()">
                                <option value="multiple">escolha multipla</option>
                                <option value="true/false">verdadeiro/falso</option>


                            </select>
                        </label><br>
                        <label :for="'tempo'+topicos">
                            Indique o tempo de pergunta<br>
                            <select name="tipo" :id="'tempo'+topicos">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="60">1 minuto</option>
                                <option value="90">1 minuto e 30 segundos</option>

                            </select>
                        </label><br>
                        <label :for="'pontos'+topicos">
                            Indique a pontuação<br>
                            <select name="pontos" :id="'pontos'+topicos">
                                <option value="Normal">Normal</option>
                                <option value="Pontos duplos">Pontos duplos</option>
                                <option value="Sem pontos">Sem pontos</option>
                            </select>
                        </label>

                        <div :id="'multiple'+topicos" style="margin-top: 20px">

                            <div class="input-group mb-3 insertAnsewr">

                                <input type='text' :id="'re1'+topicos" class=" form-control" style="border: none;"
                                       aria-label="Text input with radio button">
                                <div class="input-group-text">
                                    <input type="radio" :name="'corret'+topicos" :value="'re1'+topicos"
                                           class="form-check-input">
                                </div>
                            </div>


                            <div class="input-group mb-3 insertAnsewr">

                                <input type='text' :id="'re2'+topicos" class=" form-control" style="border: none"
                                       aria-label="Text input with radio button">
                                <div class="input-group-text">
                                    <input type="radio" :name="'corret'+topicos" :value="'re2'+topicos"
                                           class="form-check-input">
                                </div>
                            </div>

                            <div class="input-group mb-3 insertAnsewr">

                                <input type='text' :id="'re3'+topicos" class=" form-control" style="border: none; "
                                       aria-label="Text input with radio button">
                                <div class="input-group-text">
                                    <input type="radio" :name="'corret'+topicos" :value="'re3'+topicos"
                                           class="form-check-input">
                                </div>
                            </div>


                            <div class="input-group mb-3 insertAnsewr">

                                <input type='text' :id="'re4'+topicos" class=" form-control" style="border: none; "
                                       aria-label="Text input with radio button">
                                <div class="input-group-text">
                                    <input type="radio" :name="'corret'+topicos" :value="'re4'+topicos"
                                           class="form-check-input">
                                </div>
                            </div>
                            <p :id="'RError'+topicos"></p>
                        </div>


                        <div :id="'trueFalse'+topicos">
                            true<input type="radio" :name="'TF'+topicos" value="true" class="form-check-input">
                            false<input type="radio" :name="'TF'+topicos" value="false" class="form-check-input">
                            <p :id="'TError'+topicos"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" :id="'submit'+topicos" class="btn btn-primary"
                                    @click="submit(topicos)">inserir
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

    import $ from 'jquery';
    import axios from "axios";

    export default {
        name: "pergunta",
        props: ['topico_id'],

        data() {
            return {
                topicos: this.topico_id
            }
        },
        methods: {

            submit(top) {

                $('#RError' + top).text(" ").css('color', 'red').css('opacity', '1');
                $('#TError' + top).text(" ").css('color', 'red').css('opacity', '1');
                $('#PerguntaError' + top).text(" ").css('color', 'red').css('opacity', '1');
                $('#fileError' + top).text(" ").css('color', 'red').css('opacity', '1');
                let form = new FormData();
                let file = document.getElementById("file" + top).files[0]
                let type, flag = false, corret;
                let array = [];
                var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/PNG", "video/mp4", "video/mpg", "video/avi"];

                let index = 0;


                if (document.getElementById("pergunta" + top).value.length <= 0) {
                    $('#PerguntaError' + top).text("indique o enunciado da pergunta").css('color', 'red').css('opacity', '1');
                } else {
                    form.append('topico', top);
                    form.append('pergunta', document.getElementById("pergunta" + top).value);
                    form.append('tempo', document.getElementById("tempo" + top).value);
                    form.append('tipo', document.getElementById("tipo" + top).value);
                    form.append('pontos', document.getElementById("pontos" + top).value);
                    if (file != null) {
                        type = file['type'];
                        if ($.inArray(type, validImageTypes) < 0) {

                            $('#fileError' + top).text("Ficheiro invalido").css('color', 'red').css('opacity', '1');
                        }
                        form.append('file', file);
                    } else {
                        form.append('file', null);
                    }

                    if (document.getElementById("tipo" + top).value === "multiple") {
                        var radios = document.getElementsByName("corret" + top);
                        for (let i = 1; i < 5; i++) {
                            if (!document.getElementById("re" + i + top).value.length <= 0) {
                                array.push(document.getElementById("re" + i + top).value)
                                index++;
                            }
                            if (radios[i - 1].checked) {
                                flag = true;
                                corret = radios[i - 1].value;
                            }
                        }
                        if (index < 2) {
                            $('#RError' + top).text("Uma pergunta tem de ter pelo menos 2 respostas").css('color', 'red').css('opacity', '1');
                        } else if (!flag) {
                            $('#RError' + top).text("Indique a resposta certa").css('color', 'red').css('opacity', '1');
                        } else {
                            form.append('array', JSON.stringify(array));
                            form.append('resposta', document.getElementById(corret).value)
                            this.send(form, top)
                        }

                    } else if (document.getElementById("tipo" + top).value === "true/false") {
                        var radios = document.getElementsByName("TF" + top);
                        for (let i = 0; i < 2; i++) {
                            if (radios[i].checked) {
                                flag = true;
                                corret = radios[i].value;
                            }
                        }
                        if (!flag) {
                            $('#TError' + top).text("Indique a resposta certa").css('color', 'red').css('opacity', '1');
                        } else {

                            form.append('resposta', corret)
                            this.send(form)
                        }


                    }


                }

            },
            send(form, top) {

                $('#submit' + top).prop('disabled', true);
                axios.post('/insertQuestion', form
                ).then(function (response) {
                    if (response.data.message === "erro") {

                        alert("erro a enserir a pergunta");
                    }
                    document.getElementById("pergunta" + top).value = ""
                    document.getElementById("file" + top).value = ""
                    var radios = document.getElementsByName("corret" + top);
                    for (let i = 1; i < 5; i++) {
                        document.getElementById("re" + i + top).value = " "

                        if (radios[i - 1].checked) {
                            radios[i - 1].checked = false;
                        }
                    }
                    var radios2 = document.getElementsByName("TF" + top);
                    for (let i = 0; i < 2; i++) {
                        if (radios2[i].checked) {
                            radios2[i - 1].checked = false;
                        }
                    }
                    $('#submit' + top).prop('disabled', false);
                    this.modal.hide();
                }.bind(this));
            },
            alter() {
                let id = "trueFalse" + this.topicos;
                let id2 = "multiple" + this.topicos;
                if (document.getElementById("tipo" + this.topicos).value === "multiple") {

                    $('#' + id).hide();
                    $('#' + id2).show();
                } else if (document.getElementById("tipo" + this.topicos).value === "true/false") {

                    $('#' + id).show();
                    $('#' + id2).hide();
                }
            }
        },
        mounted() {
            this.modal = new bootstrap.Modal(document.getElementById('Up' + this.topicos), {})
            let id = "trueFalse" + this.topicos;
            let id2 = "multiple" + this.topicos;
            $('#' + id).hide();
            $('#' + id2).show();
        }
    }
</script>

<style scoped>

</style>
