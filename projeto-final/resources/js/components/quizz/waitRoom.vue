<template>
    <div>
    <p>{{students}}</p>
        <p>{{sessionId}}</p>
    </div>
</template>

<script>

import axios from "axios";

import Echo from "laravel-echo"

export default {
name: "waitRoom",

    data() {
        return {
            students:0,
            sessionId:'DSDS'
        }
    },
    watch:{
        currentRoom(){
          this.connect();
        }
    },

    methods:{
        connect()
        {
            let l = window.location.href.split('/');
            this.sessionId=l[l.length - 1]
            window.Echo.private('room'+l[l.length - 1])
                .listen('.NewStudent', e => {
                    console.log("dd")
                    this.students=e.num;

                })

        }
    },
    mounted() {
        let l = window.location.href.split('/');
        this.sessionId=l[l.length - 1]
        // window.Echo = new Echo({
        //     broadcaster: 'pusher',
        //     key: 'd6cfe66609c4185a1732',
        //     cluster:'eu',
        //     encrypted: true,
        //     forceTLS:true
        // });




    },


}
</script>

<style scoped>

</style>
