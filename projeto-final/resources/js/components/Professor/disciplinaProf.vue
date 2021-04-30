<template>


    <div class="section-topicos mt-5 me-md-5 ms-md-5">
        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" id="toast" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span>Tópico adicionado com sucesso!!</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div class="toast toast-primary align-items-center mb-5 mtn-5 d-none" style="width: 60%" id="toast-pergunta" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;
                        <span>Pergunta adicionada com sucesso!!</span> </strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>


        <div v-if="topicos.length === 0" class="mx-auto">
            <h1 class="heanding-1 mx-auto mt-5">Ainda não tem nenhum Topico</h1>
            <!-- Button trigger modal -->
            <button type="button" class=" btn btn-new mt-5 mx-auto" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                <i class="bi bi-plus-circle"></i> &nbsp;&nbsp; Adicionar Tópico
            </button>
        </div>
        <div v-else class="section-disciplinas-items ">
            <div class="box-search mb-5">
                <input class=" form-control form-control-lg form-search" type="text" v-model="search"
                       placeholder="Pesquisar topicos...">
                <i class="bi bi-search"></i>
            </div>
            <h1>Tópicos</h1>
            <ul>
                <li class="card-box mb-5 mt-4" v-for="topico in filter" :key="topico['id']">

                    <div class="card-box-text">
                        <h2>{{topico['nome']}}</h2><i class="bi bi-three-dots-vertical"></i>
                        <span data-bs-toggle="collapse" :data-bs-target="'#collapse'+topico['id']" aria-expanded="false"
                        :aria-controls="'collapse'+topico['id']" class="material-icons" @click="changeButton(topico['id'])">
                            <img :id="'img'+topico['id']" src="/assets/expand_more_black_24dp.svg">
                        </span>
                    </div>

                    <div class="mt-2">

                        <pergunta-topico :topico_id="topico['id']"></pergunta-topico>
                    </div>

                </li>
            </ul>


        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar topico</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-5 pb-5">
                        <form class="row mx-auto" id="adicionarDisciplina">
                            <div class="col-12">
                                <label class="label" for="topico">Topico</label>
                                <input name="disciplina" class="form-control mt-2 mb-3 " type="text" id="topico">

                            </div>
                            <div class="col-12 ">
                                <p class="error " id="disciplinaError"></p>
                            </div>
                            <div class="col-12 mt-2">
                                <label class="label" for="descricao">Descrição</label>
                                <textarea class="form-control" name="descricao" id="descricao" rows="2"></textarea>

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
        name: "disciplinaProf",
        props: ['topico_prop'],

        data() {
            return {
                search: '',
                topicos: JSON.parse(this.topico_prop)
            }
        }, methods: {

            changeButton(id) {
                if ($('#img' + id).attr('src') === '/assets/expand_more_black_24dp.svg') {
                    $('#img' + id).attr('src', '/assets/expand_less_black_24dp.svg')
                } else if ($('#img' + id).attr('src') === '/assets/expand_less_black_24dp.svg') {
                    $('#img' + id).attr('src', '/assets/expand_more_black_24dp.svg')
                }
            },

            submit() {
                let l = window.location.href.split('/');

                $('#submit span').addClass('d-none');
                $('#submit div').removeClass('d-none');
                var enviar = true;

                if ($('#topico').val().length === 0) {
                    $("#disciplinaError").text("Introduza o nome do topico").css('color', 'red').css('opacity', '1');
                    $('#submit span').removeClass('d-none');
                    $('#submit div').addClass('d-none');
                    enviar = false;
                } else {
                    $("#disciplinaError").text("").css('color', 'red').css('opacity', '1');
                }

                if (enviar) {

                    let formData = new FormData();
                    formData.append('topico', $("#topico").val());
                    formData.append('descricao', $("#descricao").val());
                    formData.append('id', l[l.length - 1]);
                    axios.post('/prof/Topico/create', formData
                    ).then(function (response) {


                        if (response.data.message !== "erro") {
                            $('#submit span').removeClass('d-none');
                            $('#submit div').addClass('d-none');
                            this.myModal.hide()
                            $('#topico').val('')
                            this.topicos = response.data.message;
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
                return this.topicos.filter((topico) => {
                    return topico['nome'].match(this.search)
                })
            }
        }, mounted() {

            // this.disciplinas = JSON.parse(this.disciplinas)
            this.myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {})
            this.toast = new bootstrap.Toast(document.getElementById('toast'), {delay: 10000})
            this.toast.hide();


        }

    }
</script>


