<template>
<div>

<div id="game">
    <div v-if="pergunta.length===0">
    <p>{{students}}</p>


    <button @click="sair()">cancel</button>
    </div>



        <div v-else-if="pergunta.length!==0">
        <div id="container" class="fazerTeste mx-auto">

            <div class="counter d-flex">
                <span>{{ countDown }}</span>

            </div>


            <div class="pergunta text-start">
                <p>{{ enunciado }}</p>

            </div>


            <div v-if="fileCheck()===1" style="min-height: 30rem" class="text-center">

                <img :src="'/images/Pergunta/Multimedia/'+pergunta['link']" alt="imagem da pergunta" height="40%"
                     width="40%" class="mx-auto">
            </div>
            <div v-else-if="fileCheck()===2" style="min-height: 30rem" class="text-center">

                <video width="320" height="240" controls class="mx-auto">
                    <source id="questionMulti" :src="'/images/Pergunta/Multimedia/'+pergunta['link']" type="">
                </video>
            </div>
            <div v-else-if="fileCheck()===3" style="min-height: 30rem" class="text-center">

                <audio controls>
                    <source id="questionMultiAudio" :src="'/images/Pergunta/Multimedia/'+pergunta['link']"
                            type="">
                </audio>
            </div>
            <div v-else-if="fileCheck()===0" style="min-height: 30rem">

            </div>

            <div class="respostas mt-5" v-if="pergunta['tipo']==='multiple'">
                <div class="row">
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-1" :id="'Qm'+multipleQuestion[0]"  v-show="multipleQuestion[0] !== null" @click="response('multiple','0')">&nbsp;{{multipleQuestion[0]}}</button>
                    </div>
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-2" :id="'Qm'+multipleQuestion[1]" v-show="multipleQuestion[1] !== null" @click="response('multiple','1')">&nbsp;{{multipleQuestion[1]}}</button>
                    </div>

                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-3 mt-4" :id="'Qm'+multipleQuestion[2]" v-show="multipleQuestion[2] !== null" @click="response('multiple','2')">&nbsp;{{multipleQuestion[2]}}</button>
                    </div>
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-4 mt-4" :id="'Qm'+multipleQuestion[3]" v-show="multipleQuestion[3] !== null" @click="response('multiple','3')">&nbsp;{{multipleQuestion[3]}}</button>
                    </div>
                </div>


            </div>

            <div class="respostas mt-5" v-else-if="pergunta['tipo']==='true/false'">
                <div class="row">
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-1" id="tf1" value="true" @click="response('true_false','true')">True
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-2" id="tf2" value="false" @click="response('true_false','false')">False
                        </button>
                    </div>
                </div>


            </div>

            <div class="respostas mt-5" v-else-if="pergunta['tipo']==='multiple-select'">

                <div class="row">
                    <p class="text-center">
                      <span class="selecao-mul mx-auto" v-if="pergunta['tipo']==='multiple-select'">
                         Respostas<span> {{botaoEscolhido.length}}</span>  / {{respostasMultiplas.length}}
            </span>
                    </p>
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-1" :id="'Qm'+multipleQuestion[0]" v-show="multipleQuestion[0] !== null" @click="responseMultiplas('0')">&nbsp;{{multipleQuestion[0]}}
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-2" :id="'Qm'+multipleQuestion[1]" v-show="multipleQuestion[1] !== null" @click="responseMultiplas('1')">&nbsp;{{multipleQuestion[1]}}
                        </button>
                    </div>

                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-3 mt-4" :id="'Qm'+multipleQuestion[2]" v-show="multipleQuestion[2] !== null" @click="responseMultiplas('2')">{{multipleQuestion[2]}}
                            &nbsp;
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-4 mt-4" :id="'Qm'+multipleQuestion[3]" v-show="multipleQuestion[3] !== null" @click="responseMultiplas('3')">{{multipleQuestion[3]}}
                            &nbsp;
                        </button>
                    </div>
                </div>


            </div>


        </div>
        </div>
</div>

    <div id="tabela" v-show="tabela==='true'" v-for="(item,index) in student" :key="item">
        <p>{{index}} {{item}} </p>
    </div>
    <div id="resultado">
        {{resultado}}
        <button @click="endQuizz">Sair e Gravar</button>
    </div>


</div>
</template>

<script>
import Echo from "laravel-echo";
import $ from "jquery";
import axios from "axios";

export default {
    name: "WaitRoomStudent",
    props: ['sessao_prop', 'id_prop','user_prop'],

    data() {
        return {
            tabela:'false',
            student:[],
            status:'',
            timer: '',
            questionType: '',
            enunciado: '',
            valor: '',
            resposta: [],
            resultado: 0,
            res: 0,
            index: 0,
            countDown: 0,
            usersId:[],
            users: [],
            pergunta:[],
            students: JSON.parse(this.user_prop)+1,
            sessao: JSON.parse(this.sessao_prop),
            MasterSessao: JSON.parse(this.id_prop),
            first: 0,
            respostasMultiplas: [],
            respostasCertas: 0,
            respostasEscolhidas: [],
            botaoEscolhido: [],
            multipleQuestion:[],
            respondeu:'',

        }
    },
    watch: {
        currentRoom() {

            this.connect();
        }
    },

    methods: {
        endQuizz(){
            localStorage.clear();
            window.Echo.leave('room.'+this.sessao);
            let form=new FormData;
            form.append('nota',this.resultado)
            axios.post('/EndRealTimeQuizzAluno',form);
            window.location.replace('/')
        },
        countDownTimer() {
            if(this.countDown > 0) {
                this.timer = setTimeout(() => {
                    this.countDown -= 1
                   localStorage.setItem('timer',this.countDown)

                    this.countDownTimer()
                }, 1000)
            }
            else if(this.countDown ===0){
                localStorage.setItem('questionStatus','true');
                if (this.pergunta['tipo']==='multiple-select'){
                    this.responseMultiplas('erro')
                }else {
                    this.response(this.pergunta['tipo'], 'erro')
                }
            }
        },
        sair() {
            localStorage.clear();

                window.location.replace('/leaveRoom');


        },
        responseMultiplas(id) {
            if (!this.botaoEscolhido.includes(id)){
                this.botaoEscolhido.push(id);

                let resposta = this.multipleQuestion[id];
                if (id !== 'erro') {
                    for (let i = 0; i < this.respostasMultiplas.length; i++) {
                        if (resposta.toLowerCase() === this.respostasMultiplas[i].toLowerCase()) {
                            this.respostasCertas++;
                        }
                    }
                    this.first++;
                    this.respostasEscolhidas.push(resposta);
                    if (this.first === this.respostasMultiplas.length) {
                        if (this.respostasCertas === this.respostasMultiplas.length) {
                            let tempo = this.countDown;
                            let tempoTotal = this.pergunta['tempo']
                            let valorTotal = this.pergunta['valor']
                            this.res = Math.round((valorTotal * tempo) / tempoTotal);
                        } else {
                            this.res = 0;
                        }
                        $('.wrapper').show();

                        if (this.res > 0) {
                            $('.wrapper').css('background-color', '#66c036')
                            $('#couter-wright').text(this.res)
                            $('.wrapper-wright').show();
                            $('.wrapper-wrong').hide();
                        } else {
                            $('.wrapper').css('background-color', '#f9403e')
                            $('#couter').text(0)
                            $('.wrapper-wrong').show();
                            $('.wrapper-wright').hide();

                        }
                        this.resultado += parseInt(this.res);
                        clearTimeout(this.timer)
                        this.countDown = 0;
                        let form = new FormData();
                        form.append('id', this.pergunta['pId'])
                        form.append('pergunta', this.pergunta['enunciado'])
                        form.append('resposta', JSON.stringify(this.respostasEscolhidas))
                        form.append('resultado', this.res)
                        form.append('tipo', this.pergunta['tipo'])
                        form.append('sessioId', this.sessao)
                        axios.post('/setRespostaQuizz', form).then(function (response) {
                            this.respondeu='true';
                            localStorage.setItem('points',this.res);
                            localStorage.setItem('questionStatus',this.respondeu);
                            localStorage.setItem('resultado',this.resultado)

                        }.bind(this));
                    }
                }

            }

        },
        getExtension(filename) {
            var parts = filename.split('.');
            return parts[parts.length - 1];
        },
        fileCheck() {
            if (this.pergunta['link'] === null) {
                return 0;
            } else {
                let ext = this.getExtension(this.pergunta['link'])
                switch (ext.toLowerCase()) {
                    case 'jpeg':
                    case 'gif':
                    case 'bmp':
                    case 'png':
                    case 'jpg':
                        //etc
                        return 1;
                }
                switch (ext.toLowerCase()) {
                    case 'm4v':
                    case 'avi':
                    case 'mpg':
                    case 'mp4':
                        // etc
                        $('#questionMulti').attr("type", 'video/' + ext);
                        return 2;
                }
                switch (ext.toLowerCase()) {
                    case 'ogg':
                    case 'mpeg':
                    case 'mp3':
                        // etc
                        $('#questionMultiAudio').attr("src", 'audio/' + ext);
                        return 3;
                }
            }
            return 0;
        },
        timeout(ms) { //pass a time in milliseconds to this function
            return new Promise(resolve => setTimeout(resolve, ms));
        },
        connect() {
            window.Echo.private('room.'+this.MasterSessao)
                .listen('.NewStudent', e => {

                    if (e.Mainsession===this.MasterSessao) {

                        if ( e.type==='student') {
                            this.students++

                            localStorage.setItem('students',this.students);
                        }
                        else if (e.type==='leaveMaster') {

                           this.sair()

                        }
                        else if (e.type==='leavestudent'){
                            this.students--
                            localStorage.setItem('students',this.students);

                        }else if (e.type==='startQuizz'){

                          // $('#waitRoom').hide()
                            this.status='game'
                            localStorage.setItem('status',this.status)
                            localStorage.setItem('questions',JSON.stringify(e.quizzArray));
                            localStorage.setItem('ansers',JSON.stringify(e.Ans));
                            localStorage.setItem('resultado',this.resultado)
                           this.getResposta(e.quizzArray,e.Ans)

                        }else if (e.type==='NewQuestion'){
                            $('#game').hide();
                            this.student=e.usr;
                            this.tabela='true'
                            this.respondeu='false'
                            $('.wrapper').hide();
                            $('.wrapper-wrong').hide();
                            $('.wrapper-wright').hide();
                            localStorage.setItem('questions',JSON.stringify(e.quizzArray));
                            localStorage.setItem('ansers',JSON.stringify(e.Ans));
                            localStorage.setItem('resultado',this.resultado)
                            localStorage.setItem('questionStatus',this.respondeu);

                            var that = this;
                            setTimeout(function() {

                                $('#game').show();
                                that.getResposta(e.quizzArray,e.Ans)
                                that.tabela='false'}, 4000);


                        }
                        else if (e.type==='stop'){
                            if (!this.respondeu) {
                                if (this.pergunta['tipo'] === 'multiple-select') {
                                    this.responseMultiplas('erro')
                                } else {
                                    this.response(this.pergunta['tipo'], 'erro')
                                }
                                $('.wrapper').show();
                                $('.wrapper').css('background-color', '#f9403e')
                                $('#couter').text(0)
                                $('.wrapper-wrong').show();
                                $('.wrapper-wright').hide();
                            }
                        }
                        else if(e.type==='EndQuizz'){
                            localStorage.setItem('status','end');
                            $('.wrapper').hide();
                            $('#game').hide();
                            $('#resultado').show();
                        }



                    }

                });


        },
        sleep(milliseconds) {
            const date = Date.now();
            let currentDate = null;
            while (currentDate - date < milliseconds) {
                currentDate = Date.now();
            }


        },
        response(type,id) {
            let resposta;
             let tempo = this.countDown;
            let tempoTotal = this.pergunta['tempo']
            let valorTotal = this.pergunta['valor']
            if (type==='multiple'){
            resposta = this.multipleQuestion[id];}
            else{
            resposta=id;}


            if (id !== 'erro') {

                if (resposta.toLowerCase() === this.resposta.toLowerCase()){
                    this.res = Math.round((valorTotal * tempo) / tempoTotal);
                }else{
                    this.res = 0;
                }
            } else {
                this.res = 0;
            }

            $('.wrapper').show();

            if (this.res > 0) {
                $('.wrapper').css('background-color', '#66c036')
                $('#couter-wright').text(this.res)
                $('.wrapper-wright').show();
                $('.wrapper-wrong').hide();
            } else {
                $('.wrapper').css('background-color', '#f9403e')
                $('#couter').text(0)
                $('.wrapper-wrong').show();
                $('.wrapper-wright').hide();

            }
            this.resultado += this.res;
            // clearTimeout(this.timer)
            this.countDown = 0;
            let form = new FormData();
            form.append('id', this.pergunta['pId'])
            form.append('pergunta', this.pergunta['enunciado'])
            form.append('resposta', resposta)
            form.append('resultado', this.res)
            form.append('tipo', this.pergunta['tipo'])
            form.append('sessioId', this.sessao)
            axios.post('/setRespostaQuizz', form).then(function (response) {
                this.respondeu='true';

                localStorage.setItem('points',this.res);
                localStorage.setItem('questionStatus',this.respondeu);
                localStorage.setItem('resultado',this.resultado)

            }.bind(this));
            clearTimeout(this.timer);
        },
        getResposta(array,Ans){


            this.pergunta=array;
            var respostas=Ans;


            if (this.pergunta['tipo'] === 'true/false') {
                this.resposta = respostas[0]['resposta']

            } else if (this.pergunta['tipo'] === 'multiple') {

                let i;
                for (i = 0; i < respostas.length; i++) {

                    if (respostas[i]['resposta'] === " " ) {
                        this.multipleQuestion[i]=null;

                    } else {
                        if (respostas[i]['resultado'] === 1) {
                            this.resposta = respostas[i]['resposta']
                        }

                        this.multipleQuestion[i]=respostas[i]['resposta'];

                    }
                }
                for (i =respostas.length ; i < 4; i++){
                    this.multipleQuestion[i]=null;
                }

            } else if (this.pergunta['tipo'] === 'multiple-select') {


                this.first = 0;
                this.respostasMultiplas = [];
                let i;
                for ( i = 0; i < respostas.length; i++) {
                    let k = i + 1
                    if (respostas[i]['resposta'] === " ") {
                        this.respostasMultiplas[i]=null;
                    } else {
                        if (respostas[i]['resultado'] === 1) {
                            this.respostasMultiplas.push(respostas[i]['resposta'])
                        }
                    }
                    this.respostasCertas = 0;
                    this.multipleQuestion[i]=respostas[i]['resposta'];
                }
                for (i =respostas.length ; i < 4; i++){
                    this.multipleQuestion[i]=null;
                }
            }
            $('#tabela').hide();
            this.startQuestion();
            $('#quizz').show();
            this.respondeu='false';
            localStorage.setItem('questionStatus',this.respondeu);
            this.countDown=this.pergunta['tempo']
            this.countDownTimer();
        },

        startQuestion() {
            this.questionType = this.pergunta['tipo']
            this.enunciado = this.pergunta['enunciado']
            this.valor = this.pergunta['valor']
            this.countDown=this.pergunta['tempo']
        }



        },
        mounted() {
            $('.wrapper').hide();
            $('#quizz').hide();
            $('#tabela').hide();
            $('#game').show();
            $('#resultado').hide();
            if (localStorage.getItem('sessao')!=null){
                this.students=localStorage.getItem('students');
                this.MasterSessao=localStorage.getItem('sessao');

                if (localStorage.getItem('status')==='game'){

                    if (localStorage.getItem('questionStatus')==='true'){

                        this.countDown = 0;
                        this.respondeu=localStorage.getItem('questionStatus');
                        this.res=localStorage.getItem('points')
                        this.resultado=localStorage.getItem('resultado')

                        $('.wrapper').show();
                        $('#game').hide();
                        if (this.res > 0) {
                            $('.wrapper').css('background-color', '#66c036')
                            $('#couter-wright').text(this.res)
                            $('.wrapper-wright').show();
                            $('.wrapper-wrong').hide();
                        } else {
                            $('.wrapper').css('background-color', '#f9403e')
                            $('#couter').text(0)
                            $('.wrapper-wrong').show();
                            $('.wrapper-wright').hide();

                        }

                    }else{
                        this.resultado=localStorage.getItem('resultado')
                     $('.wrapper').hide();
                        this.getResposta(JSON.parse(localStorage.getItem('questions')),JSON.parse(localStorage.getItem('ansers')))
                        this.countDown=localStorage.getItem('timer')

                    }

                }else if (localStorage.getItem('status')==='end'){

                    this.resultado=localStorage.getItem('resultado')
                    $('#resultado').show()
                    $('#game').hide();
                  $('.wrapper').hide();
                }


            }
            else{
                localStorage.setItem('sessao',this.MasterSessao);
                localStorage.setItem('students',this.students);
            }

            this.connect();

        },

}
</script>

<style scoped>

</style>
