<template>

    <div>




        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp; <span>Disciplina adicionada com sucesso</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastEliminar" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp; <span>Disciplina eliminada com sucesso!!</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>






        <div v-if="disciplinas.length === 0" class="mx-auto">
            <h1 class="heanding-1">Ainda não tem nenhuma disciplina</h1>
            <!-- Button trigger modal -->
            <button type="button" class=" btn btn-new mt-5 mx-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="bi bi-plus-circle"></i> &nbsp;&nbsp; Adicionar Disciplina
            </button>


        </div>

        <div v-else class="section-disciplinas " >
            <div class="box-search mb-5">
                <input class=" form-control form-control-lg form-search" type="text" v-model="search" placeholder="Pesquisar disciplina...">
                <i class="bi bi-search"></i>
            </div>
            <div class="box-text mt-3 mb-4">
                <h2>Minhas Disciplinas</h2>


            </div>
            <ul >
                <li class="card-box mb-5" v-for="disciplina in filter" :key="disciplina['id']">


                    <div class="card-image me-5">

                    </div>
                    <div class="card-box-2">
                        <h2>  {{disciplina['nome']}}</h2>
                        <p>Descrição: {{disciplina['descricao']}}</p>
                        <div class="mt-5 d-flex">
                            <p>Tópicos: 0</p>
                            <p>Alunos:  {{disciplina['inscritos']}}</p>
                            <p>Quizes: 0</p>
                        </div>

                    </div>
                    <div class="card-box-3">
                        <div>

                            <div class="ms-auto dropdown">
                                <button class="" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" :data-bs-target="'#eliminar' + disciplina['id']">
                                            Eliminar
                                        </button>



                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item" @click="Enter(disciplina['id'])" >
                                            Entrar
                                    </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div>

                            <button class="btn btn-secondary" @click="Enter(disciplina['id'])">Entrar</button>
                        </div>

                    </div>

                    <!-- Modal -->
                    <div class="modal fade" :id="'eliminar' + disciplina['id']" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" :id="'tituloEliminar' + disciplina['id']">Eliminar {{disciplina['nome']}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h2>Tem certeza que deseja eliminar a disciplina {{disciplina['nome']}}?</h2>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary eliminar-btn" :id="'eliminarUtilizadorBtn' + disciplina['id']" @click="eliminarDisciplina(disciplina)" >
                                        <span class="">Sim</span>
                                        <div class="spinner-border text-light d-none" role="status">

                                        </div>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>




                </li>
            </ul>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar Disiplina</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-5 pb-5">
                        <form class="row mx-auto" id="adicionarDisciplina">
                            <div class="col-11">
                                <label class="label" for="disciplina" >Código Disciplina</label>
                                <input name="disciplina" class="form-control mt-2 mb-2 " type="text" id="disciplina">

                            </div>
                            <div class="col-12 mb-4">
                                <p class="error " id="disciplinaError"></p>
                            </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="submit" class="btn btn-secondary btn-submit" @click="submit()">  <span class="">Adicionar &nbsp;</span>
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

import $ from 'jquery';

export default {
    name: "alunodashboard",
    props: ['disciplinas_prop'],
    data(){
        return{
            myModal: '',
            toast: '',
            search:'',
           disciplinas: JSON.parse(this.disciplinas_prop),
            toastEliminar: '',
            modalDelete: ''
        }
    },


    methods: {
        eliminarDisciplina(disciplina){

            $('.eliminar-btn span').addClass('d-none');
            $('.eliminar-btn div').removeClass('d-none');

            this.modalDelete = bootstrap.Modal.getInstance(document.getElementById('eliminar' + disciplina['id']), {});


            axios.delete('/aluno/disciplina/delete/' + disciplina['id']).then(
                function (response) {

                    if (response.data.message !== "erro"){
                        $('.eliminar-btn span').removeClass('d-none');
                        $('.eliminar-btn div').addClass('d-none');
                        this.toastEliminar.show();
                        $('#toastEliminar').removeClass('d-none');
                        this.disciplinas = response.data.message
                        this.modalDelete.hide();
                    }
                }.bind(this));



        },

        submit(){

            var toast = new  bootstrap.Toast(document.getElementById('toast'), {delay: 10000})

            $('#submit span').addClass('d-none');
            $('#submit div').removeClass('d-none');
            $( "#disciplinaError" ).text("").css('color', 'red').css('opacity', '1');

            var enviar = true;

            if ($('#disciplina').val().length === 0){
                $( "#disciplinaError" ).text("Introduza o código de uma disciplina").css('color', 'red').css('opacity', '1');
                $('#submit span').removeClass('d-none');
                $('#submit div').addClass('d-none');
                enviar = false;
            }else{
                $( "#disciplinaError" ).text("").css('color', 'red').css('opacity', '1');
            }

            if (enviar){

                let formData = new FormData();
                formData.append( 'disciplina',$( "#disciplina" ).val());


                axios.post('/aluno/disciplina/addDisciplina', formData
                ).then(function (response) {




                    if (response.data.message === "erro"){


                        $( "#disciplinaError" ).text("O Código já foi introduzido!!").css('color', 'red').css('opacity', '1');

                        $('#submit span').removeClass('d-none');
                        $('#submit div').addClass('d-none');
                    }else if (response.data.message === "erro2"){
                        $( "#disciplinaError" ).text("O código introduzido não existe!!").css('color', 'red').css('opacity', '1');

                        $('#submit span').removeClass('d-none');
                        $('#submit div').addClass('d-none');
                    } else{
                        $('#submit span').removeClass('d-none');
                        $('#submit div').addClass('d-none');
                        $('#disciplina').val('')
                        this.myModal.hide()
                        this.disciplinas = response.data.message;
                        toast.show();
                        $('#toast').removeClass('d-none');

                    }
                }.bind(this));
            }
        },
        Enter(id){
            window.location.replace('/aluno/AlunoDisciplina/'+id)
        }
    },
    computed:{
        filter(){
            return this.disciplinas.filter((disciplina)=>{
                return disciplina['nome'].match(this.search);
            })
        }
    },
    mounted() {

        // this.disciplinas = JSON.parse(this.disciplinas)
        this.myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {})
        var toast = new  bootstrap.Toast(document.getElementById('toast'), {delay: 10000})
        toast.hide();
        this.toastEliminar = new  bootstrap.Toast(document.getElementById('toastEliminar'), {delay: 10000})
        this.toastEliminar.hide()
    }


}
</script>
