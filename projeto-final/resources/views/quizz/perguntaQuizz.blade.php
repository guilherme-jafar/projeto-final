@extends('layout/layoutPergunta2')

@section('content2')



<div id="app">
    <pergunta-quizz :pergunta_prop="'{{json_encode($quizz, TRUE)}}'" :quizz_session="'{{json_encode($session, TRUE)}}'"></pergunta-quizz>

</div>
<div class="wrapper" >

    <p id="couter"></p>
    <div class="yellow"></div>
    <div class="red"></div>
    <div class="blue"></div>
    <div class="violet"></div>
    </div>



@endsection
