<template>
    <div class="section-topicos mt-5 me-md-5 ms-md-5">
        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp; <span>Quizz adicionada com sucesso</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div v-if="quizz.length === 0" class="mx-auto">
            <h1 class="heanding-1 mx-auto mt-5">Ainda não tem nenhum Quizz</h1>
            <!-- Button trigger modal -->
            <button type="button" class=" btn btn-new mt-5 mx-auto" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                <i class="bi bi-plus-circle"></i> &nbsp;&nbsp; Adicionar Quizz
            </button>
        </div>

        <div v-else class="section-disciplinas-items " >
            <div class="box-search mb-5">
                <input class=" form-control form-control-lg form-search" type="text" v-model="search" placeholder="Pesquisar Quizz...">
                <i class="bi bi-search"></i>
            </div>
            <h1>Quizz</h1>
            <ul >
                <li class="card-box mb-5 mt-4" v-for="quizz in filter" :key="quizz['id']">

                    <div class="card-box-text">
                        <h2>{{quizz['nome']}}</h2  > <button type="button"  data-bs-toggle="modal"  :data-bs-target="'#t'+quizz['id']" class="btn btn-secondary ms-2" >quizz</button><i class="bi bi-three-dots-vertical"></i>
                    </div>



                    <div class="modal fade" :id="'t'+quizz['id']" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Entrar em quizz</h5>
                                    <button type="button" class="btn-close" data-bs-toogle="modal" aria-label="Close"
                                            data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">

                                    Tem a certeza que quer iniciar este teste?

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="EnterQuizz(quizz['id'])">Sim</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>

                                </div>
                            </div>
                        </div>
                    </div>

                </li>
            </ul>






        </div>

        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar  Novo Topico</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-5 pb-5">
                        <form class="row mx-auto" id="adicionarQuizz">
                            <div class="col-12">

                                <input name="titulo" class="form-control mt-2 mb-3 " type="text" id="titulo">
                                <label class="label" for="titulo" ><span>Titulo</span></label>
                            </div>
                            <div class="col-12 mb-5">
                                <p class="error " id="TituloError"></p>
                            </div>
                            <div class="col-12 mt-3">

                                <textarea class="form-control"  name="quizzdescricao" id="quizzdescricao" rows="2"></textarea>
                                <label class="label" for="quizzdescricao"><span>Descrição</span></label>
                            </div>

                                <div id="realTime" class="mb-1 mt-5">
                                   <h4>Realtime</h4>
                                    <div class="mb-1 mt-5">


                                            <input type="radio"  name="realtimeop" value="true" class="">
                                           Sim

                                    </div>
                                    <div>

                                            <input type="radio" name="realtimeop" value="false" class="">
                                           Não


                                    </div>
                                    <p id="TError"></p>
                                </div>
                                    <div id="Visivel" class="mb-1 mt-5">
                                        <h4>Visivel</h4>
                                        <div class="mb-1 mt-5">


                                            <input type="radio"  name="Visivelop" value="true" class="">
                                            Sim

                                        </div>
                                        <div>

                                            <input type="radio" name="Visivelop" value="false" class="">
                                            Não


                                        </div>
                                        <p id="ErrorVisivel"></p>
                                    </div>

                            <div class="col-12 mt-3">

                                <input class="form-control"  name="nPerguntas" id="nPerguntas" type="number">
                                <label class="label" for="nPerguntas"><span>Numero perguntas</span></label>
                            </div>
                            <div class="col-12 mb-5">
                                <p class="error " id="NumeroError"></p>
                            </div>

                            <div class="card-box mb-5 mt-4" v-for="topico in topicos" :key="topico['id']">

                                <div class="card-box-text">
                                    <label><h2>{{topico['nome']}}</h2><input type="checkbox" :value="topico['id']" name="topico"></label>
                                </div>

                            </div>
                            <div class="col-12 mb-5">
                                <p class="error " id="TopicoError"></p>
                            </div>








                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="submitQuizz" class="btn btn-secondary btn-submit" @click="submitNewQuizz" >  <span class="">Adicionar &nbsp;</span>
                            <div class="spinner-border text-light d-none" role="status">

                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
import $ from "jquery";
import axios from "axios";

export default {
name: "quizz",
    props: ['topico_prop'] ,

    data(){
        return{
            modal: '',
            toast: '',
            search:'',
            topicos:JSON.parse(this.topico_prop),
            quizz:''
        }
    },

    methods:{

        EnterQuizz(quizz){
            let session='_' + Math.random().toString(36).substr(2, 9);
            window.location.replace('/WaitRoom/' + quizz+'/'+session)

        },

        submitNewQuizz() {
            let l=window.location.href.split('/');
            var flagTime, corretTime,flagVisibel, corretVisibel;
            var array=[];
            var form = new FormData();
            $('#TituloError').text(" ").css('color', 'red').css('opacity', '1');
            $('#TError').text(" ").css('color', 'red').css('opacity', '1');
            $('#ErrorVisivel').text(" ").css('color', 'red').css('opacity', '1');
            $('#TopicoError').text(" ").css('color', 'red').css('opacity', '1');
            $('#NumeroError').text(" ").css('color', 'red').css('opacity', '1');

            if ($('#titulo').val().length === 0) {
                $('#TituloError').text("Endique um titulo para o quizz").css('color', 'red').css('opacity', '1');

            }

            else {

                var radios = document.getElementsByName("realtimeop" );
                for (let i = 0; i < 2; i++) {
                    if (radios[i].checked) {
                        flagTime = true;
                        corretTime = radios[i].value;
                    }
                }
                if (!flagTime) {
                    $('#TError').text("Indique o tipo de quizz que quer").css('color', 'red').css('opacity', '1');
                } else {

                    form.append('realtime', corretTime);
                    form.append('titulo', $('#titulo').val());
                    form.append('descricao', $('#quizzdescricao').val());
                    var radios2 = document.getElementsByName("Visivelop" );
                    for (let i = 0; i < 2; i++) {
                        if (radios2[i].checked) {
                            flagVisibel = true;
                            corretVisibel = radios2[i].value;
                        }
                    }
                    if (!flagVisibel) {
                        $('#ErrorVisivel').text("Indique se quer o teste ja visivel ou não").css('color', 'red').css('opacity', '1');
                    } else {
                        form.append('visible', corretVisibel);
                        if ($('#nPerguntas').val()<3){
                            $('#NumeroError').text("Um quizz deve ter pelo menos tres perguntas").css('color', 'red').css('opacity', '1');

                        }
                        else{
                            form.append('nPerguntas',$('#nPerguntas').val() );
                            var check = document.getElementsByName("topico" );
                            var count=0


                            for (let i = 0; i < check.length; i++) {

                                if (check[i].checked) {
                                    array.push(check[i].value)
                                        count++

                                }
                            }

                            if(count===0){
                                $('#TopicoError').text("Tem que indicar pelo menos um topico").css('color', 'red').css('opacity', '1');
                            }
                            else{
                                form.append('array', JSON.stringify(array));
                                form.append( 'id',l[l.length-1]);
                                this.sendQuizz(form);
                            }


                        }
                    }


                }
            }
        },
        sendQuizz(form){
            $('#submitQuizz').prop('disabled', true);
            var vm = this;
            axios.post('/insertQuizz', form
            ).then(function (response) {
                if (response.data.message==="sucesso") {

                    vm.listQuizz();
                    $('#submitQuizz').prop('disabled', false);
                   vm.modal.hide();
                    vm.toast.show();
                }else if (response.data.message==="numero de perguntas invalido"){
                    $('#NumeroError').text("numero de perguntas invalido").css('color', 'red').css('opacity', '1');
                    $('#submitQuizz').prop('disabled', false);
                }
                else{
                        alert("Erro a tentar inserir o quizz")
                    $('#submitQuizz').prop('disabled', false);
                    this.modal.hide();
                }

        });
            }, listQuizz(){
            axios.post('/getQuizz'
            ).then(function (response) {

                this.quizz=response.data.message;
            }.bind(this));



        },
        topicsCheck(){
            if (this.topicos.length===0){

                $('#submitQuizz').prop('disabled', true);
            }
            else{
                $('#submitQuizz').prop('disabled', false);
            }

        },



},
    computed:{
        filter:function (){
            return this.quizz.filter((quizz)=>{
                return quizz['nome'].match(this.search)
            })
        }
    },
    mounted() {

        this.modal = new bootstrap.Modal(document.getElementById('exampleModal2'), {})
        this.toast = new  bootstrap.Toast(document.getElementById('toast'), {delay: 10000})
        this.toast.hide();
           this.topicsCheck();
            this.listQuizz();
    }

}
</script>

<style scoped>

</style>
