@extends('layout/layout')

@section('content')

    <div class="col-md-8 mx-auto">
        <div id="app" >
            <div>

                <editar-perfil class="section-editarPerfil" :utilizador_props="'{{json_encode(session('utilizador'), TRUE)}}'" ></editar-perfil>

            </div>
        </div>
    </div>

@endsection
