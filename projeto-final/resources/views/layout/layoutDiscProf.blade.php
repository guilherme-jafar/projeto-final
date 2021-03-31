{{--@extends('layout/layout')--}}


{{--@section('content')--}}

{{--    <div class="col-md-8 mx-auto">--}}
{{--        <div class="dashboard">--}}
{{--            <div class="card-box mb-5">--}}
{{--                <div class="card-image me-5">--}}

{{--                </div>--}}
{{--                <div class="card-box-2">--}}
{{--                    <h2>  {{session('disciplina')['nome']}}</h2>--}}
{{--                    <p>Descricao: {{session('disciplina')['id']}}</p>--}}
{{--                    <div class="mt-5">--}}
{{--                    <p>Tópicos: 0</p>--}}
{{--                    <p>Alunos: {{session('disciplina')['inscritos']}}</p>--}}
{{--                    <p>Quizes: 0</p>--}}
{{--                </div>--}}

{{--                </div>--}}
{{--                <div class="card-box-3">--}}
{{--                    <div>--}}
{{--                        <i class="bi bi-three-dots-vertical"></i>--}}
{{--                    </div>--}}
{{--                 @yield('2content')--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
@extends('layout/layout')


@section('content')

    <div class="col-md-8 mx-auto">
        <div class="dashboard">
            <div class="card-box mb-5">
                <div class="card-image me-5">

                </div>
                <div class="card-box-2">
                    <h2>  {{session('disciplina')['nome']}}</h2>
                    <p>Descricao: {{session('disciplina')['id']}}</p>
                    <div class="mt-5">
                        <p>Tópicos: 0</p>
                        <p>Alunos: {{session('disciplina')['inscritos']}}</p>
                        <p>Quizes: 0</p>
                    </div>

                </div>
                <div class="card-box-3">
                    <div>
                        <i class="bi bi-three-dots-vertical"></i>
                    </div>
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
                </div>
            </div>

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
