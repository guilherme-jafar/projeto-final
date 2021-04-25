@extends('layout/layout')


@section('content')


    <h2>Parabens {{session('utilizador')['nome']}}</h2>

    <h2>Acabou o quizz {{$nome}} com {{$res}} pontos</h2>


@endsection
