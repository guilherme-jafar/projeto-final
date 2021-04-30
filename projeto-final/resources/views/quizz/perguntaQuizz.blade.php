@extends('layout/layoutPergunta2')

@section('content2')



    <div id="app">

        <pergunta-quizz :pergunta_prop="'{{json_encode($quizz, TRUE)}}'"
                        :quizz_session="'{{json_encode($session, TRUE)}}'"></pergunta-quizz>

    </div>
    <div class="wrapper">

        <div>
            <div>
                <span id="corretoErrado"></span>
                <span>+</span><span id="couter">12</span><span> Pontos</span>
            </div>
        </div>


    </div>


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
