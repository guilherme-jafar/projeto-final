<template>
    <div>
        <div id="waitRoom">
        <p>{{students}}</p>
        <p>{{sessao}}</p>
        <button @click="sair()">cancel</button>
        <button @click="start()">Iniciar Quizz</button>
        <p>{{student.users}}</p>
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
            stutus:'',
            student: {
                usersId: [],
                users: [],
                points: [],
            },
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

                        if (!this.student.usersId.includes(e.userId) && e.type==='student') {
                            this.student.usersId.push(e.userId)
                            this.student.users.push(e.name)
                            this.student.points.push(0)
                            this.resposta.push("")
                            this.students++

                            localStorage.setItem('user',JSON.stringify(this.student));
                            localStorage.setItem('students',this.students);
                        }
                        else if (e.type==='leavestudent'){
                            this.students--
                            this.student.usersId.splice(this.usersId.indexOf(e.userId), 1);
                            this.student.users.splice(this.users.indexOf(e.name), 1);
                            this.student.points.splice(this.users.indexOf(e.name), 1);
                            localStorage.setItem('students',this.students);
                            localStorage.setItem('user',JSON.stringify(this.student));

                        }
                        else if(e.type==='NextQuestion'){
                            this.student.points[this.student.usersId.indexOf(e.userId)]+=e.points;
                            this.resposta[this.student.usersId.indexOf(e.userId)]=e.answer;
                            this.couter++
                            if (this.students===this.couter){
                                this.index++;


                                if (this.Questions<this.index){
                                    $('#stop').hide();
                                    $('#next').hide();

                                    axios.post('/EndQuizz').then(function (response){


                                    }.bind(this));
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
            $('#gameMode').hide();
            let l = window.location.href.split('/');
            this.sessionId = l[l.length - 1]
            this.couter=0;

            if (localStorage.getItem('status')==='game'){
                this.Questions=localStorage.getItem('question')
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

            if (localStorage.getItem('sessao')!=null){
                this.students=JSON.parse(localStorage.getItem('students'));
                this.student=JSON.parse(localStorage.getItem('user'));

                this.users=localStorage.getItem('users');
            }
            else{
                localStorage.setItem('sessao',this.sessao);
                this.student.usersId=[];
                this.student.users=[];
                this.student.points=[];
            }
            console.log(this.sessao)
            console.log(this.student)
            this.connect()


        },




}
</script>

<style scoped>

</style>
