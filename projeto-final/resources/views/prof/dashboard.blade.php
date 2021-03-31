@extends('layout/layout')

@section('content')

    <div class="col-md-8 mx-auto">
        <div id="app" >
            <div>

                <dashboard class="dashboard section-dashboard" :disciplinas_prop="'{{json_encode($disciplinas, TRUE)}}'"></dashboard>

            </div>
        </div>
    </div>

<script >
    // import dashboard from "../../js/components/Professor/dashboard";
    //
    // export default {
    //     components: {dashboard},
    // }
</script>
@endsection
