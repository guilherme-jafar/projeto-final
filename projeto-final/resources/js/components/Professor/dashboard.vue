<template>

    <div>

        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toast" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span>Disciplina adicionada com sucesso</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toastEliminar" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span>Disciplina eliminada com sucesso</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>


        <div v-if="disciplinas.length === 0" class="mx-auto">
            <h1 class="heanding-1">Ainda não tem nenhuma disciplina</h1>
            <!-- Button trigger modal -->
            <button type="button" class=" btn btn-new mt-5 mx-auto" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                <i class="bi bi-plus-circle"></i> &nbsp;&nbsp; Adicionar Disciplina
            </button>


        </div>

        <div v-else class="section-disciplinas ">
            <div class="box-search mb-5">
                <input class=" form-control form-control-lg form-search" type="text" v-model="search"
                       placeholder="Pesquisar disciplina...">
                <i class="bi bi-search"></i>
            </div>
            <div class="box-text mt-3 mb-4">
                <h2>Minhas Disciplinas</h2>


            </div>
            <ul>
                <li class="card-box mb-5" v-for="disciplina in filter" :key="disciplina['id']">

                    <div class="card-image me-5">

                    </div>

                    <div class="card-box-2 ">
                        <div class="d-flex box-1">
                            <h2> {{disciplina['nome']}}</h2>
                            <div class="ms-auto dropdown">
                                <button class="" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                :data-bs-target="'#eliminar' + disciplina['id']">
                                            Eliminar
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item" @click="Enter(disciplina)">
                                            Entrar
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-box-3">
                            <p class="descricao">Descricao: {{disciplina['descricao']}}</p>

                            <div class="mt-0 mt-md-5 d-sm-flex d-block">
                                <div >
<!--                                    <p>Tópicos: 0</p>-->
                                    <p>Alunos: {{disciplina['inscritos']}}</p>
<!--                                    <p>Quizes: 0</p>-->
                                </div>

                                <div class="ms-auto">
                                    <button type="button" class="btn btn-third" :data-bs-target="'#d'+disciplina['id']"
                                            data-bs-toggle="modal">Partilhar Código
                                    </button>
                                    <button type="button" class="btn btn-secondary ms-2 me-3" @click="Enter(disciplina)">Entrar
                                    </button>
                                </div>
                            </div>




                        </div>


                    </div>


                    <!-- Modal -->
                    <div class="modal fade" :id="'eliminar' + disciplina['id']" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" :id="'tituloEliminar' + disciplina['id']">
                                        {{disciplina['nome']}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h2>Tem certeza que deseja eliminar a disciplina {{disciplina['nome']}}?</h2>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar
                                    </button>
                                    <button type="button" class="btn btn-primary eliminar-btn"
                                            :id="'eliminarUtilizadorBtn' + disciplina['id']"
                                            @click="eliminarDisciplina(disciplina)">
                                        <span class="">Sim</span>
                                        <div class="spinner-border text-light d-none" role="status">

                                        </div>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade " :id="'d'+disciplina['id']" tabindex="-1"
                         :aria-labelledby="disciplina['id']" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" :id="'dds'+disciplina['id']">Codigo da disciplina</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex p-5">
                                    <input type="text" class="form-control copy-code" :id="disciplina['token']"
                                           :value="disciplina['token']" readonly>

                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" @click="copiarClipbord(disciplina['token'])">
                                        <!--                                        <i class="bi bi-files" data-bs-toggle="tooltip" data-bs-placement="left" title="Copiar" ></i>-->
                                        Copiar
                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>

                </li>
            </ul>
        </div>

        <!-- Modal -->
        <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar Disiplina</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-5 pb-5">
                        <form class="row mx-auto" id="adicionarDisciplina">
                            <div class="col-12">
                                <label class="label" for="disciplina">Disciplina</label>
                                <input name="disciplina" class="form-control mt-2 mb-3 " type="text" id="disciplina" >

                            </div>
                            <div class="col-12">
                                <p class="error " id="disciplinaError"></p>
                            </div>
                            <div class="col-12 mt-2">
                                <label class="label" for="descricao" >Descrição</label>
                                <textarea class="form-control" name="descricao" id="descricao" rows="2" @keyup.enter="submit()"></textarea>
                            </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="submit" class="btn btn-secondary btn-submit" @click="submit()"><span
                            class="">Adicionar &nbsp;</span>
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
        name: "dashboard",
        props: ['disciplinas_prop'],
        data() {
            return {
                myModal: '',
                toast: '',
                search: '',
                disciplinas: JSON.parse(this.disciplinas_prop),
                toastEliminar: '',
                modalDelete: ''
            }
        },
        methods: {

            copiarClipbord(id) {

                let copyText = document.getElementById(id);

                copyText.select();
                copyText.setSelectionRange(0, 99999);

                document.execCommand("copy");

            },
            eliminarDisciplina(disciplina) {

                $('.eliminar-btn span').addClass('d-none');
                $('.eliminar-btn div').removeClass('d-none');

                this.modalDelete = new bootstrap.Modal(document.getElementById('eliminar' + disciplina['id']), {});


                axios.delete('/prof/disciplina/delete/' + disciplina['id']).then(
                    function (response) {

                        if (response.data.message !== "erro") {
                            $('.eliminar-btn span').removeClass('d-none');
                            $('.eliminar-btn div').addClass('d-none');
                            this.toastEliminar.show();
                            $('#toastEliminar').removeClass('d-none');
                            this.disciplinas = response.data.message
                            $('.modal-backdrop').remove();
                            this.modalDelete.hide();
                        }
                    }.bind(this));


            },
            Enter(disciplina) {


                window.location.replace('/prof/Disciplina/' + disciplina['id'])
            },
            submit() {


                $('#submit span').addClass('d-none');
                $('#submit div').removeClass('d-none');
                var enviar = true;

                if ($('#disciplina').val().length === 0) {
                    $("#disciplinaError").text("Introduza o nome da disciplina").css('color', 'red').css('opacity', '1');
                    $('#submit span').removeClass('d-none');
                    $('#submit div').addClass('d-none');
                    enviar = false;
                } else {
                    $("#disciplinaError").text("").css('color', 'red').css('opacity', '1');
                }

                if (enviar) {

                    let formData = new FormData();
                    let desc = $('#descricao').val().replace(/(\r\n|\n|\r)/gm, "");
                    formData.append('disciplina', $("#disciplina").val());
                    formData.append('descricao', desc);

                    axios.post('/prof/disciplina/create', formData
                    ).then(function (response) {

                        if (response.data.message !== "erro") {
                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');
                            this.myModal.hide()
                            $('#disciplina').val('')
                            this.disciplinas = response.data.message;
                            this.toast.show();
                            $('#toast').removeClass('d-none');
                        } else {

                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');

                        }
                    }.bind(this));
                }
            },
        },
        computed: {
            filter: function () {
                return this.disciplinas.filter((disciplina) => {
                    return disciplina['nome'].match(this.search);
                })
            }
        },
        mounted() {

            // this.disciplinas = JSON.parse(this.disciplinas)
            this.myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {})
            this.toast = new bootstrap.Toast(document.getElementById('toast'), {delay: 10000})
            this.toast.hide();
            this.toastEliminar = new bootstrap.Toast(document.getElementById('toastEliminar'), {delay: 10000})
            this.toastEliminar.hide()
        }


    }
</script>

