@extends('layout/layout')

@section('content')
    <div class="col-md-8 mx-auto">
        <div id="app">
            <div>

                @if(session('estado'))
                    <div class="alert alert-primary alert-dismissible fade show mb-5" role="alert" id="alert">
                        <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;Perfil alterado com sucesso</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <alunodashboard class="dashboard section-dashboard"
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
