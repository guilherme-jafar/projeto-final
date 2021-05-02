<template>
    <div>
    <p>{{students}}</p>
        <p>{{this.sessao}}</p>
        <button @click="sair()">cancel</button>
    </div>
</template>

<script>

import axios from "axios";

import Echo from "laravel-echo"

export default {
    name: "waitRoom",
    props: ['sessao_prop', 'quizz_prop'],
    data() {
        return {
            users: [],
            students: 0,
            sessao: JSON.parse(this.sessao_prop),
            quizz: JSON.parse(this.quizz_prop)
        }
    },
    watch: {
        currentRoom() {
            this.connect();
        }
    },

    methods: {
        sair() {

            axios.post('/leaveRoom').then(function (response) {
                window.location.replace(response.data.message);


            })
        },
        connect() {
            // window.Echo.channel('room.'+this.sessao)
            //     .listen('.NewStudent', e => {
            //         console.log("dd")
            //         console.log(e)
            //         if (e.Mainsession===this.sessao) {
            //             this.users.push(e.name)
            //             this.students++
            //         }
            //
            //     });

            window.Echo.join('room.'+this.sessao)
                .here((users) => {
                    //
                })
                .joining((user) => {

                })
                .leaving((user) => {

                })
                .error((error) => {
                    console.error(error);
                });

        }


        },
        mounted() {
            let l = window.location.href.split('/');
            this.sessionId = l[l.length - 1]
            console.log(this.sessao)
            this.connect()


        },




}
</script>

<style scoped>

</style>
