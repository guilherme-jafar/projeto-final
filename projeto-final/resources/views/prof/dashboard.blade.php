@extends('layout/layout')

@section('content')

<div>
    <dashboard class="dashboard" :disciplinas="'{{json_encode($disciplina, TRUE)}}'"></dashboard>
</div>

<script>
    import dashboard from "../../js/components/Professor/dashboard";
    export default {
        components: {dashboard},
    }
</script>
@endsection
