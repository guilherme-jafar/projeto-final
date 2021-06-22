@extends('layout/layout')

@section('content')

    <div class="col-xl-8 col-12 col-lg-10 mx-auto">
        <div id="app" >

            @if(session('estado'))
                <div class="alert alert-primary alert-dismissible fade show mb-5" role="alert" id="alert">
                    <strong><i class="bi bi-check-circle-fill"></i> &nbsp;&nbsp;Perfil alterado com sucesso</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif



            <div>

                <dashboard class="dashboard section-dashboard" :disciplinas_prop="'{{json_encode($disciplinas, TRUE)}}'"></dashboard>

            </div>
        </div>
    </div>

<script >

</script>
@endsection
