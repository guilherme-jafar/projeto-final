<style>

    body {
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: white;
        /*background-image: linear-gradient(180deg, rgba(0,0,0,0.15) 0%, rgba(0,153,212,0) calc(15% + 100px), rgba(0,99,138,0) calc(85% + 100px), rgba(0,0,0,0.15) 100%);*/

    }
    div.container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    div > div {
        width: 3vw;
        height: 3vw;
        border-radius: 100%;
        margin: 2vw;
        background-image: linear-gradient(145deg, rgba(255,255,255,0.5) 0%, rgba(0,0,0,0) 100%);
        animation: bounce 1.5s 0.5s linear infinite;
    }
    .yellow {
        background-color: #FF7829;
    }

    .red {
        background-color: #F9B000;
        animation-delay: 0.1s;
    }

    .blue {
        background-color: #40C0F0;
        animation-delay: 0.2s;
    }

    .violet {
        background-color: #7FBA27;
        animation-delay: 0.3s;
    }

    @keyframes bounce {
        0%, 50%, 100% {
            transform: scale(1);
            filter: blur(0px);
        }
        25% {
            transform: scale(0.6);
            filter: blur(3px);
        }
        75% {
            filter: blur(3px);
            transform: scale(1.4);
        }
    }
</style>


<div class="container">
    <div class="yellow"></div>
    <div class="red"></div>
    <div class="blue"></div>
    <div class="violet"></div>
</div>



@if (request()->session()->get('tipo') == 'prof')

    <script> setTimeout(function(){window.location='/prof/dashboard'}, 6000); </script>
@else
    <script> setTimeout(function(){window.location='/aluno/dashboard'}, 6000); </script>
@endif
