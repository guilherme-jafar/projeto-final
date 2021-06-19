@extends('layout/layout')


@section('content')

    <div class="col-md-10 mx-auto">
        <div class="card card-disciplina section-dashboard">
            <div class="card-box mb-5">
                <div class="card-box-2">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card-image me-5">

                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-inside-disciplina">
                                <div>
                                    <h2>  {{session('disciplina')['nome']}}</h2>
                                    <i class="bi bi-three-dots-vertical"></i>
                                </div>
                                <div>
                                    <p>Descricao: {{session('disciplina')['descricao']}}</p>
                                </div>
                                <div class="mt-1">
                                    <p>Pontos: {{session('disciplina')->getPontos()}}</p>
                                    <p>Quizes: 0</p>
                                </div>
                            </div>
                            <div id="app2" class="mt-4">
                                <button type="button" class="btn btn-third ms-2" id="btn-chg-1" onclick="chg(1)">Quizz</button>
                                <button type="button" class="btn btn-ghost-2 ms-5" id="btn-chg-2" onclick="chg(2)">Historico</button>
                                <button type="button" class="btn btn-ghost-2 ms-5" id="btn-chg-3" onclick="chg(3)">Fórum</button>
                            </div>

                        </div>
                    </div>



                </div>
                <div class="card-box-3">
                    <div>

                    </div><br>

                    <div id="app">


                        <div id="quizz" >
                            <alunos-quizz :quizz_prop="'{{json_encode($quizz, TRUE)}}'" ></alunos-quizz>

                        </div>
                        <div id="forum" >
                            <forum-show  :tipo_props="'{{json_encode(session('utilizador')['tipo'], TRUE)}}'"></forum-show>

                        </div>

{{--                        <div id="historico" >--}}
{{--                            <historico-aluno></historico-aluno>--}}

{{--                        </div>--}}
                    </div>




                </div>


            </div>

        </div>
    </div>

    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>



    <script >
        $( document ).ready(function() {

            $('#quizz').show();

            $('#forum').hide()
            $('#historico').hide()

        });

        function chg(index){

            switch (index){
                case 1:
                    $('#quizz').show();

                    $('#forum').hide();
                    $('#btn-chg-1').addClass('btn-third').removeClass(' btn-ghost-2')
                    $('#btn-chg-2').removeClass('btn-third').addClass(' btn-ghost-2')
                    $('#btn-chg-3').removeClass('btn-third').addClass(' btn-ghost-2')
                    break;
                case 2:
                    $('#forum').hide();
                    $('#quizz').hide();
                    $('#historico').show();

                    $('#btn-chg-1').removeClass('btn-third').addClass(' btn-ghost-2')
                    $('#btn-chg-2').addClass('btn-third').removeClass(' btn-ghost-2')
                    $('#btn-chg-3').removeClass('btn-third').addClass(' btn-ghost-2')


                    break;
                case 3:
                    $('#quizz').hide();

                    $('#forum').show()
                    $('#btn-chg-1').removeClass('btn-third').addClass(' btn-ghost-2')
                    $('#btn-chg-2').removeClass('btn-third').addClass(' btn-ghost-2')
                    $('#btn-chg-3').addClass('btn-third').removeClass(' btn-ghost-2')


                    break;
            }





        }

        // import disciplinaProf from "../../js/components/Professor/disciplinaProf";
        //
        // export default {
        //     components: {disciplinaProf},
        //
        // }



    </script>
@endsection
