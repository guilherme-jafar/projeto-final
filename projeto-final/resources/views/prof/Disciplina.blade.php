@extends('layout/layout')


@section('content')

    <div class="col-xl-10 col-12 col-lg-12 mx-auto">
        {{--    {{dd(session('estado'))}}--}}
        @if(session('estado'))
            <div class="alert alert-primary alert-dismissible fade show mb-5" role="alert" id="alert">
                <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;Disciplina editada com sucesso</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-disciplina section-dashboard">
            <div class="card-box mb-5">
                <div class="card-box-2">
                    <div class="row">
                        <div class="col-sm-4 col-lg-3">
                            <div class="card-image me-5">

                            </div>
                        </div>
                        <div class="col-sm-8 col-lg-9">
                            <div class=" card-inside-disciplina ms-lg-3 ms-1 mt-sm-0 mt-3">
                                <div>
                                    <h2>  {{session('disciplina')['nome']}}</h2>
                                    <div class="ms-auto">

                                        <div class="dropdown">
                                            <button class="" type="button" id="dropdownMenuButton1"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    <button type="button" class="dropdown-item" id="btn-chg-1"
                                                            onclick="chg(4)">Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item" id="btn-chg-1"
                                                            data-bs-toggle="modal" data-bs-target="#eliminar">
                                                        Eliminar
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p>Descricao: {{session('disciplina')['descricao']}}</p>
                                </div>
                                <div class="mt-1">
                                    <p>Tópicos: {{session('disciplina')->getTotalTopicos()}}</p>
                                    <p>Alunos: {{session('disciplina')['inscritos']}}</p>
                                    <p>Quizes: {{session('disciplina')->getTotalQuizz()}}</p>
                                </div>
                            </div>

                            <div class="modal fade" id="eliminar" tabindex="-1" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="tituloEliminar">{{session('disciplina')['nome']}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h2>Tem certeza que deseja eliminar a
                                                disciplina {{session('disciplina')['nome']}}?</h2>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancelar
                                            </button>
                                            <button type="button" class="btn btn-primary eliminar-btn"
                                                    id="eliminarDiscipinaBtn"
                                                    onclick="eliminarDisciplina('{{session('disciplina')['id']}}')">
                                                <span class="">Sim</span>
                                                <div class="spinner-border text-light d-none" role="status">

                                                </div>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="app2" class="mt-4 ms-lg-3 ms-1 box-buttons">
                                <button type="button" class="btn btn-third" id="btn-chg-2" onclick="chg(1)">Topicos
                                </button>
                                <button type="button" class="btn btn-ghost-2 ms-3" id="btn-chg-4" onclick="chg(3)">
                                    Quizz
                                </button>
                                <button type="button" class="btn btn-ghost-2 ms-3" id="btn-chg-3" onclick="chg(2)">
                                    Alunos
                                </button>
                                {{--                                <button type="button" class="btn btn-ghost-2 ms-3" id="btn-chg-5" onclick="chg(5)">--}}
                                {{--                                    Histórico--}}
                                {{--                                </button>--}}
                                <button type="button" class="btn btn-ghost-2 ms-3" id="btn-chg-6" onclick="chg(6)">
                                    Fórum
                                </button>
                                {{--                                <button type="button" class="btn btn-secondary ms-2" id="btn-chg-1" onclick="chg(4)">Editar</button>--}}
                            </div>

                        </div>
                    </div>


                </div>
                <div class="card-box-3">
                    <div>

                    </div>
                    <br>


                </div>

                <div id="app">

                    <div id="editarDisciplina">
                        <editar-disciplina
                            :disciplina_prop="'{{json_encode(session('disciplina'), TRUE)}}'"></editar-disciplina>

                    </div>
                    <div id="topics">
                        <disciplina-prof :topico_prop="'{{json_encode($topico, TRUE)}}'"></disciplina-prof>

                    </div>
                    <div id="quizz">
                        <quizz-prof :topico_prop="'{{json_encode($topico, TRUE)}}'"></quizz-prof>
                    </div>
                    <div id="alunos">

                        <disciplina-alunos></disciplina-alunos>

                    </div>


                    {{--                    <div id="historico">--}}
                    {{--                        <historico-prof></historico-prof>--}}

                    {{--                    </div>--}}
                    <div id="forum">

                        <forum-show :tipo_props="'{{json_encode(session('utilizador')['tipo'], TRUE)}}'"></forum-show>
                    </div>


                </div>
            </div>

        </div>
    </div>
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>



    <script>
        $(document).ready(function () {

            $('#topics').show();
            $('#alunos').hide();
            $('#quizz').hide();
            $('#editarDisciplina').hide()
            $('#historico').hide();
            $('#forum').hide()
        });


        function eliminarDisciplina(id) {
            $('.eliminar-btn span').addClass('d-none');
            $('.eliminar-btn div').removeClass('d-none');
            $.ajax({
                url: '/prof/disciplina/delete/' + id,
                type: 'DELETE',
                success: function (response) {
                    window.location.replace('/prof/dashboard');
                }
            });
        }

        function chg(index) {

            switch (index) {
                case 1:
                    $('#alunos').fadeOut();
                    $('#quizz').fadeOut();
                    $('#editarDisciplina').fadeOut()
                    $('#historico').fadeOut();
                    $('#forum').fadeOut()
                    $('#topics').fadeIn();
                    $('#btn-chg-2').addClass('btn-third')
                    $('#btn-chg-2').removeClass('btn-ghost-2')
                    $('#btn-chg-3').removeClass('btn-third')
                    $('#btn-chg-3').addClass('btn-ghost-2')
                    $('#btn-chg-4').removeClass('btn-third')
                    $('#btn-chg-4').addClass('btn-ghost-2')
                    $('#btn-chg-5').removeClass('btn-third')
                    $('#btn-chg-5').addClass('btn-ghost-2')
                    $('#btn-chg-6').removeClass('btn-third')
                    $('#btn-chg-6').addClass('btn-ghost-2')
                    $('#newTopic').show();
                    $('#newQuiz').addClass('d-none');
                    $('#newForum').addClass('d-none');
                    break;
                case 2:
                    $('#topics').fadeOut();
                    $('#alunos').fadeIn();
                    $('#quizz').fadeOut();
                    $('#historico').fadeOut();
                    $('#forum').fadeOut()
                    $('#editarDisciplina').fadeOut();
                    $('#btn-chg-3').addClass('btn-third')
                    $('#btn-chg-3').removeClass('btn-ghost-2')
                    $('#btn-chg-2').removeClass('btn-third')
                    $('#btn-chg-2').addClass('btn-ghost-2')
                    $('#btn-chg-4').removeClass('btn-third')
                    $('#btn-chg-4').addClass('btn-ghost-2')
                    $('#btn-chg-5').removeClass('btn-third')
                    $('#btn-chg-5').addClass('btn-ghost-2')
                    $('#btn-chg-6').removeClass('btn-third')
                    $('#btn-chg-6').addClass('btn-ghost-2')
                    $('#newTopic').hide();
                    $('#newQuiz').addClass('d-none');
                    $('#newForum').addClass('d-none');
                    break;
                case 3:
                    $('#topics').fadeOut();
                    $('#alunos').fadeOut();
                    $('#quizz').fadeIn();
                    $('#historico').fadeOut();
                    $('#forum').fadeOut()
                    $('#editarDisciplina').fadeOut();
                    $('#btn-chg-3').removeClass('btn-third')
                    $('#btn-chg-3').addClass('btn-ghost-2')
                    $('#btn-chg-2').removeClass('btn-third')
                    $('#btn-chg-2').addClass('btn-ghost-2')
                    $('#btn-chg-5').removeClass('btn-third')
                    $('#btn-chg-5').addClass('btn-ghost-2')
                    $('#btn-chg-6').removeClass('btn-third')
                    $('#btn-chg-6').addClass('btn-ghost-2')
                    $('#newTopic').hide();
                    $('#newQuiz').removeClass('d-none');
                    $('#btn-chg-4').addClass('btn-third')
                    $('#btn-chg-4').removeClass('btn-ghost-2')
                    $('#newForum').addClass('d-none');

                    break;
                case 4:
                    $('#topics').fadeOut();
                    $('#alunos').fadeOut();
                    $('#quizz').fadeOut();
                    $('#historico').fadeOut();
                    $('#forum').fadeOut()
                    $('#editarDisciplina').fadeIn();
                    $('#btn-chg-3').removeClass('btn-third')
                    $('#btn-chg-3').addClass('btn-ghost-2')
                    $('#btn-chg-2').removeClass('btn-third')
                    $('#btn-chg-2').addClass('btn-ghost-2')
                    $('#btn-chg-5').removeClass('btn-third')
                    $('#btn-chg-5').addClass('btn-ghost-2')
                    $('#btn-chg-6').removeClass('btn-third')
                    $('#btn-chg-6').addClass('btn-ghost-2')
                    $('#newTopic').hide();
                    $('#newQuiz').addClass('d-none');
                    $('#btn-chg-4').removeClass('btn-third')
                    $('#btn-chg-4').addClass('btn-ghost-2')
                    $('#newForum').addClass('d-none');
                    break;
                case 5:
                    $('#topics').fadeOut();
                    $('#alunos').fadeOut();
                    $('#quizz').fadeOut();
                    $('#historico').fadeIn();
                    $('#forum').fadeOut()
                    $('#editarDisciplina').fadeOut();
                    $('#btn-chg-3').removeClass('btn-third')
                    $('#btn-chg-3').addClass('btn-ghost-2')
                    $('#btn-chg-2').removeClass('btn-third')
                    $('#btn-chg-2').addClass('btn-ghost-2')
                    $('#btn-chg-6').removeClass('btn-third')
                    $('#btn-chg-6').addClass('btn-ghost-2')
                    $('#newForum').addClass('d-none');
                    $('#newTopic').hide();
                    $('#newQuiz').addClass('d-none');
                    $('#btn-chg-4').removeClass('btn-third')
                    $('#btn-chg-4').addClass('btn-ghost-2')

                    $('#btn-chg-5').addClass('btn-third')
                    $('#btn-chg-5').removeClass('btn-ghost-2')
                    break;
                case 6:
                    $('#topics').fadeOut();
                    $('#alunos').fadeOut();
                    $('#quizz').fadeOut();
                    $('#historico').fadeOut();
                    $('#forum').fadeIn()
                    $('#editarDisciplina').fadeOut();
                    $('#btn-chg-3').removeClass('btn-third')
                    $('#btn-chg-3').addClass('btn-ghost-2')
                    $('#btn-chg-2').removeClass('btn-third')
                    $('#btn-chg-2').addClass('btn-ghost-2')
                    $('#newTopic').hide();
                    $('#newQuiz').addClass('d-none');
                    $('#newForum').removeClass('d-none');
                    $('#btn-chg-4').removeClass('btn-third')
                    $('#btn-chg-4').addClass('btn-ghost-2')
                    $('#btn-chg-5').removeClass('btn-third')
                    $('#btn-chg-5').addClass('btn-ghost-2')
                    $('#btn-chg-6').addClass('btn-third')
                    $('#btn-chg-6').removeClass('btn-ghost-2')
                    break;


            }


        }

        function tirarBtn(id) {
            $('#btn-chg-' + id).addClass('btn-third')
            $('#btn-chg-' + id).removeClass('btn-ghost-2')
        }

        // import disciplinaProf from "../../js/components/Professor/disciplinaProf";
        //
        // export default {
        //     components: {disciplinaProf},
        //
        // }


    </script>
@endsection
