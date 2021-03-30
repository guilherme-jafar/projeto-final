@extends('layout/layoutDiscProf')


@section('2content')

    <div>
        <div id="app2">
        <button type="button" class="btn btn-secondary" onclick="chg(2)">Editar</button>
        <button type="button" class="btn btn-third" onclick="chg(1)">Topicos</button>
        <button type="button" class="btn btn-third"  onclick="chg(2)">Alunos</button>
        <button type="button" class="btn btn-third" onclick="chg(2)">Quizz</button>
        </div>
    </div><br>


        <div id="app">
            <div id="topics">
                <disciplina-prof
                    :topico_prop="'{{json_encode($topico, TRUE)}}'"></disciplina-prof>

            </div>

        </div>

    <script >

        import disciplinaProf from "../../js/components/Professor/disciplinaProf";

        export default {
            components: {disciplinaProf},

        }


    </script>
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script>

        function chg(index){

            switch (index){
                case 1:
                    $('#topics').fadeIn();
                    break;
                case 2:
                    $('#topics').fadeOut();
                    break;
            }
        }
    </script>

@endsection
