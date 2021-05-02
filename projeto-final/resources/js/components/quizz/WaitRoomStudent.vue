<template>

<div>
    <p>{{students}}</p>
    <p>{{ MasterSessao}}</p>

</div>
</template>

<script>
import Echo from "laravel-echo";

export default {
    name: "WaitRoomStudent",
    props: ['sessao_prop', 'id_prop', 'quizz_prop'],

    data() {
        return {
            students: 0,
            sessao: JSON.parse(this.sessao_prop),
            MasterSessao: JSON.parse(this.id_prop),
            quizz: JSON.parse(this.quizz_prop)
        }
    },
    watch: {
        currentRoom() {

            this.connect();
        }
    },

    methods: {

        connect() {
        //     window.Echo.channel('room.'+this.MasterSessao)
        //         .listen('.NewStudent', e => {
        //             console.log("dd")
        //             console.log(e)
        //             if (e.Mainsession===this.sessao) {
        //                 this.users.push(e.name)
        //                 this.students++
        //             }
        //
        //         });

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
            console.log(this.MasterSessao)
            this.connect();


        },

}
</script>

<style scoped>

</style>
