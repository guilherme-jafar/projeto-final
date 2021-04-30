<template>
    <div class="section-add-pergunta">



        <div class="collapse" :id="'collapse'+topicos">

            <p>Perguntas: </p>
        <div v-if="perguntas.length === 0" class="mx-auto">
            <h3>Ainda não tem nenhuma Pergunta</h3>

        </div>

        <div v-else class="lista-perguntas" >

        <ul >
            <li  v-for="pergunta in perguntas" :key="pergunta['id']">

                    <div class="d-flex mb-5 card">
                        <h3>{{pergunta['enunciado']}}</h3>
                        <button class="btn btn-primary ms-auto">Ver Detalhes</button>
                    </div>

            </li>
        </ul>
        </div>







        <div class="text-end">
            <button type="button" class="btn btn-third" data-bs-toggle="modal" :data-bs-target="'#p'+topicos">
                Adicionar pergunta
            </button>
        </div>


        <div class="modal fade" :id="'p'+topicos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Nova Pergunta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="pt-4 pb-5">
                            <div class="row text-center">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                            data-bs-toggle="modal"
                                            :data-bs-target="'#Up'+topicos">
                                        Adicionar pergunta
                                    </button>
                                </div>
                                <div class="col-md-6 mt-5 mt-md-0">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                            data-bs-toggle="modal"
                                            :data-bs-target="'#cp'+topicos">
                                        Importar perguntas
                                    </button>
                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" :id="'cp'+topicos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nova Pergunta</h5>
                        <button type="button" class="btn-close" data-bs-toogle="modal" aria-label="Close" data-bs-dismiss="modal"
                                ></button>
                    </div>
                    <div class="modal-body">


                            <a class="text-center" href="/assets/cvsPerguntas.xlsx" download>Exportar csv</a>
                        <div class="col-md-12 mt-5">
                            <input type="file" :id="'Insertfile' + topicos" class="Pergunta_file mx-auto" accept=".xlsx">
                            <label :file="'Insertfile' + topicos" class="pergunta_input"></label>
                            <p :id="'InsertfileError'+topicos"></p>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" :id="'InsertfileButton'+topicos"  @click="InsertFile(topicos)">Inserir</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade modal-adicionar-pergunta" :id="'Up'+topicos" data-bs-backdrop="static"
             data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">

            <div class="modal-dialog modal-xl modal-dialog-scrollable" style="width: 200%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nova Pergunta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-md-5">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control form-control-pergunta"
                                           placeholder="Escreva a pergunta aqui" :id="'pergunta'+topicos"><br>
                                    <p :id="'PerguntaError'+topicos"></p>
                                </div>
                                <div class="col-md-12 mt-5">
                                    <input type="file" :id="'file' + topicos" class="Pergunta_file mx-auto">
                                    <label :file="'file' + topicos" class="pergunta_input"></label>
                                    <p :id="'fileError'+topicos"></p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <label :for="'tipo'+topicos">
                                        Indique o tipo de pergunta<br>
                                        <select name="tipo" class="form-select" :id="'tipo'+topicos" @change="alter()">
                                            <option value="multiple">Seleção Única</option>
                                            <option value="multiple-select">Seleção Múltipla</option>
                                            <option value="true/false">Verdadeiro/Falso</option>


                                        </select>
                                    </label>
                                </div>

                                <div class="col-md-4 text-center">
                                    <label :for="'tempo'+topicos">
                                        Indique o tempo de pergunta<br>
                                        <select name="tipo" class="form-select" :id="'tempo'+topicos">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="60">1 minuto</option>
                                            <option value="90">1 minuto e 30 segundos</option>
                                            <option value="120">2 minutos</option>
                                            <option value="240">4 minutos</option>

                                        </select>
                                    </label>
                                </div>

                                <div class="col-md-4 text-center">
                                    <label :for="'pontos'+topicos">
                                        Indique a pontuação<br>
                                        <select name="pontos" class="form-select" :id="'pontos'+topicos">
                                            <option value="Normal">Normal</option>
                                            <option value="Pontos duplos">Pontos duplos</option>
                                            <option value="Sem pontos">Sem pontos</option>
                                        </select>
                                    </label>
                                </div>

                                <div class="col-md-12 ">
                                    <div :id="'multiple'+topicos" style="margin-top: 20px">

                                        <div class="input-group mb-3 insertAnsewr">

                                            <input type='text' :id="'re1'+topicos" class=" form-control" style="border: none;"
                                                   aria-label="Text input with radio button" placeholder="Opção 1">
                                            <div class="input-group-text">
                                                <input type="radio" :name="'corret'+topicos" :value="'re1'+topicos"
                                                       class="form-check-input">
                                            </div>
                                        </div>


                                        <div class="input-group mb-3 insertAnsewr">

                                            <input type='text' :id="'re2'+topicos" class=" form-control" style="border: none"
                                                   aria-label="Text input with radio button" placeholder="Opção 2">
                                            <div class="input-group-text">
                                                <input type="radio" :name="'corret'+topicos" :value="'re2'+topicos"
                                                       class="form-check-input">
                                            </div>
                                        </div>

                                        <div class="input-group mb-3 insertAnsewr">

                                            <input type='text' :id="'re3'+topicos" class=" form-control" style="border: none; "
                                                   aria-label="Text input with radio button" placeholder="Opção 3">
                                            <div class="input-group-text">
                                                <input type="radio" :name="'corret'+topicos" :value="'re3'+topicos"
                                                       class="form-check-input">
                                            </div>
                                        </div>


                                        <div class="input-group mb-3 insertAnsewr">

                                            <input type='text' :id="'re4'+topicos" class=" form-control" style="border: none; "
                                                   aria-label="Text input with radio button" placeholder="Opção 4">
                                            <div class="input-group-text">
                                                <input type="radio" :name="'corret'+topicos" :value="'re4'+topicos"
                                                       class="form-check-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div :id="'trueFalse'+topicos">

                                        <div class="mb-5 mt-5">
                                            <label class="label-tf">Verdadeira
                                                <input type="radio"  :name="'TF'+topicos" value="true" class="">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="label-tf">Falsa
                                                <input type="radio" :name="'TF'+topicos" value="false" class="">
                                                <span></span>
                                            </label>

                                        </div>

                                        <p :id="'TError'+topicos"></p>
                                    </div>
                                </div>

                                <div class="col-md-12 ">
                                    <div :id="'multiple-select'+topicos" style="margin-top: 20px">

                                        <div class="input-group mb-3 insertAnsewr">

                                            <input type='text' :id="'rem1'+topicos" class=" form-control" style="border: none;"
                                                   aria-label="Text input with radio button" placeholder="Opção 1">
                                            <div class="input-group-text">
                                                <input type="checkbox" :name="'corret'+topicos+'[]'" :value="'re1'+topicos"
                                                       class="form-check-input">
                                            </div>
                                        </div>


                                        <div class="input-group mb-3 insertAnsewr">

                                            <input type='text' :id="'rem2'+topicos" class=" form-control" style="border: none"
                                                   aria-label="Text input with radio button" placeholder="Opção 2">
                                            <div class="input-group-text">
                                                <input type="checkbox" :name="'corret'+topicos+'[]'" :value="'re2'+topicos"
                                                       class="form-check-input">
                                            </div>
                                        </div>

                                        <div class="input-group mb-3 insertAnsewr">

                                            <input type='text' :id="'rem3'+topicos" class=" form-control" style="border: none; "
                                                   aria-label="Text input with radio button" placeholder="Opção 3">
                                            <div class="input-group-text">
                                                <input type="checkbox" :name="'corret'+topicos+'[]'" :value="'re3'+topicos"
                                                       class="form-check-input">
                                            </div>
                                        </div>


                                        <div class="input-group mb-3 insertAnsewr">

                                            <input type='text' :id="'rem4'+topicos" class=" form-control" style="border: none; "
                                                   aria-label="Text input with radio button" placeholder="Opção 4">
                                            <div class="input-group-text">
                                                <input type="checkbox" :name="'corret'+topicos+'[]'" :value="'re4'+topicos"
                                                       class="form-check-input">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p :id="'RError'+topicos"></p>
                                </div>

                            </div>
                        </div>



                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" :id="'submit'+topicos" class="btn btn-primary"
                                    @click="submit(topicos)">inserir
                            </button>
                        </div>
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
            topicos: this.topico_id,
            perguntas:'',
            toastPergunta: ''
        }
    },
    methods: {

        getPerguntas(){
            let form =new FormData()
            form.append('id',this.topicos)
            axios.post('/getPerguntas',form).then(function (response){
                    this.perguntas= response.data.message;
                }.bind(this)
            );
        },

        submit(top) {


            let index = 0;
            $('#RError' + top).text(" ").css('color', 'red').css('opacity', '1');
            $('#TError' + top).text(" ").css('color', 'red').css('opacity', '1');
            $('#PerguntaError' + top).text(" ").css('color', 'red').css('opacity', '1');
            $('#fileError' + top).text(" ").css('color', 'red').css('opacity', '1');
            let form = new FormData();
            let file = document.getElementById("file" + top).files[0]
            let type, flag = false ,flag2 = false, corret;
            let array = [];
            var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/PNG", "video/mp4", "video/mpg", "video/avi,","audio/mpeg","audio/ogg","audio/mp3"];


            flag = false
            flag2 = false
            if (document.getElementById("pergunta" + top).value.length <= 0 ) {
                $('#PerguntaError' + top).text("indique o enunciado da pergunta").css('color', 'red').css('opacity', '1');
            } else if (document.getElementById("pergunta" + top).value.length >120){
                $('#PerguntaError' + top).text("O enunciado é demasiado grande").css('color', 'red').css('opacity', '1');
            }

            else {
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
                        if (document.getElementById("re" + i + top).value.length > 0 && document.getElementById("re" + i + top).value.length <=100) {
                            array.push(document.getElementById("re" + i + top).value)
                            index++;
                        }

                        if(document.getElementById("re" + i + top).value.length >=100){
                            flag2 = true;
                            break;

                        }
                        if (radios[i - 1].checked) {
                            flag = true;
                            corret = radios[i - 1].value;
                        }
                    }
                     if (flag2) {
                        $('#RError' + top).text("Uma das respostas tem mais de 100 letras").css('color', 'red').css('opacity', '1');

                    }
                     else if (index < 2) {
                        $('#RError' + top).text("Uma pergunta tem de ter pelo menos 2 respostas").css('color', 'red').css('opacity', '1');
                    }
                    else if (!flag) {
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
                        this.send(form,top)
                    }


                }else if(document.getElementById("tipo" + top).value === "multiple-select"){

                    let opcoes = $('input[name="corret'+top+'[]"]:checked');
                    let opcoesEscolhidas = [];
                    let respostas = [];
                    let guardarOpcoes = true;
                    if(opcoes.length  <= 1){
                        $('#RError' + top).text("Escolha duas ou mais opções corretas!!").css('color', 'red').css('opacity', '1');

                    }else {
                        for (let i = 0; i < opcoes.length; i++){
                            opcoesEscolhidas[i] = opcoes[i].value;
                            if (document.getElementById("rem" + (i+1) + top).value.length === 0){
                                $('#RError' + top).text("Não pode escolher uma opção vazia como certa!!").css('color', 'red').css('opacity', '1');
                                guardarOpcoes = false;
                                break;
                            }else if (document.getElementById("rem" + (i+1) + top).value.length > 100){
                                $('#RError' + top).text("Uma das respostas tem mais de 100 letras").css('color', 'red').css('opacity', '1');
                                guardarOpcoes = false;
                                break;
                            }

                        }

                        if (guardarOpcoes){
                            for (let i= 1; i < 5; i++){
                                if (document.getElementById("rem" + i + top).value.length > 0 && document.getElementById("rem" + i + top).value.length <=100){
                                    respostas[i - 1] = document.getElementById("rem" + i + top).value;

                                }

                            }

                            if (respostas.length >= 2){
                                form.append('array', JSON.stringify(respostas));
                                form.append('respostas', JSON.stringify(opcoesEscolhidas))

                                this.send(form, top)
                            }else{
                                $('#RError' + top).text("Só pode introduzir duas ou mais opcões!!").css('color', 'red').css('opacity', '1');
                            }


                        }





                    }


                }


           }

        },
        send(form, top) {

            $('#submit' + top).prop('disabled', true);
            axios.post('/insertQuestion', form
            ).then(function (response) {
                if (response.data.message === "erro") {

                    alert("Erro a inserir a pergunta");
                }
                else {
                    $('#submit' + top).prop('disabled', false);
                    this.modal.hide();
                    this.toastPergunta.show();
                    $('#toast-pergunta').removeClass('d-none');
                }
                document.getElementById("pergunta" + top).value = ""
                document.getElementById("file" + top).value = ""


                if (document.getElementById("tipo" + top).value === "multiple") {
                    var radios = document.getElementsByName("corret" + top);
                    for (let i = 1; i < 5; i++) {
                        document.getElementById("re" + i + top).value = ""

                        if (radios[i - 1].checked) {
                            radios[i - 1].checked = false;
                        }
                    }

                } else if (document.getElementById("tipo" + top).value === "true/false") {
                    var radios2 = document.getElementsByName("TF" + top);
                    for (let i = 0; i < 2; i++) {
                        if (radios2[i].checked) {
                            radios2[i - 1].checked = false;
                        }
                    }

                }else if (document.getElementById("tipo" + top).value === "multiple-select"){
                    var checkboxRe = document.getElementsByName("corret"+top+"[]");
                    for (let i= 1; i < 5; i++){
                       checkboxRe[i -1].checked = false;
                        document.getElementById("rem" + i + top).value = "";



                    }

                }
                this.getPerguntas();
            }.bind(this));
        },
        InsertFile(topicos){

            $('#InsertfileButton'+topicos).prop('disabled', true);
            $('#InsertfileError'+topicos).text("").css('color', 'red').css('opacity', '1');
            let newPerguntas =[];
            let flag= false;
            let form = new FormData()
            let status=this;
            let file = document.getElementById("Insertfile" + topicos).files[0];

              readXlsxFile(file).then(function (data){

                  console.log()
                    for (let i=4; i<104 ;i++){

                        if (data[i][1]!==null) {

                            newPerguntas.push(data[i])
                        }
                    }

                    for (let i=0; i<newPerguntas.length ;i++) {
                        if(newPerguntas[i][1].length<=120 && newPerguntas[i][2].length<=120 && newPerguntas[i][2].length<=120 && newPerguntas[i][2].length<=120 && newPerguntas[i][2].length<=120){

                            if (newPerguntas[i][newPerguntas[i][7]+1]===null){
                                $('#InsertfileError'+topicos).text("Erro no ficheiro").css('color', 'red').css('opacity', '1');
                                flag=true;
                                $('#InsertfileButton'+topicos).prop('disabled', false);
                            }

                        }
                        else{
                            $('#InsertfileError'+topicos).text("Erro no ficheiro").css('color', 'red').css('opacity', '1');
                            flag=true;
                            $('#InsertfileButton'+topicos).prop('disabled', false);

                        }
                    }
                    if (!flag) {

                        form.append('array', JSON.stringify(newPerguntas))
                        form.append('topico', topicos)
                        axios.post('/multiQuestion',form).then(function (response){

                            if (response.data.message==="sucesso"){
                                status.getPerguntas()
                                $('#InsertfileButton'+topicos).prop('disabled', false);
                                status.modal2.hide();
                            }else{

                                $('#InsertfileButton'+topicos).prop('disabled', false);
                                $('#InsertfileError'+topicos).text("Erro no ficheiro").css('color', 'red').css('opacity', '1');
                            }



                            }.bind(this)

                        );

                    }
                });







        },
        alter() {
            let id = "trueFalse" + this.topicos;
            let id2 = "multiple" + this.topicos;
            let id3 = "multiple-select" + this.topicos;
            if (document.getElementById("tipo" + this.topicos).value === "multiple") {

                $('#' + id).hide();
                $('#' + id2).show();
                $('#' + id3).hide();
            } else if (document.getElementById("tipo" + this.topicos).value === "true/false") {

                $('#' + id).show();
                $('#' + id2).hide();
                $('#' + id3).hide();
            } else if(document.getElementById("tipo"+ this.topicos).value === "multiple-select"){
                $('#' + id).hide();
                $('#' + id2).hide();
                $('#' + id3).show();
            }
        }
    },
    mounted() {
        this.getPerguntas();
        this.modal = new bootstrap.Modal(document.getElementById('Up' + this.topicos), {})
        this.modal2 = new bootstrap.Modal(document.getElementById('cp' + this.topicos), {})
        let id = "trueFalse" + this.topicos;
        let id2 = "multiple" + this.topicos;
        let id3 = "multiple-select" + this.topicos;
        $('#' + id).hide();
        $('#' + id2).show();
        $('#' + id3).hide();
        this.toastPergunta = new bootstrap.Toast(document.getElementById('toast-pergunta'), {delay: 10000})
        this.toastPergunta.hide();
    }
}
</script>


<style scoped>

</style>
