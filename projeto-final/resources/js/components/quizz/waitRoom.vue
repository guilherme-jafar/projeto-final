<template>
    <div class="real-time-test-prof">



        <audio id="music" loop>
            <source  src="assets/song.mp3" >
        </audio>

        <div class="wait-room text-center" id="waitRoom">


            <div class="box-sessao">

                <h2>Código da Sessão:</h2>
                <p>{{sessao}}</p>
            </div>


            <div class="players">
                <p>Jogadores: {{students}}</p>


                <div v-if="users.length !==0">

                    <div class=" text-center">
                        <div class="row" v-if="users.length === 1">
                            <div v-for="user in users" class="col-md-12"><span class="name-user">{{user}}</span></div>
                        </div>
                        <div class="row" v-else-if="users.length === 2">
                            <div v-for="user in users" class="col-md-6"><span class="name-user">{{user}}</span></div>

                        </div>
                        <div class="row" v-else>
                            <div v-for="user in users" class="col-md-4"><span class="name-user">{{user}}</span></div>
                        </div>


                    </div>
                </div>

            </div>
            <div class="footer">
                <div class="d-flex">

                    <button class="btn btn-primary" @click="sair()" id="sair">Sair</button>
                    <button class="ms-3 btn btn-primary" @click="sound('sound-2')"><i id="sound-2" class="bi bi-volume-mute"></i></button>
                    <button class="ms-auto btn btn-secondary" @click="start()" id="Inciar">Iniciar Quizz</button>


                </div>
            </div>


        </div>


        <div id="gameMode">
            <div class="gameMode">
                <div class="d-flex">
                    <p class="number">Numero de perguntas {{index -1 }}/{{Questions}}</p>
                    <button class="ms-auto btn btn-primary" @click="sound('sound')"><i id="sound" class="bi bi-volume-mute"></i></button>
                    <button class="btn btn-primary ms-3" id="esconderRespostas" @click="esconderRespostas()">Esconder Respostas
                    </button>
                    <button class="btn btn-secondary ms-3" id="next" @click="nextQuestion('next')">Proxima Pergunta
                    </button>
                    <button class="btn btn-primary ms-3" id="stop" @click="stopQuestion()">Parar Pergunta</button>
                    <button class="btn btn-third ms-3" id="submitLast" @click="submitLast()">Terminar Quizz</button>

                </div>

                <div class="mt-5">
                    <div>
                        <table>
                            <tr>
                                <th>Nome</th>
                                <th>Pontos</th>
                            </tr>
                            <tr id="tabela" v-for="(item,inde) in usersId" :key="item.users">
                                <td v-if="inde < 5"><!-- limitar para os cinco primeiros -->
                                    {{users[usersId.indexOf(item)]}}
                                </td>
                                <td v-if="inde < 5">{{points[usersId.indexOf(item)]}}</td>
                            </tr>
                        </table>
                        <!--                <p class="name-user"> </p>-->

                    </div>
                </div>


            </div>

            <div id="container" class="fazerTeste mx-auto">

                <div v-if="pergunta.length!==0">
                    <div class="pergunta text-start">
                        <p>{{ enunciado }}</p>

                    </div>


                    <div v-if="fileCheck()===1" class="text-center">

                        <img :src="'/images/Pergunta/Multimedia/'+pergunta['link']" alt="imagem da pergunta"
                             height="40%"
                             width="40%" class="mx-auto">
                    </div>
                    <div v-else-if="fileCheck()===2" class="text-center">

                        <video width="320" height="240" controls class="mx-auto">
                            <source id="questionMulti" :src="'/images/Pergunta/Multimedia/'+pergunta['link']" type="">
                        </video>
                    </div>
                    <div v-else-if="fileCheck()===3" class="text-center">

                        <audio controls>
                            <source id="questionMultiAudio" :src="'/images/Pergunta/Multimedia/'+pergunta['link']"
                                    type="">
                        </audio>
                    </div>
                    <div v-else-if="fileCheck()===0">

                    </div>

                    <div class="respostas mt-5" v-if="pergunta['tipo']==='multiple'">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1 mb-4" :style="'background-color:'+color[0]"
                                        ref="m0" id="m0" disabled
                                        v-show="multipleQuestion[0] !== null">&nbsp;{{multipleQuestion[0]}} {{
                                    Math.trunc(percentagem[0])}}%
                                </button>
                            </div>
                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1 mb-4" :style="'background-color:'+color[1]"
                                        ref="m1" id="m1" disabled
                                        v-show="multipleQuestion[1] !== null">&nbsp;{{multipleQuestion[1]}} {{
                                    Math.trunc(percentagem[1])}}%
                                </button>
                            </div>

                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1 mb-4" :style="'background-color:'+color[2]"
                                        ref="m2" id="m2" disabled
                                        v-show="multipleQuestion[2] !== null">&nbsp;{{multipleQuestion[2]}} {{
                                    Math.trunc(percentagem[2])}}%
                                </button>
                            </div>
                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1 mb-4" :style="'background-color:'+color[3]"
                                        ref="m3" id="m3" disabled
                                        v-show="multipleQuestion[3] !== null">&nbsp;{{multipleQuestion[3]}} {{
                                    Math.trunc(percentagem[3])}}%
                                </button>
                            </div>
                        </div>


                    </div>

                    <div class="respostas mt-5" v-else-if="pergunta['tipo']==='true/false'">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1  mb-4"
                                        :style="'background-color:'+color[1]" id="tf1" value="true" disabled
                                >True {{ Math.trunc(percentagem[1])}}%
                                </button>
                            </div>
                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1" :style="'background-color:'+color[2]"
                                        id="tf2" value="false" disabled
                                >False {{ Math.trunc(percentagem[2])}}%
                                </button>
                            </div>
                        </div>


                    </div>

                    <div class="respostas mt-5" v-else-if="pergunta['tipo']==='multiple-select'">

                        <div class="row">
                            <p class="text-center">
                                <span class="selecao-mul mx-auto" v-if="pergunta['tipo']==='multiple-select'"></span>
                            </p>
                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1  mb-4" :style="'background-color:'+color[0]"
                                        id="Qm0" disabled
                                        v-show="multipleQuestion[0] !== null">&nbsp;{{multipleQuestion[0]}} {{
                                    Math.trunc(percentagem[0])}}%
                                </button>
                            </div>
                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1 mb-4" :style="'background-color:'+color[1]"
                                        id="Qm1" disabled
                                        v-show="multipleQuestion[1] !== null">&nbsp;{{multipleQuestion[1]}} {{
                                    Math.trunc(percentagem[1])}}%
                                </button>
                            </div>

                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1 mb-4" :style="'background-color:'+color[2]"
                                        id="Qm2" disabled
                                        v-show="multipleQuestion[2] !== null">
                                    {{multipleQuestion[2]}} {{ Math.trunc(percentagem[2])}}%
                                    &nbsp;
                                </button>
                            </div>
                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1" :style="'background-color:'+color[3]"
                                        id="Qm3" disabled
                                        v-show="multipleQuestion[3] !== null">
                                    {{multipleQuestion[3]}} {{ Math.trunc(percentagem[3])}}%
                                    &nbsp;
                                </button>
                            </div>
                        </div>


                    </div>
                    <div class="respostas mt-5" v-if="pergunta['tipo']==='multiple-image'">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1 mb-4" :style="'background-color:'+color[0]"
                                        id="mi0" disabled
                                        v-show="multipleQuestion[0] !== null">
                                    &nbsp;
                                    <img :src="'/images/Pergunta/Multimedia/'+multipleQuestion[0]"
                                         v-show="multipleQuestion[0] !== null" alt="imagem da pergunta"
                                         :id="'mimg'+multipleQuestion[0]" height="40%"
                                         width="40%" class="mx-auto"> {{ Math.trunc(percentagem[0])}}%
                                </button>
                            </div>
                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1 mb-4" :style="'background-color:'+color[1]"
                                        id="mi1" disabled
                                        v-show="multipleQuestion[1] !== null">
                                    &nbsp;
                                    <img :src="'/images/Pergunta/Multimedia/'+multipleQuestion[1]"
                                         v-show="multipleQuestion[1] !== null" alt="imagem da pergunta"
                                         :id="'mimg'+multipleQuestion[1]" height="40%"
                                         width="40%" class="mx-auto"> {{ Math.trunc(percentagem[1])}}%
                                </button>
                            </div>

                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1 mb-4" :style="'background-color:'+color[2]"
                                        id="mi2" disabled
                                        v-show="multipleQuestion[2] !== null">
                                    &nbsp;
                                    <img :src="'/images/Pergunta/Multimedia/'+multipleQuestion[2]"
                                         v-show="multipleQuestion[2] !== null" alt="imagem da pergunta"
                                         :id="'mimg'+multipleQuestion[2]" height="40%"
                                         width="40%" class="mx-auto"> {{ Math.trunc(percentagem[2])}}%
                                </button>
                            </div>
                            <div class="col-md-12">
                                <button class="respostas-btn respostas-btn-1 mb-4" :style="'background-color:'+color[3]"
                                        id="mi3" disabled
                                        v-show="multipleQuestion[3] !== null">
                                    &nbsp;
                                    <img :src="'/images/Pergunta/Multimedia/'+multipleQuestion[3]"
                                         v-show="multipleQuestion[3] !== null" alt="imagem da pergunta"
                                         :id="'mimg'+multipleQuestion[3]" height="40%"
                                         width="40%" class="mx-auto"> {{ Math.trunc(percentagem[3])}}%
                                </button>
                            </div>
                        </div>


                    </div>


                </div>
            </div>
        </div>


        <div class="endGame" id="EndGame">

            <table>
                <tr>
                    <th>Nome</th>
                    <th>Pontos</th>
                </tr>
                <tr id="tabelaFim" v-for="(item,inde) in usersId" :key="item.users">
                    <td v-if="inde <= 5"><!-- limitar para os cinco primeiros -->
                        {{users[usersId.indexOf(item)]}}
                    </td>
                    <td v-if="inde <= 5">{{points[usersId.indexOf(item)]}}</td>
                </tr>
            </table>

<!--            <div id="tabelaFim" v-for="item in usersId" :key="item.users">-->
<!--                <p>{{users[usersId.indexOf(item)]}} {{points[usersId.indexOf(item)]}}</p>-->
<!--            </div>-->
            <button class="btn btn-primary mt-5" @click="endQuizz">Sair e Gravar</button>
        </div>



    </div>
</template>

<script>

    import axios from "axios";

    import Echo from "laravel-echo"
    import $ from "jquery";

    export default {
        name: "waitRoom",
        props: ['sessao_prop'],
        data() {
            return {
                stutus: '',

                usersId: [],
                users: [],
                points: [],
                questionPoints: [],
                resposta: [],
                image: 'false',
                enunciado: '',
                tipo: '',
                students: 0,
                couter: 0,
                index: 1,
                Questions: 0,
                pergunta: [],
                multipleQuestion: [],
                percentagem: [0, 0, 0, 0],
                solucoes: [0, 0, 0, 0],
                respostaQuizz: [],
                sessao: JSON.parse(this.sessao_prop),
                color: ['#dddddd', '#dddddd', '#dddddd', '#dddddd']


            }
        },
        watch: {
            currentRoom() {
                this.connect();
            }
        },


        // form.append('users', this.users);
        // form.append('points', this.points);
        methods: {
            esconderRespostas(){

                if ($('#container').hasClass('d-none')){
                    $('#container').removeClass('d-none')
                    $('#esconderRespostas').text('Esconder Respostas')
                }else {
                    $('#esconderRespostas').text('Mostrar Respostas')
                    $('#container').addClass('d-none')
                }


            },
            sound(id){

                if($('#' +id).hasClass('bi-volume-mute')){
                    $('#sound').addClass('bi-volume-up').removeClass('bi-volume-mute')
                    $('#sound-2').addClass('bi-volume-up').removeClass('bi-volume-mute')
                    $('#music')[0].play();
                }else{
                    $('#sound').removeClass('bi-volume-up').addClass('bi-volume-mute')
                    $('#sound-2').removeClass('bi-volume-up').addClass('bi-volume-mute')
                    $('#music')[0].pause();
                }
            },
            getResposta(Ans) {

                var respostas = Ans;


                if (this.pergunta['tipo'] === 'true/false') {
                    this.respostaQuizz = respostas[0]['resposta']

                } else if (this.pergunta['tipo'] === 'multiple') {

                    let i;
                    for (i = 0; i < respostas.length; i++) {

                        if (respostas[i]['resposta'] === " ") {
                            this.multipleQuestion[i] = null;

                        } else {
                            if (respostas[i]['resultado'] === 1) {
                                this.respostaQuizz = respostas[i]['resposta']
                            }

                            this.multipleQuestion[i] = respostas[i]['resposta'];

                        }
                    }
                    for (i = respostas.length; i < 4; i++) {
                        this.multipleQuestion[i] = null;
                    }

                } else if (this.pergunta['tipo'] === 'multiple-select') {
                    this.first = 0;
                    this.respostasMultiplas = [];
                    let i;
                    for (i = 0; i < respostas.length; i++) {
                        let k = i + 1
                        if (respostas[i]['resposta'] === " ") {
                            this.respostasMultiplas[i] = null;
                        } else {
                            if (respostas[i]['resultado'] === 1) {
                                this.respostasMultiplas.push(respostas[i]['resposta'])
                            }
                        }
                        this.respostasCertas = 0;
                        this.multipleQuestion[i] = respostas[i]['resposta'];
                    }
                    for (i = respostas.length; i < 4; i++) {
                        this.multipleQuestion[i] = null;
                    }
                } else if (this.pergunta['tipo'] === 'multiple-image') {

                    let i;
                    for (i = 0; i < respostas.length; i++) {

                        if (respostas[i]['resposta'] === " ") {
                            this.multipleQuestion[i] = null;

                        } else {
                            if (respostas[i]['resultado'] === 1) {
                                this.respostaQuizz = respostas[i]['resposta']
                            }

                            this.multipleQuestion[i] = respostas[i]['resposta'];

                        }
                    }
                    for (i = respostas.length; i < 4; i++) {
                        this.multipleQuestion[i] = null;
                    }

                }

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
            getExtension(filename) {

                const parts = filename.split('.');
                return parts[parts.length - 1];
            },
            endQuizz() {
                localStorage.clear();
                window.Echo.leave('room.' + this.sessao);
                axios.post('/EndRealTimeQuizz');
                window.location.replace('/')
            },
            start() {

                axios.post('/startQuizz').then(function (response) {

                    this.Questions = response.data.message
                    this.enunciado = response.data.quizz.enunciado
                    this.pergunta = response.data.quizz;
                    for (let i = 0; i < 4; i++) {
                        this.solucoes[i] = 0;
                        this.percentagem[i] = 0;
                    }
                    this.changeColor('darkred');
                    localStorage.setItem('percentagem', JSON.stringify(this.percentagem));
                    localStorage.setItem('solucoes', JSON.stringify(this.solucoes));
                    this.getResposta(response.data.res)
                    localStorage.setItem('status', 'game')
                    localStorage.setItem('questions', JSON.stringify(response.data.quizz));
                    localStorage.setItem('nQuestion', this.Questions)
                    localStorage.setItem('ansers', JSON.stringify(response.data.res));
                    $('#waitRoom').hide();
                    $('#gameMode').show();
                    $('#stop').show();
                    $('#next').hide();
                    $('#submitLast').hide();
                }.bind(this));

            },
            stopQuestion() {
                this.index++;
                localStorage.setItem('index', this.index);
                localStorage.setItem('state','false');
                axios.post('/StopQuestionQuizz').then(function (response) {
                    $('#waitRoom').hide();
                    $('#gameMode').show();
                    $('#stop').hide();
                    $('#next').show();
                    let form =new FormData();
                     form.append('users', this.users);
                     form.append('points', this.points);
                     axios.post('/GiveResults',form);
                }.bind(this));
                this.couter = -1;
                if (this.Questions < this.index) {
                    $('#stop').hide();
                    $('#next').hide();
                    $('#submitLast').show();
                    let form =new FormData();
                    form.append('users', this.users);
                    form.append('points', this.points);
                    axios.post('/GiveResults',form);
                    localStorage.setItem('state', 'submit')
                    $('#next').hide();

                }else {
                    axios.post('/StopQuestionQuizz').then(function (response) {
                        $('#waitRoom').hide();
                        $('#gameMode').show();
                        $('#stop').hide();
                        $('#next').show();

                    }.bind(this));
                    this.couter = -1;
                }
            },
            sair() {
                $('#sair').hide();
                $('#Inciar').hide()
                localStorage.clear();
                window.location.replace('/leaveRoom')
            },
            sleep(milliseconds) {
                const date = Date.now();
                let currentDate = null;
                while (currentDate - date < milliseconds) {
                    currentDate = Date.now();
                }
            },
            nextQuestion(tag) {
                localStorage.setItem('state', 'true');
                $('#next').hide();
                let form = new FormData();
                form.append('index', this.index);
                form.append('tag', tag);
                this.sleep(2000);
                this.couter = 0;


                axios.post('/NextQuestionQuizz', form).then(function (response) {

                    $('#waitRoom').hide();
                    $('#gameMode').show();
                    $('#stop').show();
                    $('#next').hide();


                });
            },
            changeColor(color) {
                var options = JSON.parse(localStorage.getItem('ansers'))

                if (options !== null) {
                    if (this.pergunta['tipo'] !== "true/false") {
                        for (let i = 0; i < options.length; i++) {
                            console.log(options[i]['resultado'])
                            if (options[i]['resultado'] === 1) {
                                this.color[i] = color

                            } else {
                                this.color[i] = 'darkred'
                            }

                        }
                    } else {

                        if (options[0]['resposta'] === "false") {
                            this.color[2] = color
                            this.color[1] = 'darkred'


                        } else {
                            this.color[2] = 'darkred'
                            this.color[1] = color
                        }


                    }
                }


            },
            submitLast() {
                let form = new FormData();
                form.append('users', this.users);
                form.append('points', this.points);

                axios.post('/EndQuizz', form).then(function (response) {


                }.bind(this));
                $('#gameMode').hide();
                $('#EndGame').show();
                localStorage.setItem('status', 'end');
            },
            connect() {

                window.Echo.private('room.' + this.sessao)
                    .listen('.NewStudent', e => {

                        if (e.Mainsession === this.sessao) {

                            if (!this.usersId.includes(e.userId) && e.type === 'student') {
                                this.usersId.push(e.userId);
                                this.users.push(e.name);
                                this.points.push(0);
                                this.resposta.push("");
                                this.students++;
                                if (this.students > 0) {
                                    $('#Inciar').show();
                                }
                                localStorage.setItem('user', JSON.stringify(this.users));
                                localStorage.setItem('userId', JSON.stringify(this.usersId));
                                localStorage.setItem('pontos', JSON.stringify((this.points)));
                                localStorage.setItem('students', this.students);
                            } else if (e.type === 'leavestudent') {
                                this.students--
                                this.usersId.splice(this.usersId.indexOf(e.userId), 1);
                                this.users.splice(this.users.indexOf(e.name), 1);
                                this.points.splice(this.users.indexOf(e.name), 1);
                                localStorage.setItem('students', this.students);
                                localStorage.setItem('userId', JSON.stringify(this.usersId));
                                localStorage.setItem('pontos', JSON.stringify((this.points)));
                                localStorage.setItem('user', JSON.stringify(this.users));
                                if (this.students === 0) {
                                    $('#Inciar').hide();
                                }

                            } else if (e.type === 'NextQuestion') {
                                this.points[this.usersId.indexOf(e.userId)] += parseInt(e.points);
                                this.resposta[this.usersId.indexOf(e.userId)] = e.answer;

                                if (this.pergunta['tipo'] !== "true/false" && this.pergunta['tipo'] !== "multiple-select") {

                                    for (let i = 0; i < 4; i++) {
                                        if (this.multipleQuestion[i] === e.answer) {
                                            this.solucoes[i]++;

                                            this.percentagem[i] = Math.round((this.solucoes[i] / this.students) * 100);
                                        }

                                    }
                                    this.changeColor('#7FBA27');

                                }  else if(this.pergunta['tipo'] === "multiple-select"){
                                    let array=JSON.parse(e.answer)

                                    for (let i = 0; i < 4; i++) {
                                        for (let k = 0; k < 2; k++) {

                                            if (this.multipleQuestion[i] === array[k]) {
                                                this.solucoes[i]++;

                                                this.percentagem[i] = Math.round((this.solucoes[i] / this.students) * 100);
                                            }
                                        }
                                    }
                                    this.changeColor('#7FBA27');

                                }

                                else {
                                    for (let i = 1; i < 3; i++) {
                                        if ($('#tf' + i).val() === e.answer) {
                                            this.solucoes[i]++;
                                            this.percentagem[i] = Math.round((this.solucoes[i] / this.students) * 100);
                                        }

                                    }
                                    this.changeColor('#7FBA27');

                                }
                                var that = this;
                                var list = [];
                                for (var j = 0; j < this.usersId.length; j++)
                                    list.push({
                                        'id': this.usersId[j],
                                        'name': this.users[j],
                                        'points': this.points[j],
                                        'resposta': this.resposta[j]
                                    });

                                list.sort(function (a, b) {
                                    return ((a.points < b.points) ? -1 : ((a.points === b.points) ? 0 : 1));
                                });

                                for (var k = 0; k < list.length; k++) {
                                    this.users[k] = list[k].name;
                                    this.usersId[k] = list[k].id;
                                    this.points[k] = list[k].points;
                                    this.resposta[k] = list[k].resposta;
                                }
                                this.users.reverse();
                                this.usersId.reverse();
                                this.points.reverse();
                                this.resposta.reverse();


                                if (e.tipo === 'multiple-image') {
                                    this.image = 'true'
                                } else {
                                    this.image = 'false'
                                }
                                localStorage.setItem('pontos', JSON.stringify(this.points));
                                localStorage.setItem('percentagem', JSON.stringify(this.percentagem));
                                localStorage.setItem('solucoes', JSON.stringify(this.solucoes));
                                $('#tabela').show();

                                this.couter++
                                if (this.students === this.couter) {
                                    this.index++;
                                    localStorage.setItem('index', this.index);
                                    localStorage.setItem('state', 'false');
                                    if (this.Questions < this.index) {
                                        $('#stop').hide();
                                        $('#next').hide();
                                        $('#submitLast').show();
                                        let form =new FormData();
                                        form.append('users', this.users);
                                        form.append('points', this.points);
                                        axios.post('/GiveResults',form);
                                        localStorage.setItem('state', 'submit')
                                        $('#next').hide();

                                    } else {
                                        $('#stop').hide();
                                        $('#next').show();
                                        let form =new FormData();
                                        form.append('users', this.users);
                                        form.append('points', this.points);
                                        axios.post('/GiveResults',form);
                                        $('#submitLast').hide();
                                    }


                                }

                            } else if (e.type === 'NewQuestion') {

                                this.pergunta = e.quizzArray;
                                this.enunciado = this.pergunta["enunciado"];
                                localStorage.setItem('questions', JSON.stringify(e.quizzArray));
                                localStorage.setItem('ansers', JSON.stringify(e.Ans));
                                for (let i = 0; i < 4; i++) {
                                    this.solucoes[i] = 0;
                                    this.percentagem[i] = 0;
                                }
                                this.changeColor('darkred');
                                localStorage.setItem('percentagem', JSON.stringify(this.percentagem));
                                localStorage.setItem('solucoes', JSON.stringify(this.solucoes));
                                this.getResposta(e.Ans)
                            }
                        }

                    });


            }


        },
        mounted() {
            $('#EndGame').hide();
            $('#gameMode').hide();
            $('#Inciar').hide();
            let l = window.location.href.split('/');
            this.sessionId = l[l.length - 1]
            this.couter = 0;


            if (localStorage.getItem('sessao')) {
                this.students = JSON.parse(localStorage.getItem('students'));
                this.points = JSON.parse(localStorage.getItem('pontos'))
                this.users = JSON.parse(localStorage.getItem('user'));
                this.usersId = JSON.parse(localStorage.getItem('userId'));


            } else {
                localStorage.setItem('sessao', this.sessao);
                localStorage.setItem('students', this.students);
                localStorage.setItem('userId', JSON.stringify(this.usersId));
                localStorage.setItem('pontos', JSON.stringify((this.points)));
                localStorage.setItem('user', JSON.stringify(this.users));
            }


            if (localStorage.getItem('status') === 'game') {

                this.Questions = localStorage.getItem('nQuestion')
                this.index = localStorage.getItem('index');

                this.pergunta = JSON.parse(localStorage.getItem('questions'));

                if (this.pergunta != null) {
                    this.enunciado = this.pergunta["enunciado"]
                    this.percentagem = JSON.parse(localStorage.getItem('percentagem'));
                    this.solucoes = JSON.parse(localStorage.getItem('solucoes'));
                    this.changeColor('#7FBA27');
                    this.getResposta(JSON.parse(localStorage.getItem('ansers')));




                    if (localStorage.getItem('state') === 'true') {
                        $('#waitRoom').hide();
                        $('#gameMode').show();
                        $('#stop').show();
                        $('#next').hide();
                        $('#submitLast').hide();
                        this.changeColor('darkred')
                    } else if (localStorage.getItem('state') === 'submit') {
                        $('#waitRoom').hide();
                        $('#gameMode').show();
                        $('#stop').hide();
                        $('#next').hide();
                        $('#submitLast').show();
                        let form =new FormData();
                        form.append('users', this.users);
                        form.append('points', this.points);
                        axios.post('/GiveResults',form);
                        $('#next').hide();
                    } else {
                        $('#waitRoom').hide();
                        $('#gameMode').show();
                        $('#stop').hide();
                        $('#next').show();
                        let form =new FormData();

                        form.append('users', this.users);
                        form.append('points', this.points);
                        console.log(form)
                        axios.post('/GiveResults',form);
                        $('#submitLast').hide();
                    }
                }
            } else if (localStorage.getItem('status') === 'end') {
                this.Questions = localStorage.getItem('nQuestion')
                $('#waitRoom').hide();
                $('#gameMode').hide();
                $('#stop').hide();
                $('#next').hide();
                $('#EndGame').show();
            } else {
                $('#gameMode').hide();
                $('#waitRoom').show();
            }

            if (this.users.length !== 0) {
                $('#Inciar').show();
            }

            this.connect()


        },


    }
</script>

<style scoped>

</style>
