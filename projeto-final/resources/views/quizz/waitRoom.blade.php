@extends('layout/layoutPergunta2')

@section('content2')

<div id="app">
<wait-room  :sessao_prop="'{{json_encode($session, TRUE)}}'"  ></wait-room>
</div>

@endsection
