<template>
    <div>
        <div id="waitRoom">
        <p>{{students}}</p>
        <p>{{sessao}}</p>
        <button @click="sair()">cancel</button>
        <button @click="start()">Iniciar Quizz</button>
        <p>{{users}}</p>
        </div>

<div id="gameMode">
    <p>{{Questions}}</p>
    <button id="stop" @click="stopQuestion()">Parar Pergunta</button>
    <button id="next" @click="nextQuestion('next')">Proxima Pergunta</button>

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
            usersId:[],
            users: [],
            points:[],
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

        start(){

            axios.post('/startQuizz').then(function (response){

               this.Questions=response.data.message

                $('#waitRoom').hide();
                $('#gameMode').show();
                $('#stop').show();
                $('#next').hide();
            }.bind(this));

        },
        stopQuestion() {
            this.index++;
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
            form.append('tag',tag)
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

                    console.log(e.type)
                    if (e.Mainsession===this.sessao) {

                        if (!this.usersId.includes(e.userId) && e.type==='student') {
                            this.usersId.push(e.userId)
                            this.users.push(e.name)
                            this.points.push(0)
                            this.resposta.push("")
                            this.students++

                            localStorage.setItem('usersId',JSON.stringify(this.usersId));
                            localStorage.setItem('users',JSON.stringify(this.users));
                            localStorage.setItem('points',JSON.stringify(this.points))
                            localStorage.setItem('students',this.students);
                        }
                        else if (e.type==='leavestudent'){
                            this.students--
                            this.usersId.splice(this.usersId.indexOf(e.userId), 1);
                            this.users.splice(this.users.indexOf(e.name), 1);
                            this.points.splice(this.users.indexOf(e.name), 1);
                            localStorage.setItem('students',this.students);
                            localStorage.setItem('usersId',JSON.stringify(this.usersId));
                            localStorage.setItem('users',JSON.stringify(this.users));
                            localStorage.setItem('points',JSON.stringify(this.points))

                        }
                        else if(e.type==='NextQuestion'){
                            this.points[this.usersId.indexOf(e.userId)]+=e.points;
                            this.resposta[this.usersId.indexOf(e.userId)]=e.answer;
                            this.couter++
                            if (this.students===this.couter){
                                this.index++;
                                console.log(this.Questions+" "+this.index)

                                if (this.Questions<this.index){
                                    $('#stop').hide();
                                    $('#next').hide();

                                    axios.post('/EndQuizz').then(function (response){


                                    }.bind(this));

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
            $('#gameMode').hide();
            let l = window.location.href.split('/');
            this.sessionId = l[l.length - 1]
            this.couter=0;

            if (localStorage.getItem('sessao')!=null){
                this.students=JSON.parse(localStorage.getItem('students'));
                this.usersId=JSON.parse(localStorage.getItem('usersId'));
                this.points=JSON.parse(localStorage.getItem('points'));
                this.users=localStorage.getItem('users');
            }
            else{
                localStorage.setItem('sessao',this.sessao);
                this.usersId=[];
                this.users=[];
                this.points=[];
            }
            console.log(this.sessao)
            this.connect()


        },




}
</script>

<style scoped>

</style>
