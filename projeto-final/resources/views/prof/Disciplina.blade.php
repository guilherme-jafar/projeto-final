@extends('layout/layoutDiscProf')


@section('2content')

    <div>
        <button type="button" class="btn btn-secondary" >Editar</button>
        <button type="button" class="btn btn-third">Topicos</button>
        <button type="button" class="btn btn-third" >Alunos</button>
        <button type="button" class="btn btn-third" >Quizz</button>
    </div><br>
        <div id="app">
            <div>

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
@endsection
