@extends('layout/layoutPergunta2')

@section('content2')

<p>dsfsd</p>
<div id="app">
<wait-room  :sessao_prop="'{{json_encode($session, TRUE)}}'"  :quizz_prop="'{{json_encode($quizz, TRUE)}}'"></wait-room>
</div>

@endsection
