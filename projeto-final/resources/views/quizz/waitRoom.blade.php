@extends('layout/layoutPergunta2')

@section('content2')

<p>dsfsd</p>
<div id="app">
<wait-room :sessao_prop="'{{json_encode($sessao, TRUE)}}'"></wait-room>
</div>

@endsection
