<template>


   <div >
        <div v-if="quizz.length === 0" class="mx-auto">
            <h1 class="heanding-1 mx-auto mt-5">Ainda não tem nenhum Quizz</h1>

        </div>

        <div v-else class="section-disciplinas-items " >
            <div class="box-search mb-5">
                <input class=" form-control form-control-lg form-search" type="text" v-model="search" placeholder="Pesquisar Quizz...">
                <i class="bi bi-search"></i>
            </div>
            <h1>Quizz</h1>
            <ul >
                <li class="card-box mb-5 mt-4" v-for="quizz in filter" :key="quizz['id']">

                    <div v-if="quizz['tipo']==='true'">
                    <div class="card-box-text">
                        <h2>{{quizz['nome']}}</h2><br>
                        <p style="font-size: 16px">&nbsp;&nbsp;Perguntas: {{quizz['numeroperguntas']}}</p>
                        <button type="button"  data-bs-toggle="modal"  :data-bs-target="'#p'+quizz['id']" class="btn btn-secondary ms-2 ms-auto" >quizz</button>
                    </div>




                    <div class="modal fade" :id="'p'+quizz['id']" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Iniciar Quizz</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="pt-4 pb-5">
                                        <div class="row text-center">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-primary" @click="EnterQuizz(quizz['id'])">
                                                    criar uma sesssão
                                                </button>
                                            </div>
                                            <div class="col-md-6 mt-5 mt-md-0">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"  data-bs-dismiss="modal"  :data-bs-target="'#session'+quizz['id']">
                                                    juntar sessão
                                                </button>
                                            </div>
                                        </div>


                                    </div>

                                </div></div></div></div>



                        <div class="modal fade" :id="'session'+quizz['id']" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Entrar em quizz</h5>
                                        <button type="button" class="btn-close" data-bs-toogle="modal" aria-label="Close"
                                                data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-md-12">
                                            <label>
                                                <input type="text" class="form-control form-control-pergunta"
                                                       placeholder="Escreva o id do quizz aqui" :id="'sessionId'+quizz['id']">
                                            </label><br>
                                            <p :id="'Error'+quizz['id']"></p>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" @click="JoinQuizz(quizz['id'])">Entrar</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div class="card-box-text">
                            <h2>{{quizz['nome']}}</h2><br>
                            <p style="font-size: 16px">&nbsp;&nbsp;Perguntas: {{quizz['numeroperguntas']}}</p>
                            <button type="button"   class="btn btn-secondary ms-2 ms-auto"  data-bs-toggle="modal"  :data-bs-target="'#t'+quizz['id']" >Teste</button>
                        </div>


                        <div class="modal fade" :id="'t'+quizz['id']" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Entrar em quizz</h5>
                                        <button type="button" class="btn-close" data-bs-toogle="modal" aria-label="Close"
                                                data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Tem a certeza que quer fazer este teste?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="teste(quizz['id'])">Sim</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>

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
name: "quizzAluno",
    props: ['quizz_prop'],
    data(){
        return{
            myModal: '',
            toast: '',
            search:'',
            quizz: JSON.parse(this.quizz_prop)
        }
    },
    computed:{
        filter(){
            return this.quizz.filter((quizz)=>{
                return quizz['nome'].match(this.search);
            })
        }
    },
    methods: {
        EnterQuizz(quizz) {
            localStorage.clear();
            window.location.replace('/WaitRoomAluno/' + quizz);

        },
        teste(quizz) {


            let session = '_' + Math.random().toString(36).substr(2, 9);

            window.location.replace('/quizzTeste/' + quizz + '/' + session)
        },

        JoinQuizz(id) {
            $('#Error'+id).text(" ").css('color', 'red').css('opacity', '1');
            let sId = $('#sessionId' + id).val()
            console.log(sId)
            if (sId.length > 0) {
                localStorage.clear();
                window.location.replace('/InsideRoomStudent/' + sId+'/'+id );
            } else {
                $('#Error'+id).text("tem que inserir id ").css('color', 'red').css('opacity', '1');
            }

        },
        mounted() {
            localStorage.clear();
            Storage.clear();
            // this.disciplinas = JSON.parse(this.disciplinas)


        }
    }





}
</script>

<style scoped>

</style>
