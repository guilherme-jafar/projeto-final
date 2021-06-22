<template>

    <div class="forms">

        <form class="row mx-auto" >
            <div class="col-12">
                <label class="label" for="disciplina" >Disciplina</label>
                <input name="disciplina" class="form-control mt-2 mb-3 " type="text" id="disciplina" :value="disciplina['nome']">

            </div>
            <div class="col-12">
                <p class="error " id="editarDisciplinaError"></p>
            </div>
            <div class="col-12 mt-2">
                <label class="label" for="editarDescricao">Descrição</label>
                <textarea class="form-control"  name="descricao" id="editarDescricao" rows="2" :value="disciplina['descricao']"></textarea>
            </div>

            <div>
                <button type="button" class="btn btn-primary mt-4 btn-loading" :id="'editarUtilizadorBtn'" @click="editarDisciplina(disciplina)" >
                    <span class="">Guardar</span>
                    <div class="spinner-border text-light d-none" role="status">

                    </div>
                </button>
            </div>



        </form>



    </div>

</template>


<script>

    import $ from 'jquery';

    export default {
        name: "dashboard",
        props: ['disciplina_prop'],
        data(){
            return{
                toast: '',
                search:'',
                disciplina: JSON.parse(this.disciplina_prop),
                toastEliminar: '',

            }
        },
        methods: {

            editarDisciplina(disciplina){

                $('#editarUtilizadorBtn span').addClass('d-none');
                $('#editarUtilizadorBtn div').removeClass('d-none');

                if ($('#disciplina').val().length === 0){
                    $( "#editarDisciplinaError" ).text("Introduza o nome da disciplina").css('color', 'red').css('opacity', '1');
                    $('#submit span').removeClass('d-none');
                    $('#submit div').addClass('d-none');
                    //enviar = false;
                }else{
                    let formData = new FormData();
                    let desc= $('#editarDescricao').val().replace(/(\r\n|\n|\r)/gm, "");
                    formData.append( 'disciplina',$( "#disciplina" ).val());
                    formData.append( 'descricao',$( desc);
                    formData.append( 'id',disciplina['id']);
                    axios.post('/prof/disciplina/'+disciplina['id']+'/editar', formData).then(
                        function (response) {

                            if (response.data.message === "sucesso"){
                                window.location.replace('/prof/disciplina/sucesso/');

                            }
                        }.bind(this));
                }





            },
        },
        computed:{

        },
        mounted() {


        }


    }
</script>

