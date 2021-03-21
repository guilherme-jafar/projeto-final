@extends('layout/layout')

@section('content')

<div>
    <dashboard class="dashboard" :data="'{{$disciplina}}'"></dashboard>
</div>

<script>
    import dashboard from "../../js/components/Professor/dashboard";
    export default {
        components: {dashboard}
    }
</script>
@endsection
