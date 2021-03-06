@extends('layout/layoutPergunta2')

@section('content2')


    <div id="app">
        <wait-room-aluno  :sessao_prop="'{{json_encode($session, TRUE)}}'"  :id_prop="'{{json_encode($id, TRUE)}}'"  :user_prop="'{{json_encode($users, TRUE)}}'"></wait-room-aluno>
    </div>




    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script >
        $( document ).ready(function() {
            //
            // $('.wrapper').hide();
            // $('.wrapper-wrong').hide();
            // $('.wrapper-wright').hide();
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
