@extends('layout/layout')


@section('content')


    <div class="text-center card p-5">
        <h2>Parabens {{session('utilizador')['nome']}}</h2>

        <h2>Acabou o quizz {{$nome}} com {{$res}} pontos</h2>
    </div>




@endsection
