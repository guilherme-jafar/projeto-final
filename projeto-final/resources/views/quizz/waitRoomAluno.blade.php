@extends('layout/layoutPergunta2')

@section('content2')


    <div id="app">
        <wait-room-aluno  :sessao_prop="'{{json_encode($session, TRUE)}}'"  :id_prop="'{{json_encode($id, TRUE)}}'" :quizz_prop="'{{json_encode($quizz, TRUE)}}'"></wait-room-aluno>
    </div>

@endsection
