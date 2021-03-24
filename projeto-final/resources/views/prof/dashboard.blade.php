@extends('layout/layout')

@section('content')
    <div class="col-md-8 mx-auto">
        <div id="app">
            <div>
                <dashboard class="dashboard" :disciplinas="'{{json_encode($disciplina, TRUE)}}'"></dashboard>
            </div>
        </div>
    </div>
<script>
    import dashboard from "../../js/components/Professor/dashboard";
    export default {
        components: {dashboard},
    }
</script>
@endsection
