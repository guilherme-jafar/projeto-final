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



    @yield('2content')
    </div></div>

    </div>
    </div>
@endsection
