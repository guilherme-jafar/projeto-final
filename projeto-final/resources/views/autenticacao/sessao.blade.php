
@if($request->session()->exists('email'))

    @if (request()->session()->get('tipo') == 'prof')

        <script>  setTimeout(function(){window.location='/prof/dashboard'}); </script>
    @else
        <script>  setTimeout(function(){window.location='/aluno/dashboard'}); </script>
    @endif
@else
    <script> setTimeout(function(){window.location='/'}); </script>
@endif
