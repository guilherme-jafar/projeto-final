<template>

<div>
    <p>{{students}}</p>
    <p>{{ MasterSessao}}</p>
    <button @click="sair()">cancel</button>

</div>
</template>

<script>
import Echo from "laravel-echo";

export default {
    name: "WaitRoomStudent",
    props: ['sessao_prop', 'id_prop','user_prop'],

    data() {
        return {
            usersId:[],
            users: [],
            students: JSON.parse(this.user_prop)+1,
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
            localStorage.clear();

                window.location.replace('/leaveRoom');


        },
        connect() {
            window.Echo.private('room.'+this.MasterSessao)
                .listen('.NewStudent', e => {

                    console.log(e)
                    if (e.Mainsession===this.MasterSessao) {
                        //console.log(!this.usersId.includes(e.userId) && e.type==='student')
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

                        }
                    }

                });


        }



        },
        mounted() {

            if (localStorage.getItem('sessao')!=null){
                this.students=localStorage.getItem('students');

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
