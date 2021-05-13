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
    props: ['sessao_prop', 'id_prop','user_prop'],

    data() {
        return {
            students: JSON.parse(this.user_prop),
            sessao: JSON.parse(this.sessao_prop),
            MasterSessao: JSON.parse(this.id_prop),

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
            window.Echo.private('room.'+this.MasterSessao)
                .listen('.NewStudent', e => {

                    console.log(e)
                    if (e.Mainsession===this.sessao) {
                        if (this.usersId.includes(e.userId) && e.type==='student' ) {
                            this.usersId.push(e.userId)
                            this.users.push(e.name)
                            this.students++
                        }
                        if (e.type==='leaveTeacher') {
                           this.sair()

                        }
                    }





                });


        }



        },
        mounted() {

            this.connect();


        },

}
</script>

<style scoped>

</style>
