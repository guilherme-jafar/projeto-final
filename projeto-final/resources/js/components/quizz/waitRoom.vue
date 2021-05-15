<template>
    <div>
    <p>{{students}}</p>
        <p>{{this.sessao}}</p>
        <button @click="sair()">cancel</button>
        <button @click="start()">Iniciar Quizz</button>
        <p>{{this.users}}</p>


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
            students: 0,
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

            axios.post('/startQuizz');
        },
        sair() {
            Echo.leaveChannel('room.'+this.sessao);
            localStorage.clear();
            window.location.replace('/leaveRoom')
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
                    }

                });



        }


        },
        mounted() {
            let l = window.location.href.split('/');
            this.sessionId = l[l.length - 1]
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
