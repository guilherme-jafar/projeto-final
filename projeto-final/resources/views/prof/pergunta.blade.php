@extends('layout/layout')

@section('content')

    <div class="col-md-12 mx-auto">
        <div id="app" >

{{--            @if(session('estado'))--}}
{{--                <div class="alert alert-primary alert-dismissible fade show mb-5" role="alert" id="alert">--}}
{{--                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;Perfil alterado com sucesso</strong>--}}
{{--                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--                </div>--}}
{{--            @endif--}}

            <pergunta-editar  class="dashboard section-dashboard" :pergunta_prop="'{{json_encode($pergunta, TRUE)}}'"  ></pergunta-editar>


        </div>
    </div>

    <script >

    </script>
@endsection
