@extends('layout/layout')

@section('content')
    <div class="col-md-8 mx-auto">
        <div id="app">
            <div>
                <alunodashboard class="dashboard"
                                :disciplinas_prop="'{{json_encode($disciplinas, TRUE)}}'"></alunodashboard>

            </div>
        </div>
    </div>

    <script>
        import alunodashboard from "../../js/components/aluno/dashboadAluno";


        export default {

            components: {alunodashboard},
        }
    </script>
@endsection
