<template>
    <div class="real-time-test-prof">
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
                            <div  v-for="user in users" class="col-md-12"><span class="name-user">{{user}}</span></div>
                        </div>
                        <div class="row" v-else-if="users.length === 2">
                            <div  v-for="user in users" class="col-md-6"><span class="name-user">{{user}}</span></div>

                        </div>
                        <div class="row" v-else>
                            <div  v-for="user in users" class="col-md-4"><span class="name-user">{{user}}</span></div>
                        </div>


                    </div>
                </div>

            </div>
            <div class="footer">
                <div class="d-flex">

                        <button class="me-auto btn btn-primary" @click="sair()">Sair</button>


                        <button class="ms-auto btn btn-secondary" @click="start()" id="Inciar">Iniciar Quizz</button>



                </div>
            </div>


        </div>

        <div class="gameMode" id="gameMode">
            <div class="d-flex">
                <p class="number">Numero de perguntas {{index -1 }}/{{Questions}}</p>
                <button class="btn btn-secondary ms-auto" id="next" @click="nextQuestion('next')">Proxima Pergunta</button>
                <button class="btn btn-primary ms-auto" id="stop" @click="stopQuestion()">Parar Pergunta</button>
            </div>

            <div id="tabela" v-for="(item,inde) in usersId" :key="item.users">
                <div v-if="inde <= 5"><!-- limitar para os cinco primeiros -->

                <p class="name-user">{{users[usersId.indexOf(item)]}} {{points[usersId.indexOf(item)]}}</p>

                </div>
                <div v-if="image==='true'">
                    <img :src="'/images/Pergunta/Multimedia/'+resposta[usersId.indexOf(item)]" alt="resposta"
                         height="40%"
                         width="40%">
                </div>
                <div v-else>
                    <p class="respostas" > {{resposta[usersId.indexOf(item)]}}</p>

                </div>
            </div>





        </div>

        <div class="endGame text-center" id="EndGame">

            <div id="tabelaFim" v-for="item in usersId" :key="item.users">
                <p>{{users[usersId.indexOf(item)]}} {{points[usersId.indexOf(item)]}}</p>
            </div>
            <button class="btn btn-primary" @click="endQuizz">Sair e Gravar</button>
        </div>


    </div>
</template>

<script>

    import axios from "axios";
    // import sortId from "sort-ids";
    // import reorder from "array-rearrange"
    import Echo from "laravel-echo"

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

                students: 0,
                couter: 0,
                index: 1,
                Questions: 0,
                sessao: JSON.parse(this.sessao_prop),


            }
        },
        watch: {
            currentRoom() {
                this.connect();
            }
        },

        methods: {

            endQuizz() {
                localStorage.clear();
                window.Echo.leave('room.' + this.sessao);
                axios.post('/EndRealTimeQuizz');
                window.location.replace('/')
            },
            start() {

                axios.post('/startQuizz').then(function (response) {

                    this.Questions = response.data.message

                    localStorage.setItem('status', 'game')
                    localStorage.setItem('question', response.data.message);
                    $('#waitRoom').hide();
                    $('#gameMode').show();
                    $('#stop').show();
                    $('#next').hide();
                }.bind(this));

            },
            stopQuestion() {
                this.index++;
                localStorage.setItem('index', this.index);
                axios.post('/StopQuestionQuizz').then(function (response) {
                    $('#waitRoom').hide();
                    $('#gameMode').show();
                    $('#stop').hide();
                    $('#next').show();
                });
                this.couter = -1;
            },
            sair() {

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


                let form = new FormData();
                form.append('index', this.index);
                form.append('tag', tag);
                form.append('users', this.users);
                form.append('points', this.points);
                this.sleep(2000);
                this.couter = 0;


                axios.post('/NextQuestionQuizz', form).then(function (response) {
                    $('#waitRoom').hide();
                    $('#gameMode').show();
                    $('#stop').show();
                    $('#next').hide();


                });
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
                                var that=this;
                                var list = [];
                                for (var j = 0; j < this.usersId.length; j++)
                                    list.push({'id':this.usersId[j],'name': this.users[j], 'points': this.points[j], 'resposta':this.resposta[j]});

                                list.sort(function(a, b) {
                                    return ((a.points < b.points) ? -1 : ((a.points === b.points) ? 0 : 1));
                                });

                                for (var k = 0; k < list.length; k++) {
                                    this.users[k] = list[k].name;
                                    this.usersId[k]=list[k].id;
                                    this.points[k]=list[k].points;
                                    this.resposta[k]=list[k].resposta;
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
                                $('#tabela').show();

                                this.couter++
                                if (this.students === this.couter) {
                                    this.index++;
                                    localStorage.setItem('index', this.index);

                                    if (this.Questions < this.index) {
                                        $('#stop').hide();
                                        $('#next').hide();
                                        let form = new FormData();
                                        form.append('users', this.users);
                                        form.append('points', this.points);

                                        axios.post('/EndQuizz', form).then(function (response) {


                                        }.bind(this));
                                        $('#gameMode').hide();
                                        $('#EndGame').show();
                                        localStorage.setItem('status', 'end');
                                    } else {
                                        $('#stop').hide();
                                        $('#next').show();
                                    }


                                }

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
                this.Questions = localStorage.getItem('question')
                this.index = localStorage.getItem('index');
                $('#waitRoom').hide();
                $('#gameMode').show();
                $('#stop').hide();
                $('#next').show();
            } else if (localStorage.getItem('status') === 'end') {
                this.Questions = localStorage.getItem('question')
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
