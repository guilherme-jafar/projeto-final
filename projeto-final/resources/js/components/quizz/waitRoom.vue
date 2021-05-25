<template>
    <div>
        <div id="waitRoom">
        <p>{{students}}</p>
        <p>{{sessao}}</p>
        <button @click="sair()">cancel</button>
        <button @click="start()" id="Inciar">Iniciar Quizz</button>
            <p>{{users}}</p>

        </div>

<div id="gameMode">
    <p>Numero de perguntas {{index}}/{{Questions}}</p>
    <div id="tabela" v-for="item in usersId" :key="item.users">
            <p>{{users[usersId.indexOf(item)]}} {{points[usersId.indexOf(item)]}} {{resposta[usersId.indexOf(item)]}}</p>
    </div>
    <button id="stop" @click="stopQuestion()">Parar Pergunta</button>
    <button id="next" @click="nextQuestion('next')">Proxima Pergunta</button>

</div>

        <div id="EndGame">
            <div id="tabelaFim" v-for="item in usersId" :key="item.users">
                <p>{{users[usersId.indexOf(item)]}} {{points[usersId.indexOf(item)]}} {{resposta[usersId.indexOf(item)]}}</p>
            </div>
            <button @click="endQuizz">Sair e Gravar</button>
        </div>


    </div>
</template>

<script>

import axios from "axios";

import Echo from "laravel-echo"

export default {
    name: "waitRoom",
    props: ['sessao_prop'],
    data() {
        return {
            stutus:'',

                usersId: [],
                users: [],
                points: [],
                questionPoints:[],
                resposta:[],


            students: 0,
            couter:0,
            index:1,
            Questions:0,
            sessao: JSON.parse(this.sessao_prop),


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
            axios.post('/EndRealTimeQuizz');
            window.location.replace('/')
        },
        start(){

            axios.post('/startQuizz').then(function (response){

               this.Questions=response.data.message

               localStorage.setItem('status','game')
                localStorage.setItem('question',response.data.message);
                $('#waitRoom').hide();
                $('#gameMode').show();
                $('#stop').show();
                $('#next').hide();
            }.bind(this));

        },
        stopQuestion() {
            this.index++;
            localStorage.setItem('index',this.index);
            axios.post('/StopQuestionQuizz').then(function (response){
                $('#waitRoom').hide();
                $('#gameMode').show();
                $('#stop').hide();
                $('#next').show();
            });
            this.couter=-1;
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
        nextQuestion(tag){
            let form =new FormData();
            form.append('index',this.index);
            form.append('tag',tag);
            form.append('users',this.users);
            form.append('points',this.points);
            this.sleep(2000);
            this.couter=0;


            axios.post('/NextQuestionQuizz',form).then(function (response){
                $('#waitRoom').hide();
                $('#gameMode').show();
                $('#stop').show();
                $('#next').hide();


            });
        },
        connect() {

            window.Echo.private('room.'+this.sessao)
                .listen('.NewStudent', e => {

                    if (e.Mainsession===this.sessao) {

                        if (!this.usersId.includes(e.userId) && e.type==='student') {
                            this.usersId.push(e.userId);
                            this.users.push(e.name);
                            this.points.push(0);
                            this.resposta.push("");
                            this.students++;
                            if(this.students>0){
                                $('#Inciar').show();}
                            localStorage.setItem('user',JSON.stringify(this.users));
                            localStorage.setItem('userId',JSON.stringify(this.usersId));
                            localStorage.setItem('pontos',JSON.stringify((this.points)));
                            localStorage.setItem('students',this.students);
                        }
                        else if (e.type==='leavestudent'){
                            this.students--
                            this.usersId.splice(this.usersId.indexOf(e.userId), 1);
                            this.users.splice(this.users.indexOf(e.name), 1);
                            this.points.splice(this.users.indexOf(e.name), 1);
                            localStorage.setItem('students',this.students);
                            localStorage.setItem('userId',JSON.stringify(this.usersId));
                            localStorage.setItem('pontos',JSON.stringify((this.points)));
                            localStorage.setItem('user',JSON.stringify(this.users));
                            if(this.students===0){
                                $('#Inciar').hide();}

                        }
                        else if(e.type==='NextQuestion'){
                            this.points[this.usersId.indexOf(e.userId)]+=parseInt(e.points);
                            this.resposta[this.usersId.indexOf(e.userId)]=e.answer;
                            localStorage.setItem('pontos',JSON.stringify(this.points));
                            $('#tabela').show();

                            this.couter++
                            if (this.students===this.couter){
                                this.index++;
                                localStorage.setItem('index',this.index);

                                if (this.Questions<this.index){
                                    $('#stop').hide();
                                    $('#next').hide();
                                    let form =new FormData();
                                    form.append('users',this.users);
                                    form.append('points',this.points);

                                    axios.post('/EndQuizz',form ).then(function (response){


                                    }.bind(this));
                                    $('#gameMode').hide();
                                    $('#EndGame').show();
                                    localStorage.setItem('status','end');
                                }
                            else
                                {
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
            this.couter=0;



            if (localStorage.getItem('sessao')){
                this.students=JSON.parse(localStorage.getItem('students'));
                this.points=JSON.parse(localStorage.getItem('pontos'))
                this.users=JSON.parse(localStorage.getItem('user'));
                this.usersId=JSON.parse(localStorage.getItem('userId'));



            }
            else{
                localStorage.setItem('sessao',this.sessao);
                localStorage.setItem('students',this.students);
                localStorage.setItem('userId',JSON.stringify(this.usersId));
                localStorage.setItem('pontos',JSON.stringify((this.points)));
                localStorage.setItem('user',JSON.stringify(this.users));
            }


            if (localStorage.getItem('status')==='game'){
                this.Questions=localStorage.getItem('question')
                this.index=localStorage.getItem('index');
                $('#waitRoom').hide();
                $('#gameMode').show();
                $('#stop').hide();
                $('#next').show();
            }
            else if (localStorage.getItem('status')==='end'){
                this.Questions=localStorage.getItem('question')
                $('#waitRoom').hide();
                $('#gameMode').show();
                $('#stop').hide();
                $('#next').hide();
            }
            else{
                $('#gameMode').hide();
                $('#waitRoom').show();
            }


            this.connect()


        },




}
</script>

<style scoped>

</style>
