@extends('layout/layoutPergunta2')

@section('content2')



    <div id="app">

        <pergunta-quizz :pergunta_prop="'{{json_encode($quizz, TRUE)}}'"
                        :quizz_session="'{{json_encode($session, TRUE)}}'"></pergunta-quizz>

    </div>

    <div class="wrapper " >

        <div class="wrapper-in wrapper-wright">
            <div class="wrapper-in-2">
                <div class="resposta">
                    <span>Correta</span>
                </div>
                <div class="icon">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <span>+ </span><span id="couter-wright"></span><span> Pontos</span>
            </div>
        </div>

        <div class="wrapper-in wrapper-wrong">
            <div class="wrapper-in-2">
                <div class="resposta">
                    <span>Errada</span>
                </div>
                <div class="icon">
                    <i class="bi bi-x-circle"></i>
                </div>
                <span>+ </span><span id="couter">0</span><span> Pontos</span>
            </div>
        </div>

    </div>

    <script >
        $( document ).ready(function() {

            $('.wrapper').hide();
            $('.wrapper-wrong').hide();
            $('.wrapper-wright').hide();
        });
    </script>

    <style>

        .animation {
            display: flex;

        }
        .animation div {
            margin: 4rem;


            background-image: linear-gradient(145deg, rgba(255,255,255,0.5) 0%, rgba(0,0,0,0) 100%);
           // animation: bounce 1.5s 0.5s linear infinite;
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


@endsection
